<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';
    
    // nombre de la tabla
    protected $table = 'posts';

    // nombre de los campos
    protected $fillable = [
        'user_id', 'title', 'body'
    ];


}
