<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'condition_id',
        'image',
        'brand_name',
        'explanation',
        'price'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likesUsers(){
        return $this->belongsToMany(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }
}
