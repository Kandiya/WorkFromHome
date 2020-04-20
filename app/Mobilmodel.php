<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobilmodel extends Model
{
    protected $table="table_mobil";
    protected $primaryKey="id";

    protected $fillable=[
        'nama_mobil', 'biaya', 'stok'
    ];
}
