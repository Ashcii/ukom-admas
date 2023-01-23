<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaduan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id_pengaduan';
    protected $allowedFields    = ['tgl_pengaduan', 'nik', 'isi_laporan', 'lokasi_kejadian', 'foto', 'status'];

    public function getPengaduan($id)
    {
        $builder = $this->db->table('pengaduan');
        $builder->select();
        $builder->join('masyarakat', 'masyarakat.nik = pengaduan.nik');
        $builder->where('id_pengaduan', $id);
        $builder->limit(1);
        $query = $builder->get();
        return $query->getRow();
    }
}
