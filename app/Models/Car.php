<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'year',
        'change',
        'km',
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
        'brand_id',
        'user_id',
        'active',
        'price',
        'motor'
    ];

    public function getImageAttribute(){
        $image = $this->attributes['image'];
        if(!$image){
            return null;
        }
        return Storage::url($image);
    }

    public function image()
    {
        return $this->attributes['image'];
    }


    public function carItems()
    {
        return $this->hasMany(CarItem::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
