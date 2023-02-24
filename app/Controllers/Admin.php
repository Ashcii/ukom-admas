<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMasyarakat;
use App\Models\ModelPetugas;

class Admin extends BaseController
{
    protected $modelMasyarakat, $modelPetugas;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->modelMasyarakat = new ModelMasyarakat();
        $this->modelPetugas = new ModelPetugas();
    }

    public function manajemenUser()
    {
        $data = [
            'title' => 'Manajemen User',
            'masyarakat' => $this->modelMasyarakat->findAll(),
            'admin' => $this->modelPetugas->where('level', 'admin')->findAll(),
            'petugas' => $this->modelPetugas->where('level', 'petugas')->findAll(),
            'total_masyarakat' => $this->modelMasyarakat->countAllResults(),
            'total_petugas' => $this->modelPetugas->where('level', 'petugas')->countAllResults(),
            'total_admin' => $this->modelPetugas->where('level', 'admin')->countAllResults()
        ];

        return view('/admin/manajemen-user.php', $data);
    }

    public function tambahMasyarakat()
    {
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|is_unique[masyarakat.nik]',
                'errors' => [
                    'required' => 'NIK wajib diisi.',
                    'is_unique' => 'NIK sudah pernah digunakan.'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[masyarakat.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah pernah digunakan.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'telp' => $this->request->getVar('telp')
        ];

        $this->modelMasyarakat->insert($data);

        session()->getFlashdata('pesan', 'Masyarakat Berhasil Ditambahkan.');
        return redirect()->back();
    }

    public function tambahPetugas()
    {
        if (!$this->validate([
            'nama_petugas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[petugas.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah pernah digunakan.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_petugas' => $this->request->getVar('nama_petugas'),
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'telp' => $this->request->getVar('telp'),
            'level' => 'petugas'
        ];

        $this->modelPetugas->insert($data);

        session()->setFlashdata('pesan', 'Petugas berhasil ditambahkan.');
        return redirect()->back();
    }

    public function tambahAdmin()
    {
        if (!$this->validate([
            'nama_petugas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[petugas.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah pernah digunakan.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_petugas' => $this->request->getVar('nama_petugas'),
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'telp' => $this->request->getVar('telp'),
            'level' => 'admin'
        ];

        $this->modelPetugas->insert($data);

        session()->setFlashdata('pesan', 'Admin berhasil ditambahkan.');
        return redirect()->back();
    }

    public function hapusMasyarakat($id)
    {
        $this->modelMasyarakat->delete($id);
        session()->setFlashdata('pesan', 'Masyarakat berhasil dihapus.');
        return redirect()->back();
    }

    public function editMasyarakat($id)
    {
        if ($this->request->getVar('password') == '') {
            $password = $this->request->getVar('password_sebelum');
        } else {
            $password = md5($this->request->getVar('password'));
        }

        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'telp' => $this->request->getVar('telp'),
            'password' => $password
        ];
        $this->modelMasyarakat->update($id, $data);

        session()->setFlashdata('pesan', 'Masyarakat berhasil diedit');
        return redirect()->back();
    }

    public function editPetugas($id)
    {
        if ($this->request->getVar('password') == '') {
            $password = $this->request->getVar('password_sebelum');
        } else {
            $password = md5($this->request->getVar('password'));
        }

        $data = [
            'nama_petugas' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'telp' => $this->request->getVar('telp'),
            'password' => $password
        ];
        $this->modelPetugas->update($id, $data);

        session()->setFlashdata('pesan', 'Masyarakat berhasil diedit');
        return redirect()->back();
    }

    public function hapusPetugas($id)
    {
        $this->modelPetugas->delete($id);
        session()->setFlashdata('pesan', 'Petugas berhasil dihapus.');
        return redirect()->back();
    }
}
