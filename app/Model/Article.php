<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';
    public $primaryKey = 'art_id';
    public $guarded = [];
    public $timestamps = false;
}
