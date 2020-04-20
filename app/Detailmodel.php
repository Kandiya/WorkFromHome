<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailmodel extends Model
{
    protected $table="table_detail";
    protected $primaryKey="id";

    protected $fillable=[
        'id_sewa', 'id_mobil', 'subtotal', 'qty'
    ];
}
