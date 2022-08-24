<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'year',
        'change',
        'fuel',
        'end_plate',
        'color',
        'only_owner',
        'ipva_paid',
        'licensed',
        'bodywork',
        'description',
        'image',
        'car_item_id',
        'user_id',
        'active',
        'price',
        'motor'
    ];

    public function carItems()
    {
        return $this->hasMany(CarItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
