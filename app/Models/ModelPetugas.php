<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPetugas extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'petugas';
    protected $primaryKey       = 'id_petugas';
    protected $allowedFields    = ['nama_petugas', 'username', 'password', 'telp', 'level'];
}
