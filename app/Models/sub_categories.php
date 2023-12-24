<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sub_categories extends Model
{
    use HasFactory;

    public $table='sub_categories';
    public $primaryKey='id';

    public function category()
    {
        return $this->hasMany(Category::class,'id','category_id');
    }
}
