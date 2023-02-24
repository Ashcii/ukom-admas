<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMasyarakat;

class User extends BaseController
{
    protected $modelMasyarakat;
    public function __construct()
    {
        $this->modelMasyarakat = new ModelMasyarakat();
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil User'
        ];

        return view('/user/profil', $data);
    }

    public function editProfil()
    {
        if (!$this->validate([
            'nik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIK wajib diisi.'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $id = $this->request->getVar('id_masyarakat');

        if ($this->request->getFile('foto_profil') == '') {
            $nama_foto = session()->get('foto_profil');
        } else {
            if (session()->get('foto_profil') != 'default.svg') {
                unlink(FCPATH . '/uploads/foto-profil/' . session()->get('foto_profil'));
            }
            $nama_foto = date('ymdhis') . '.jpg';
            $foto_profil = $this->request->getFile('foto_profil');
            $foto_profil->move(FCPATH . '/uploads/foto-profil/', $nama_foto);
        }

        echo $nama_foto;

        if (empty(session()->get('level'))) {
            $data = [
                'nik'           => $this->request->getVar('nik'),
                'nama'          => $this->request->getVar('nama'),
                'username'      => $this->request->getVar('username'),
                'telp'          => $this->request->getVar('telp'),
                'foto_profil'   => $nama_foto
            ];

            $this->modelMasyarakat->update($id, $data);

            $user = $this->modelMasyarakat->where('id_masyarakat', session()->get('id_masyarakat'))->first();

            $dataSession = [
                'nik'           => $user['nik'],
                'nama'          => $user['nama'],
                'username'      => $user['username'],
                'telp'          => $user['telp'],
                'foto_profil'   => $user['foto_profil']
            ];
            session()->set($dataSession);
            session()->setFlashdata('pesan', 'Profil berhasil diedit');
            return redirect()->to('/profil');
        } else {
            $data = [
                'nama_petugas' => $this->request->getVar('nama'),
                'username'     => $this->request->getVar('username'),
                'telp'         => $this->request->getVar('telp'),
                'foto_profil'  => $nama_foto
            ];
        }
    }

    public function gantiPassword()
    {
        if (!$this->validate([
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $id = session()->get('id_masyarakat');
        $data = [
            'password' => md5($this->request->getVar('password'))
        ];
        $this->modelMasyarakat->update($id, $data);

        session()->setFlashdata('pesan', 'Password berhasil diganti.');
        return redirect()->back();
    }
}
