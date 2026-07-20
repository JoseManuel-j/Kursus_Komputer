<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;
use Illuminate\Http\Request;

class AdminFotoController extends Controller
{
    public function index()
    {
        $fotos = FotoKegiatan::orderBy('urutan', 'asc')->get();
        return view('admin.foto.index', compact('fotos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto'  => 'required|mimes:jpeg,png,jpg|max:5120',
        ]);

        $namaFile = time() . '_' . uniqid() . '.' . $request->file('foto')->getClientOriginalExtension();
        
        // BYPASS SYMLINK: Langsung lempar ke folder public/Images/kegiatan
        $request->file('foto')->move(public_path('Images/kegiatan'), $namaFile);

        FotoKegiatan::create([
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'nama_file'  => $namaFile,
            'urutan'     => $request->urutan ?? 0,
            'aktif'      => 1,
        ]);

        return back()->with('success', 'Foto berhasil diupload untuk halaman depan!');
    }

    public function destroy(int $id)
    {
        $foto = FotoKegiatan::findOrFail($id);
        
        // Hapus fisik file-nya dari public/Images/kegiatan
        $path = public_path('Images/kegiatan/' . $foto->nama_file);
        if (file_exists($path)) {
            unlink($path);
        }
        
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus!');
    }
}