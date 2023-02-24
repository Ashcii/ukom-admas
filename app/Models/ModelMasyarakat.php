<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMasyarakat extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'masyarakat';
    protected $primaryKey       = 'id_masyarakat';
    protected $allowedFields    = ['nik', 'nama', 'username', 'password', 'telp', 'foto_profil'];
}
