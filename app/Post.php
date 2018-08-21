<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // nombre de la tabla
    protected $table = 'posts';

    // nombre de los campos
    protected $fillable = [
        'user_id', 'title', 'body'
    ];


}
