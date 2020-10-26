<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Msg extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['username', 'content'];
}
