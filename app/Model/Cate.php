<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    public $table = 'category';
    public $primaryKey = 'cate_id';
    public $guarded = [];
    public $timestamps = false;
}
