<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;

    public $table="images";

    public $primaryKey='id';

    public function product()
    {
        return $this->belongsTo(product::class,'id','product_id');
    }
}
