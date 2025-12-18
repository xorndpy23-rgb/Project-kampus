<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // Halaman detail kegiatan
    public function show($slug)
    {
        // Data dummy, nanti bisa ambil dari DB
        $kegiatan = [
            'kajian' => [
                'title' => 'Kajian Rutin',
                'description' => 'Kajian Ba’da Maghrib setiap Selasa & Jumat bersama ustadz dan asatidz terpercaya.'
            ],
            'tpa' => [
                'title' => 'TPA & Tahfidz',
                'description' => 'Pembelajaran Al-Qur\'an, doa harian, dan hafalan untuk anak-anak setiap sore.'
            ],
            'baksos' => [
                'title' => 'Bakti Sosial',
                'description' => 'Kegiatan berbagi sembako, santunan dhuafa, dan bantuan kemanusiaan untuk masyarakat.'
            ]
        ];

        if(!array_key_exists($slug, $kegiatan)){
            abort(404);
        }

        return view('kegiatan.show', [
            'data' => $kegiatan[$slug]
        ]);
    }
}
