<?php

namespace App\Http\Controllers;

use App\Models\ProgramKursus;
use Illuminate\Http\Request;

class AdminProgramController extends Controller
{
    // Menampilkan daftar program kursus
    public function index()
    {
        $programs = ProgramKursus::orderBy('id', 'asc')->get();

        return view('admin.program', compact('programs'));
    }

    // Menampilkan halaman tambah program
    public function create()
    {
        return view('admin.tambah-program');
    }

    // Menyimpan program baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'tipe_kelas'   => 'required|string|max:255',
            'kategori'     => 'required|in:paket,satuan',
            'deskripsi'     => 'required|string',
            'jumlah_sesi'   => 'required|integer|min:1',
            'biaya'         => 'required|numeric|min:0',
        ]);

        ProgramKursus::create($validated);

        return redirect()
            ->route('admin.program')
            ->with('success', 'Program kursus berhasil ditambahkan!');
    }

    // Menampilkan halaman edit program
    public function edit($id)
    {
        $program = ProgramKursus::findOrFail($id);

        return view('admin.edit-program', compact('program'));
    }

    // Memperbarui data program
    public function update(Request $request, $id)
    {
        $program = ProgramKursus::findOrFail($id);

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'tipe_kelas'   => 'required|string|max:255',
            'kategori'     => 'required|in:paket,satuan',
            'deskripsi'     => 'required|string',
            'jumlah_sesi'   => 'required|integer|min:1',
            'biaya'         => 'required|numeric|min:0',
        ]);

        $program->update($validated);

        return redirect()
            ->route('admin.program')
            ->with('success', 'Program kursus berhasil diperbarui!');
    }
}