<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount extends Model
{
    use HasFactory;

    public $table='discounts';
    public $primaryKey='id';

    protected $fillable=[
        'code','name','description','discount_amount','max_uses','max_uses_user','type','status','min_amount','starts_at','expires_at'
    ];

}
