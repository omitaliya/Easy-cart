<?php

namespace App\Models;

use App\Models\brand;
use App\Models\image;
use App\Models\Category;
use App\Models\sub_categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    use HasFactory;

    public $table='products';
    public $primaryKey='id';

    public function images()
    {
        return $this->hasMany(image::class,'product_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function sub_category()
    {
        return $this->belongsTo(sub_categories::class,'sub_category_id','id');
    }

    public function brand()
    {
        return $this->belongsTo(brand::class,'brand_id','id');
    }

    public function rating()
    {
        $this->hasMany(product_rating::class,'product_id','id');
    }
}
