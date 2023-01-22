<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaduan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id_pengaduan';
    protected $allowedFields    = ['tgl_pengaduan', 'nik', 'isi_laporan', 'lokasi_kejadian', 'foto', 'status'];
}
