<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMasyarakat;
use App\Models\ModelPetugas;

class MasyarakatLogin extends BaseController
{
    protected $modelMasyarakat;
    protected $modelPetugas;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->modelMasyarakat = new ModelMasyarakat();
        $this->modelPetugas = new ModelPetugas();
    }

    public function login()
    {
        return view('/authentication/login');
    }

    public function daftar()
    {
        return view('/authentication/daftar');
    }

    public function loginAuth()
    {
        $data = $this->request->getPost();
        $user = $this->modelMasyarakat->where('username', $data['username'])->first();
        $petugas = $this->modelPetugas->where('username', $data['username'])->first();

        // cek apakah username masyarakat ditemukan
        if ($user) {
            // cek password
            if ($user['password'] != md5($data['password'])) {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            } else {
                // jika password dan user benar maka berikan session dan arahkan ke aplikasi
                $sessLogin = [
                    'isLogin'       => true,
                    'id_masyarakat' => $user['id_masyarakat'],
                    'nik'           => $user['nik'],
                    'nama'          => $user['nama'],
                    'username'      => $user['username'],
                    'telp'          => $user['telp'],
                    'foto_profil'   => $user['foto_profil']
                ];
                session()->set($sessLogin);
                return redirect()->to('/');
            }
        }

        // cek apakah username petugas ditemukan
        if ($petugas) {
            // cek password
            if ($petugas['password'] != md5($data['password'])) {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            } else {
                $sessLogin = [
                    'isLogin' => true,
                    'id_petugas' => $petugas['id_petugas'],
                    'nama_petugas' => $petugas['nama_petugas'],
                    'username' => $petugas['username'],
                    'telp' => $petugas['telp'],
                    'level' => $petugas['level'],
                    'foto_profil' => $petugas['foto_profil']
                ];

                session()->set($sessLogin);
                return redirect()->to('/');
            }
        } else {
            session()->setFlashdata('error', 'Username atau password salah!');
            return redirect()->to('/login');
        }
    }

    public function daftarAuth()
    {
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|is_unique[masyarakat.nik]',
                'errors' => [
                    'required' => 'NIK wajib diisi!',
                    'is_unique' => 'NIK sudah pernah digunakan!'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi!'
                ]
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi!'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[masyarakat.username]',
                'errors' => [
                    'required' => 'Username wajib diisi!',
                    'is_unique' => 'Username sudah pernah digunakan!'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi!',
                ]
            ],
            'ulang_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Kolom ulangi password wajib diisi!',
                    'matches'  => 'Password tidak sama dengan kolom ulangi password!'
                ]
            ]
        ])) {
            return redirect()->to('/daftar')->withInput();
        }

        $data = [
            'nik' => $this->request->getVar('nik'),
            'nama'  => $this->request->getVar('nama'),
            'telp' => $this->request->getVar('telp'),
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
        ];
        $this->modelMasyarakat->insert($data);

        session()->setFlashdata('pesan', 'Daftar berhasil!');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
