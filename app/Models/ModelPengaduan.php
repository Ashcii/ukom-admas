<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaduan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id_pengaduan';
    protected $allowedFields    = ['tgl_pengaduan', 'jam_pengaduan', 'judul_laporan', 'isi_laporan', 'lokasi_kejadian', 'foto', 'publish', 'status', 'id_masyarakat'];

    public function getPengaduanAll()
    {
        $builder = $this->db->table('pengaduan');
        $builder->select();
        $builder->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPengaduan($id)
    {
        $builder = $this->db->table('pengaduan');
        $builder->select();
        $builder->join('masyarakat', 'masyarakat.id_masyarakat = pengaduan.id_masyarakat');
        $builder->where('id_pengaduan', $id);
        $builder->limit(1);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getPengaduanUser($id, $id_masyarakat)
    {
        $builder = $this->db->table('pengaduan');
        $builder->where('id_pengaduan', $id);
        $builder->where('id_masyarakat', $id_masyarakat);
        $query = $builder->get();
        return $query->getNumRows();
    }
}
