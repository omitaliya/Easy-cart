<?php

namespace App\Models;

use App\Models\sub_categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table='categories';
    public $primaryKey='id';
    public $fillable=[
        'name','slug','status'
    ];

    public function sub_category()
    {
        return $this->hasMany(sub_categories::class,'category_id','id');
    }
}
