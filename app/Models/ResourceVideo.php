<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceVideo extends Model
{
    //
    use SoftDeletes;
    protected $fillable=['resource_id','ali_id'];
}
