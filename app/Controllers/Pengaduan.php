<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengaduan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengaduan Masyarakat'
        ];

        return view('/pengaduan/index', $data);
    }

    public function buatPengaduan()
    {
        $data = [
            'title' => 'Buat Pengaduan Baru'
        ];

        return view('/pengaduan/form-pengaduan', $data);
    }
}
