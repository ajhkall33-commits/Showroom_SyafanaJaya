<?php

namespace App\Modules\Jabatan\Models;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $table = "jabatan";
    protected $primaryKey = 'id_jabatan';
    public $timestamps = false;
}
