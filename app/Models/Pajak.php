<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    protected $table = 'pajak';
    protected $fillable = [
    	'nama', 'rate',
    ];
    protected $id = 'id';
}
