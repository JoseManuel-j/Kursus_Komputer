<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
    // GET /api/tagihan
    // Nampilin semua tagihan milik siswa yang lagi login, lengkap sama riwayat cicilannya
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $tagihans = Tagihan::whereHas('pendaftaran', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with([
                'pendaftaran.programKursus',
                'pembayaran' => function ($q) {
                    $q->orderBy('tanggal_bayar', 'asc');
                },
            ])
            ->orderBy('jatuh_tempo', 'asc')
            ->get()
            ->map(function ($tagihan) {
                return [
                    'id'             => $tagihan->id,
                    'pendaftaran_id' => $tagihan->pendaftaran_id,
                    'nama_program'   => $tagihan->pendaftaran->programKursus->nama_program ?? '-',
                    'tipe_kelas'     => $tagihan->pendaftaran->programKursus->tipe_kelas ?? null,
                    'jumlah'         => (float) $tagihan->jumlah,
                    'total_dibayar'  => (float) $tagihan->total_dibayar,
                    'sisa_tagihan'   => (float) $tagihan->sisa_tagihan,
                    'jatuh_tempo'    => $tagihan->jatuh_tempo,
                    'status'         => $tagihan->status, // lunas | belum_lunas | cicilan
                    'riwayat_pembayaran' => $tagihan->pembayaran->map(function ($p) {
                        return [
                            'id'            => $p->id,
                            'jumlah_bayar'  => (float) $p->jumlah_bayar,
                            'tanggal_bayar' => $p->tanggal_bayar,
                            'metode'        => $p->metode,
                            'bukti_bayar'   => $p->bukti_bayar ? asset('uploads/bukti_pembayaran/' . $p->bukti_bayar) : null,
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data tagihan',
            'data'    => $tagihans,
        ], 200);
    }

    // GET /api/tagihan/{id}
    public function show(Request $request, $id)
    {
        $tagihan = Tagihan::with(['pendaftaran.programKursus', 'pembayaran'])
            ->whereHas('pendaftaran', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->find($id);

        if (! $tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail tagihan',
            'data'    => [
                'id'            => $tagihan->id,
                'nama_program'  => $tagihan->pendaftaran->programKursus->nama_program ?? '-',
                'jumlah'        => (float) $tagihan->jumlah,
                'total_dibayar' => (float) $tagihan->total_dibayar,
                'sisa_tagihan'  => (float) $tagihan->sisa_tagihan,
                'jatuh_tempo'   => $tagihan->jatuh_tempo,
                'status'        => $tagihan->status,
                'riwayat_pembayaran' => $tagihan->pembayaran,
            ],
        ], 200);
    }

    // POST /api/tagihan/{id}/bayar
    // Dipakai siswa buat bayar cicilan (angsuran) dari 1 tagihan
    public function bayar(Request $request, $id)
    {
        $tagihan = Tagihan::with('pendaftaran')
            ->whereHas('pendaftaran', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->find($id);

        if (! $tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        if ($tagihan->status === 'lunas') {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan ini sudah lunas.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode'       => 'required|string|max:100',
            'bukti_bayar'  => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.numeric'  => 'Jumlah bayar harus berupa angka.',
            'metode.required'       => 'Metode pembayaran wajib diisi.',
            'bukti_bayar.required'  => 'Bukti pembayaran wajib diupload (JPG/PNG/PDF, maks 2MB).',
            'bukti_bayar.mimes'     => 'Format bukti pembayaran harus JPG, PNG, atau PDF.',
            'bukti_bayar.max'       => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim belum lengkap/valid.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cegah bayar melebihi sisa tagihan
        $sisaTagihan = $tagihan->sisa_tagihan;
        if ($request->jumlah_bayar > $sisaTagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah bayar melebihi sisa tagihan (Rp ' . number_format($sisaTagihan, 0, ',', '.') . ').',
            ], 422);
        }

        // Simpan file bukti bayar ke folder yang sama kayak flow web (public/uploads/bukti_pembayaran)
        $file = $request->file('bukti_bayar');
        $namaFile = time() . '_' . $request->user()->id . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti_pembayaran'), $namaFile);

        $pembayaran = Pembayaran::create([
            'tagihan_id'    => $tagihan->id,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'tanggal_bayar' => now(),
            'metode'        => $request->metode,
            'bukti_bayar'   => $namaFile,
        ]);

        // Update status tagihan sesuai total pembayaran terbaru
        $totalDibayar = $tagihan->pembayaran()->sum('jumlah_bayar');
        $tagihan->status = $totalDibayar >= $tagihan->jumlah ? 'lunas' : 'cicilan';
        $tagihan->save();

        return response()->json([
            'success' => true,
            'message' => $tagihan->status === 'lunas'
                ? 'Pembayaran berhasil dikirim, tagihan ini sudah lunas!'
                : 'Cicilan berhasil dikirim, menunggu konfirmasi admin.',
            'data'    => [
                'pembayaran'    => $pembayaran,
                'status_tagihan' => $tagihan->status,
                'sisa_tagihan'  => (float) $tagihan->fresh()->sisa_tagihan,
            ],
        ], 201);
    }
// =========================================================================
    // Endpoint di bawah ini namanya persis sesuai Bab 3.5.1 laporan KKP
    // (path /api/siswa/...). Method index()/show()/bayar() di atas TETAP ADA
    // dan tetap dipakai mobile app (formatnya lebih detail, ada riwayat
    // cicilan per tagihan buat ditampilin di layar "Lihat Angsuran").
    // =========================================================================

    // GET /api/siswa/tagihan — Rancangan Endpoint Tagihan Siswa (3.5.1.18)
    // Sesuai deskripsi laporan: tagihan yang BELUM lunas aja.
    public function siswaTagihan(Request $request)
    {
        $userId = $request->user()->id;

        $tagihan = Tagihan::whereHas('pendaftaran', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', '!=', 'lunas')
            ->with('pendaftaran.programKursus')
            ->orderBy('jatuh_tempo')
            ->get()
            ->map(function ($t) {
                return [
                    'id'          => $t->id,
                    'jumlah'      => (float) $t->jumlah,
                    'jatuh_tempo' => $t->jatuh_tempo,
                    'status'      => $t->status,
                    'program'     => $t->pendaftaran->programKursus->nama_program ?? '-',
                ];
            });

        return response()->json([
            'status' => true,
            'data'   => $tagihan,
        ], 200);
    }

    // POST /api/siswa/bayar — Rancangan Endpoint Bayar Tagihan (3.5.1.19)
    // Sama kayak bayar() di atas, cuma tagihan_id-nya dari request body (bukan URL).
    public function siswaBayar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tagihan_id'   => 'required|integer',
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode'       => 'required|string|max:100',
            'bukti_bayar'  => 'required|file|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $tagihan = Tagihan::with('pendaftaran')
            ->whereHas('pendaftaran', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->find($request->tagihan_id);

        if (! $tagihan) {
            return response()->json(['status' => false, 'message' => 'Tagihan tidak ditemukan.'], 404);
        }

        if ($tagihan->status === 'lunas') {
            return response()->json(['status' => false, 'message' => 'Tagihan ini sudah lunas.'], 422);
        }

        $sisaTagihan = $tagihan->sisa_tagihan;
        if ($request->jumlah_bayar > $sisaTagihan) {
            return response()->json([
                'status'  => false,
                'message' => 'Jumlah bayar melebihi sisa tagihan (Rp ' . number_format($sisaTagihan, 0, ',', '.') . ').',
            ], 422);
        }

        $file = $request->file('bukti_bayar');
        $namaFile = time() . '_' . $request->user()->id . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti_pembayaran'), $namaFile);

        $pembayaran = Pembayaran::create([
            'tagihan_id'    => $tagihan->id,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'tanggal_bayar' => now(),
            'metode'        => $request->metode,
            'bukti_bayar'   => $namaFile,
        ]);

        $totalDibayar = $tagihan->pembayaran()->sum('jumlah_bayar');
        $tagihan->status = $totalDibayar >= $tagihan->jumlah ? 'lunas' : 'cicilan';
        $tagihan->save();

        return response()->json([
            'status'  => true,
            'message' => 'Pembayaran berhasil.',
            'data'    => [
                'id'            => $pembayaran->id,
                'jumlah_bayar'  => (float) $pembayaran->jumlah_bayar,
                'metode'        => $pembayaran->metode,
                'tanggal_bayar' => $pembayaran->tanggal_bayar,
            ],
        ], 201);
    }

    // GET /api/siswa/riwayat-pembayaran — Rancangan Endpoint Riwayat Pembayaran (3.5.1.20)
    public function riwayatPembayaran(Request $request)
    {
        $userId = $request->user()->id;

        $riwayat = Pembayaran::whereHas('tagihan.pendaftaran', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('tagihan')
            ->orderByDesc('tanggal_bayar')
            ->get()
            ->map(function ($p) {
                return [
                    'id'             => $p->id,
                    'jumlah_bayar'   => (float) $p->jumlah_bayar,
                    'metode'         => $p->metode,
                    'tanggal_bayar'  => $p->tanggal_bayar,
                    'status_tagihan' => $p->tagihan->status ?? null,
                ];
            });

        return response()->json([
            'status' => true,
            'data'   => $riwayat,
        ], 200);
    }
}
