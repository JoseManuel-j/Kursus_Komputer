<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FotoKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FotoKegiatanController extends Controller
{
    private function formatFoto(FotoKegiatan $foto): array
    {
        return [
            'id'         => $foto->id,
            'judul'      => $foto->judul,
            'keterangan' => $foto->keterangan,
            'url'        => Storage::url('foto-kegiatan/' . $foto->nama_file),
            'urutan'     => $foto->urutan,
            'aktif'      => (bool) $foto->aktif,
        ];
    }

    // GET /api/foto-kegiatan — Rancangan Endpoint Foto Kegiatan (3.5.1.7), publik, cuma yang aktif
    public function index()
    {
        $foto = FotoKegiatan::where('aktif', true)
            ->orderBy('urutan')
            ->get()
            ->map(fn ($f) => $this->formatFoto($f));

        return response()->json([
            'status' => true,
            'data'   => $foto,
        ], 200);
    }

    // POST /api/admin/foto-kegiatan — Rancangan Endpoint Upload Foto Kegiatan (3.5.1.8), admin only
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'urutan'     => 'nullable|integer',
            'foto'       => 'required|image|max:5120', // max 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $namaFile = time() . '_' . uniqid() . '.' . $request->file('foto')->getClientOriginalExtension();
        $request->file('foto')->storeAs('public/foto-kegiatan', $namaFile);

        $foto = FotoKegiatan::create([
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'nama_file'  => $namaFile,
            'urutan'     => $request->urutan ?? 0,
            'aktif'      => true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Foto berhasil ditambahkan.',
            'data'    => [
                'id'        => $foto->id,
                'judul'     => $foto->judul,
                'nama_file' => $foto->nama_file,
            ],
        ], 201);
    }

    // PATCH /api/admin/foto-kegiatan/{id}/toggle — Rancangan Endpoint Toggle Status Foto (3.5.1.9), admin only
    public function toggle($id)
    {
        $foto = FotoKegiatan::find($id);

        if (! $foto) {
            return response()->json(['status' => false, 'message' => 'Foto tidak ditemukan.'], 404);
        }

        $foto->update(['aktif' => ! $foto->aktif]);

        return response()->json([
            'status'  => true,
            'message' => 'Status foto berhasil diperbarui.',
            'data'    => ['id' => $foto->id, 'aktif' => (bool) $foto->aktif],
        ], 200);
    }

    // DELETE /api/admin/foto-kegiatan/{id} — Rancangan Endpoint Hapus Foto Kegiatan (3.5.1.10), admin only
    public function destroy($id)
    {
        $foto = FotoKegiatan::find($id);

        if (! $foto) {
            return response()->json(['status' => false, 'message' => 'Foto tidak ditemukan.'], 404);
        }

        Storage::delete('public/foto-kegiatan/' . $foto->nama_file);
        $foto->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Foto berhasil dihapus.',
        ], 200);
    }
}
