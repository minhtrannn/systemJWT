<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    public $primaryKey = 'id';

    public $timestamps = true;


    protected $fillable = [
        'title', 'body','user_id'
    ];


    public function user()
    {
        $this->belongsTo('App\\Model\User');
    }
}
