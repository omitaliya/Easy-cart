<?php

namespace App\Models;

use App\Models\order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class order_status extends Model
{
    use HasFactory;

    public $table='order_status';

    public $primaryKey='id';

    public function status()
    {
        return $this->belongsTo(order::class,'order_id','id');
    }
}
