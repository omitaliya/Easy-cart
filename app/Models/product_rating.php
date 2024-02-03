<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class product_rating extends Model
{
    use HasFactory;

    public $table="product_ratings";
    public $primaryKey="id";

    public function product()
    {
        return $this->belongsTo(product::class,'product_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
