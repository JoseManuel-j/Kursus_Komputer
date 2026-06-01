<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index()
    {
        // Ambil data 28 kelas dari database
        $programs = DB::table('program_kursus')->orderBy('id', 'asc')->get();

        if ($programs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data program kursus belum tersedia.',
                'data'    => null
            ], 404);
        }

        // Return dalam bentuk JSON
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data program kursus',
            'data'    => $programs
        ], 200);
    }
}