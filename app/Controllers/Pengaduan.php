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

    public function tambahPengaduan()
    {
        // Insert kedalam database
        $namaFile = date('ymdhis') . '.jpg';
        $data = [
            'tgl_pengaduan' => date('Y-m-d'),
            'nik' => session()->get('nik'),
            'isi_laporan' => $this->request->getVar('laporan'),
            'lokasi_kejadian' => $this->request->getVar('lokasi'),
            'foto' => $namaFile,
            'status' => '0'
        ];
        // Mengambil file foto dan memindahkan ke direktori
        $file_foto = $this->request->getFile('foto');
        $file_foto->move('uploads/foto-laporan/', $namaFile);

        session()->setFlashdata('pesan', 'Laporan berhasil ditambahkan.');
        return redirect()->to('/');
    }
}
