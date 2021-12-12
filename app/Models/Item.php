<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pajak;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $fillable = [
        'nama',
    ];

    public function pajaks()
    {
        return $this->belongsToMany(Pajak::class, 'pajak_item');
    }
}
