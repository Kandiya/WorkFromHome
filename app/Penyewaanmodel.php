<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyewaanmodel extends Model
{
    protected $table="table_penyewaan";
    protected $primaryKey="id";

    protected $fillable=[
        "tgl", "id_anggota", "id_petugas", "id_mobil", "jumlah", "tgl_kembali"
    ];
}
