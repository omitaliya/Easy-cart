<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    use HasFactory;

  public $table='addresses';
  public $primaryKey='id';

  protected $fillable=[
        'user_id','fname','lname','email','mobile','city','state','country','description','note','pincode'
    ];
}
