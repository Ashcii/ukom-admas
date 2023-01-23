<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengaduan;

class Pengaduan extends BaseController
{
    protected $modelPengaduan;
    protected $helpers = ['form', 'tgl_indo_helper'];

    public function __construct()
    {
        $this->modelPengaduan = new ModelPengaduan();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaduan Masyarakat',
            'pengaduan' => $this->modelPengaduan->getPengaduanAll(),
            'pengaduan_total' => $this->modelPengaduan->countAllResults(),
            'belum_ditangani' => $this->modelPengaduan->where('status', '0')->countAllResults(),
            'pengaduan_proses' => $this->modelPengaduan->where('status', 'proses')->countAllResults(),
            'pengaduan_selesai' => $this->modelPengaduan->where('status', 'selesai')->countAllResults()
        ];

        return view('/pengaduan/index', $data);
    }

    public function detailPengaduan($id)
    {
        $nik = session()->get('nik');
        $data = [
            'title' => 'Detail Pengaduan',
            'pengaduan' => $this->modelPengaduan->getPengaduan($id),
            'pengaduan_user' => $this->modelPengaduan->getPengaduanUser($id, $nik)
        ];

        return view('/pengaduan/detail', $data);
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
        if (!$this->validate([
            'judul_laporan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul laporan tidak boleh kosong!'
                ]
            ],
            'laporan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi laporan tidak boleh kosong!'
                ]
            ],
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi kejadian tidak boleh kosong!'
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]',
                'errors' => [
                    'uploaded' => 'Lampiran gambar tidak boleh kosong!'
                ]
            ]
        ])) {
            return redirect()->to('/buat-pengaduan')->withInput();
        }

        // Insert kedalam database
        $namaFile = date('ymdhis') . '.jpg';
        $data = [
            'tgl_pengaduan' => date('Y-m-d'),
            'jam_pengaduan' => date('H:i:s'),
            'nik' => session()->get('nik'),
            'judul_laporan' => $this->request->getVar('judul_laporan'),
            'isi_laporan' => $this->request->getVar('laporan'),
            'lokasi_kejadian' => $this->request->getVar('lokasi'),
            'foto' => $namaFile,
            'status' => '0'
        ];
        $this->modelPengaduan->insert($data);

        // Mengambil file foto dan memindahkan ke direktori
        $file_foto = $this->request->getFile('foto');
        $file_foto->move(FCPATH . 'uploads/foto-laporan/', $namaFile);

        session()->setFlashdata('pesan', 'Laporan berhasil ditambahkan.');
        return redirect()->to('/');
    }

    public function editPengaduan($id)
    {
        if (!$this->validate([
            'judul_laporan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul laporan tidak boleh kosong!'
                ]
            ],
            'isi_laporan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi laporan tidak boleh kosong!'
                ]
            ],
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi kejadian tidak boleh kosong!'
                ]
            ]
        ])) {
            return redirect()->to('/detail/' . $id . '')->withInput();
        }

        $data = [
            'tgl_pengaduan' => date('Y-m-d'),
            'jam_pengaduan' => date('H:i:s'),
            'judul_laporan' => $this->request->getVar('judul_laporan'),
            'isi_laporan' => $this->request->getVar('isi_laporan'),
            'lokasi_kejadian' => $this->request->getVar('lokasi')
        ];
        $this->modelPengaduan->update($id, $data);

        session()->setFlashdata('pesan', 'Laporan berhasil disunting.');
        return redirect()->to('/detail/' . $id . '');
    }

    public function hapusPengaduan($id)
    {
        $this->modelPengaduan->delete($id);

        session()->setFlashdata('pesan', 'Laporan pengaduan berhasil dihapus.');
        return redirect()->to('/');
    }
}
