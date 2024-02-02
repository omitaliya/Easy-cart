<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    public $table='orders';

    public $primaryKey='id';

    public function discount()
    {
        return $this->belongsTo(discount::class,'discount_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function address()
    {
        return $this->belongsTo(address::class,'addresses_id','id');
    }

    public function orderStatus()
    {
        return $this->hasMany(order_status::class,'order_id','id');
    }
}
