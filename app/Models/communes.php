<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class communes extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_com',
        'id_reg',
        'description',
        'status'
    ];
}