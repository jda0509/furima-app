<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postcode',
        'address',
        'building',
        'image'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
