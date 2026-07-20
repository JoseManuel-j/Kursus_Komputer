<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramKursusSeeder extends Seeder
{
    public function run()
    {
        DB::table('program_kursus')->insert([
            // ==========================================
            // PROGRAM PAKET (Tipe: reguler)
            // ==========================================
            [
                'nama_program' => 'Adm Perk. Dasar',
                'tipe_kelas' => 'reguler',
                'kategori' => 'paket',
                'deskripsi' => 'Pengenalan Komputer, Mengetik 10 Jari, Korespondensi, Microsoft Word, Microsoft Excel, Internet Basic User.',
                'jumlah_sesi' => 20,
                'biaya' => 2300000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adm Perk. Lanjutan',
                'tipe_kelas' => 'reguler',
                'kategori' => 'paket',
                'deskripsi' => 'Materi Microsoft Word, Excel, PowerPoint, Access, dan aplikasi penunjang lainnya.',
                'jumlah_sesi' => 30,
                'biaya' => 3400000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Practical Office (Intensif)',
                'tipe_kelas' => 'reguler',
                'kategori' => 'paket',
                'deskripsi' => 'Kelas intensif setiap hari. Mempelajari Microsoft Word, Excel, dan PowerPoint.',
                'jumlah_sesi' => 15,
                'biaya' => 2500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Graphic Design',
                'tipe_kelas' => 'reguler',
                'kategori' => 'paket',
                'deskripsi' => 'Menguasai Corel Draw, Adobe Illustrator, Adobe Photoshop, dan Adobe InDesign.',
                'jumlah_sesi' => 30,
                'biaya' => 3300000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Technical Support',
                'tipe_kelas' => 'reguler',
                'kategori' => 'paket',
                'deskripsi' => 'Pengenalan Sistem Operasi, Hardware, Merakit PC, BIOS Setting, Instalasi OS & Aplikasi, Networking & Troubleshooting.',
                'jumlah_sesi' => 20,
                'biaya' => 2700000,
                'created_at' => now(), 'updated_at' => now(),
            ],

            // ==========================================
            // PROGRAM SATUAN - REGULER
            // ==========================================
            [
                'nama_program' => 'Microsoft Word',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Microsoft Word.',
                'jumlah_sesi' => 10, 'biaya' => 850000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft Excel',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Microsoft Excel.',
                'jumlah_sesi' => 10, 'biaya' => 850000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft PowerPoint',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Microsoft PowerPoint.',
                'jumlah_sesi' => 6, 'biaya' => 650000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft Access',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Microsoft Access.',
                'jumlah_sesi' => 10, 'biaya' => 1250000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Mengetik 10 Jari',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Mengetik 10 Jari.',
                'jumlah_sesi' => 8, 'biaya' => 750000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'AutoCAD',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler AutoCAD.',
                'jumlah_sesi' => 10, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Corel Draw',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Corel Draw.',
                'jumlah_sesi' => 9, 'biaya' => 1300000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe Photoshop',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Adobe Photoshop.',
                'jumlah_sesi' => 9, 'biaya' => 1300000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe Illustrator',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Adobe Illustrator.',
                'jumlah_sesi' => 9, 'biaya' => 1300000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe InDesign',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Adobe InDesign.',
                'jumlah_sesi' => 9, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Wandershare Filmora',
                'tipe_kelas' => 'reguler',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Reguler Wandershare Filmora.',
                'jumlah_sesi' => 8, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],

            // ==========================================
            // PROGRAM SATUAN - PRIVATE
            // ==========================================
            [
                'nama_program' => 'Microsoft Word',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft Excel',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft PowerPoint',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 6, 'biaya' => 800000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Microsoft Access',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 10, 'biaya' => 1500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Mengetik 10 Jari',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 10, 'biaya' => 1000000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'AutoCAD',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2500000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Corel Draw',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2100000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe Photoshop',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2100000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe Illustrator',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2100000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Adobe InDesign',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2400000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Wandershare Filmora',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private. Bisa dilayani di rumah siswa atau lembaga.',
                'jumlah_sesi' => 12, 'biaya' => 2400000,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama_program' => 'Canva',
                'tipe_kelas' => 'private',
                'kategori' => 'satuan',
                'deskripsi' => 'Program Private Canva.',
                'jumlah_sesi' => 4, 'biaya' => 500000,
                'created_at' => now(), 'updated_at' => now(),
            ]
        ]);
    }
}