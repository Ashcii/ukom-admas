<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTanggapan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tanggapan';
    protected $primaryKey       = 'id_tanggapan';
    protected $allowedFields    = ['id_pengaduan', 'tgl_pengaduan', 'jam_pengaduan', 'tanggapan', 'status', 'foto', 'id_petugas'];

    // public function getTanggapan($id)
    // {
    //     $builder = $this->db->table('tanggapan');
    //     $builder->select();
    //     $builder->join('petugas', 'petugas.id_petugas = tanggapan.id_petugas');
    //     $builder->where('id_pengaduan', $id);
    //     $query = $builder->get();
    //     return $query->getRow();
    // }
}
