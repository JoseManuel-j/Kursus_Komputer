<?php

namespace App\Http\Controllers;

use App\Models\ProgramKursus;
use Illuminate\Http\Request;

class AdminProgramController extends Controller
{
    public function index()
    {
        $programs = ProgramKursus::orderBy('id', 'asc')->get();

        return view('admin.program', compact('programs'));
    }

    public function create()
    {
        return view('admin.tambah-program');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'tipe_kelas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_sesi' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0',
        ]);

        ProgramKursus::create([
            'nama_program' => $request->nama_program,
            'tipe_kelas' => $request->tipe_kelas,
            'deskripsi' => $request->deskripsi,
            'jumlah_sesi' => $request->jumlah_sesi,
            'biaya' => $request->biaya,
        ]);

        return redirect()
            ->route('admin.program')
            ->with('success', 'Program kursus berhasil ditambahkan!');
    }
}