<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'item_id'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
