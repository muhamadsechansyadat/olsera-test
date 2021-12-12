<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Item;

class Pajak extends Model
{
    use HasFactory;
    
    protected $table = 'pajak';
    protected $fillable = [
        'nama', 'rate',
    ];
    protected $id = 'id';

    public function items()
    {
        return $this->belongsToMany(Item::class, 'pajak_item');
    }
}
