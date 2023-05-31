<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id']; //화이트리스트 방식
    //protected $guarded = ['id']; //블랙리스트 방식

}
