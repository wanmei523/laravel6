<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceDoc extends Model
{
    //
    use SoftDeletes;
    protected $fillable=['resource_id','content'];
}
