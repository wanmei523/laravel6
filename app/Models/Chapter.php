<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['adminuser_id','course_id','title','desc','sort'];

    //关联资源并附带中间表sort字段
    public function resource(){
        return $this->belongsToMany('App\Models\Resource')->withPivot('sort')->withTimestamps();
    }
}
