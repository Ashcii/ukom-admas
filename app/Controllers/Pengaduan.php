<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMasyarakat;
use App\Models\ModelPengaduan;
use App\Models\ModelTanggapan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengaduan extends BaseController
{
    protected $modelPengaduan, $modelTanggapan, $modelMasyarakat;
    protected $helpers = ['form', 'tgl_indo_helper'];

    public function __construct()
    {
        $this->modelPengaduan  = new ModelPengaduan();
        $this->modelTanggapan  = new ModelTanggapan();
        $this->modelMasyarakat = new ModelMasyarakat();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $data = [
            'title' => 'Pengaduan Masyarakat',
            'getStatus' => $this->request->getGet('status'),
            'pengaduan' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->orderBy('tgl_pengaduan DESC, jam_pengaduan DESC')
                ->paginate(5, 'halaman'),
            'pengaduanAdmin' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->orderBy('tgl_pengaduan DESC, jam_pengaduan DESC')
                ->findAll(),
            'pengaduanStatus' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->where('status', $status)
                ->paginate(5, 'halaman_filter'),
            'pager' => $this->modelPengaduan->pager,
            'pengaduan_total' => $this->modelPengaduan->countAllResults(),
            'belum_ditangani' => $this->modelPengaduan->where('status', '0')->countAllResults(),
            'pengaduan_proses' => $this->modelPengaduan->where('status', 'proses')->countAllResults(),
            'pengaduan_selesai' => $this->modelPengaduan->where('status', 'selesai')->countAllResults()
        ];
        return view('/pengaduan/index', $data);
    }

    public function detailPengaduan($id)
    {
        $id_masyarakat = session()->get('id_masyarakat');
        $data = [
            'title' => 'Detail Pengaduan',
            'pengaduan' => $this->modelPengaduan->getPengaduan($id),
            'tanggapan' => $this->modelTanggapan
                ->join('petugas', 'petugas.id_petugas = tanggapan.id_petugas')
                ->where('id_pengaduan', $id)
                ->orderBy('tgl_pengaduan DESC, jam_pengaduan DESC')
                ->findAll(),
            'pengaduan_user' => $this->modelPengaduan->getPengaduanUser($id, $id_masyarakat)
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
            ],
            'publish' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bagikan secara Anonim/Publik wajib dipilih!'
                ]
            ]
        ])) {
            return redirect()->to('/buat-pengaduan')->withInput();
        }

        // Insert kedalam database
        $namaFile = date('ymdhis') . '.jpg';
        $data = [
            'id_masyarakat' => session()->get('id_masyarakat'),
            'tgl_pengaduan' => date('Y-m-d'),
            'jam_pengaduan' => date('H:i:s'),
            'judul_laporan' => $this->request->getVar('judul_laporan'),
            'isi_laporan' => $this->request->getVar('laporan'),
            'lokasi_kejadian' => $this->request->getVar('lokasi'),
            'foto' => $namaFile,
            'publish' => $this->request->getVar('publish'),
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
        ])) {
            return redirect()->to('/detail/' . $id . '')->withInput();
        }
        $lokasi = $this->request->getVar('lokasi');
        if ($lokasi == '') {
            $lokasi = $this->request->getVar('lokasi_sebelum');
        } else {
            $lokasi = $this->request->getVar('lokasi');
        }

        $nama_foto = $this->request->getVar('foto_sebelum');

        if ($this->request->getFile('foto') != '') {
            $hapus_foto = unlink(FCPATH . '/uploads/foto-laporan/' . $this->request->getVar('foto_sebelum'));

            if ($hapus_foto) {
                $nama_foto = date('ymdhis') . '.jpg';
                $foto = $this->request->getFile('foto');
                $foto->move(FCPATH . '/uploads/foto-laporan', $nama_foto);
            } else {
                session()->setFlashdata('peringatan', 'Foto gagal diupload.');
                return redirect()->back();
            }
        }

        $data = [
            'tgl_pengaduan'     => date('Y-m-d'),
            'jam_pengaduan'     => date('H:i:s'),
            'judul_laporan'     => $this->request->getVar('judul_laporan'),
            'isi_laporan'       => $this->request->getVar('isi_laporan'),
            'lokasi_kejadian'   => $lokasi,
            'foto'              => $nama_foto
        ];
        $this->modelPengaduan->update($id, $data);

        session()->setFlashdata('pesan', 'Laporan berhasil disunting.');
        return redirect()->to('/detail/' . $id . '');
    }

    public function hapusPengaduan($id)
    {
        $foto = $this->request->getVar('foto');
        $hapus_foto = unlink(FCPATH . '/uploads/foto-laporan/' . $foto);

        if ($hapus_foto) {
            $this->modelPengaduan->delete($id);

            session()->setFlashdata('pesan', 'Laporan pengaduan berhasil dihapus.');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('peringatan', 'Laporan gagal dihapus.');
            return redirect()->back();
        }
    }

    public function ubahStatus($id)
    {
        $data_status = [
            'status' => $this->request->getVar('status')
        ];
        $this->modelPengaduan->update($id, $data_status);

        $pengaduan = $this->modelPengaduan->getPengaduan($id);

        if ($pengaduan->status == '0') {
            $tanggapan = 'Status pekerjaan diubah menjadi Belum Ditangani';
        } else if ($pengaduan->status == 'proses') {
            $tanggapan = 'Status pekerjaan diubah menjadi Sedang Dalam Proses';
        } else {
            $tanggapan = 'Status pekerjaan diubah menjadi Sudah Selesai';
        }

        $data_tambah = [
            'id_pengaduan'  => $id,
            'tgl_pengaduan' => date('Y-m-d'),
            'jam_pengaduan' => date('H:i:s'),
            'tanggapan'     => $tanggapan,
            'status'        => 'sistem',
            'id_petugas'    => session()->get('id_petugas')
        ];
        $this->modelTanggapan->insert($data_tambah);

        session()->setFlashdata('pesan', 'Status Pengerjaan Berhasil Diubah.');
        return redirect()->back();
    }

    public function tambahTanggapan($id)
    {
        if (!$this->validate([
            'tanggapan' => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'Tanggapan tidak boleh kosong.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        if ($this->request->getFile('foto') == null) {
            $file_foto = '';
        } else {
            $file_foto = $this->request->getFile('foto');
        }

        if ($file_foto == '') {
            $nama_file = '';
        } else {
            $nama_file = date('ymdhis') . '.jpg';
            $file_foto->move(FCPATH . '/uploads/foto-laporan', $nama_file);
        }

        echo $nama_file;

        $data = [
            'id_pengaduan'  => $id,
            'tgl_pengaduan' => date('Y-m-d'),
            'jam_pengaduan' => date('H:i:s'),
            'tanggapan'     => $this->request->getVar('tanggapan'),
            'status'        => 'pengguna',
            'foto'          => $nama_file,
            'id_petugas'    => session()->get('id_petugas')
        ];
        $this->modelTanggapan->insert($data);

        session()->setFlashdata('pesan', 'Tanggapan Berhasil Ditambahkan.');
        return redirect()->back();
    }

    public function hapusTanggapan($id)
    {
        $this->modelTanggapan->delete($id);

        session()->setFlashdata('pesan', 'Tanggapan Berhasil Dihapus.');
        return redirect()->back();
    }

    public function profil($id)
    {
        $status = $this->request->getGet('status');
        $data = [
            'title' => 'Profil Pelapor',
            'profil_data' => $this->modelMasyarakat
                ->where('id_masyarakat', $id)
                ->first(),
            'pengaduan_all' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('publish', 'publik')
                ->findAll(),
            'pengaduan' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('status', $status)
                ->where('publish', 'publik')
                ->findAll(),
            'jumlah' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('publish', 'publik')
                ->countAllResults(),
            'belum_ditangani' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('publish', 'publik')
                ->where('status', '0')
                ->countAllResults(),
            'proses' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('publish', 'publik')
                ->where('status', 'proses')
                ->countAllResults(),
            'selesai' => $this->modelPengaduan
                ->where('id_masyarakat', $id)
                ->where('publish', 'publik')
                ->where('status', 'selesai')
                ->countAllResults(),
            'get_status' => $this->request->getGet('status')
        ];

        return view('/pengaduan/profil', $data);
    }

    public function laporanBelum()
    {
        $data = [
            'title'     => 'Laporan Belum Ditangani',
            'pengaduan' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->where('status', '0')
                ->findAll(),
        ];

        return view('pengaduan/laporan-belum', $data);
    }

    public function xlsBelum()
    {
        $spreadsheet = new Spreadsheet();
        $pengaduan = $this->modelPengaduan
            ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
            ->where('status', '0')
            ->findAll();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Isi Pengaduan')
            ->setCellValue('E1', 'Status');

        $column = 2;

        foreach ($pengaduan as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $row['nama'])
                ->setCellValue('B' . $column, $row['nik'])
                ->setCellValue('C' . $column, $row['tgl_pengaduan'])
                ->setCellValue('D' . $column, $row['judul_laporan'])
                ->setCellValue('E' . $column, $row['status']);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Laporan Belum Ditangani';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function laporanProses()
    {
        $data = [
            'title'     => 'Laporan Sedang Diproses',
            'pengaduan' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->where('status', 'proses')
                ->findAll(),
        ];

        return view('pengaduan/laporan-proses', $data);
    }

    public function xlsProses()
    {
        $spreadsheet = new Spreadsheet();
        $pengaduan = $this->modelPengaduan
            ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
            ->where('status', 'proses')
            ->findAll();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Isi Pengaduan')
            ->setCellValue('E1', 'Status');

        $column = 2;

        foreach ($pengaduan as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $row['nama'])
                ->setCellValue('B' . $column, $row['nik'])
                ->setCellValue('C' . $column, $row['tgl_pengaduan'])
                ->setCellValue('D' . $column, $row['judul_laporan'])
                ->setCellValue('E' . $column, $row['status']);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Laporan Sedang Dalam Proses';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function laporanSelesai()
    {
        $data = [
            'title'     => 'Laporan Selesai',
            'pengaduan' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->where('status', 'selesai')
                ->findAll(),
        ];

        return view('pengaduan/laporan-selesai', $data);
    }

    public function xlsSelesai()
    {
        $spreadsheet = new Spreadsheet();
        $pengaduan = $this->modelPengaduan
            ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
            ->where('status', 'selesai')
            ->findAll();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Isi Pengaduan')
            ->setCellValue('E1', 'Status');

        $column = 2;

        foreach ($pengaduan as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $row['nama'])
                ->setCellValue('B' . $column, $row['nik'])
                ->setCellValue('C' . $column, $row['tgl_pengaduan'])
                ->setCellValue('D' . $column, $row['judul_laporan'])
                ->setCellValue('E' . $column, $row['status']);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Laporan Selesai Ditangani';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function laporanSemua()
    {
        $data = [
            'title'     => 'Laporan Semua',
            'pengaduan' => $this->modelPengaduan
                ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
                ->findAll(),
        ];

        return view('pengaduan/laporan-semua', $data);
    }

    public function xlsSemua()
    {
        $spreadsheet = new Spreadsheet();
        $pengaduan = $this->modelPengaduan
            ->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat')
            ->findAll();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'Isi Pengaduan')
            ->setCellValue('E1', 'Status');

        $column = 2;

        foreach ($pengaduan as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $row['nama'])
                ->setCellValue('B' . $column, $row['nik'])
                ->setCellValue('C' . $column, $row['tgl_pengaduan'])
                ->setCellValue('D' . $column, $row['judul_laporan'])
                ->setCellValue('E' . $column, $row['status']);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Laporan Selesai Ditangani';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
