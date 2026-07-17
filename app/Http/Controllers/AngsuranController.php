use Illuminate\Support\Facades\DB;
use App\Models\Tagihan;

public function bayar(Request $request)
{
    $request->validate([
        'pendaftaran_id' => 'required|exists:pendaftarans,id',
        'buktiTransfer'  => 'required|image|max:2048',
    ]);

    return DB::transaction(function () use ($request) {
        $tagihan = Tagihan::where('pendaftaran_id', $request->pendaftaran_id)
            ->where('status', 'cicilan')
            ->orderBy('id')
            ->lockForUpdate()
            ->first();

        if (!$tagihan) {
            return back()->with('error', 'Tidak ada angsuran yang perlu dibayar. Mungkin sudah dibayar semua atau sedang diverifikasi.');
        }

        $path = $request->file('buktiTransfer')->store('bukti_bayar', 'public');

        $tagihan->update([
            'status'        => 'pending',
            'buktiTransfer' => $path,
            'tanggal_bayar' => now(), // atau biarkan null sampai admin verifikasi, tergantung alur Anda
        ]);

        return back()->with('success', 'Bukti pembayaran terkirim, menunggu verifikasi admin.');
    });
}