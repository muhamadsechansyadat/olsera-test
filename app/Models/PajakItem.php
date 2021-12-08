<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PajakItem extends Model
{
    protected $table = 'pajak_item';
    protected $fillable = [
    	'id_item', 'id_pajak',
    ];
    public $timestamps = false;
}
