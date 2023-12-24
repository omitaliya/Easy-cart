<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    use HasFactory;

    public $table='brand';
    public $primaryKey='id';

    public $fillable=[
        'name','status','slug'
    ];

}
