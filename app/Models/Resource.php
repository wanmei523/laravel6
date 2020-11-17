<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    //
    use SoftDeletes;
    protected $fillable=['adminuser_id','type','title','desc'];
    const VIDEO = 1;
    const DOC = 0;

    public function adminUser(){
        return $this->belongsTo('App\Models\AdminUser','adminuser_id');
    }

    //资源类型名字
    public function getTypeNameAttribute()
    {
        return config('project.resource.type')[$this->type];
    }
    public function resourceVideo(){
        return $this->hasOne('App\Models\ResourceVideo');
    }
    public function resourceDoc(){
        return $this->hasOne('App\Models\ResourceDoc');
    }
    public function chapter(){
        return $this->belongsToMany('App\Models\Chapter')->withPivot('sort')->withTimestamps();
    }
    //资源被哪些课程id使用
    public function getResourceRightsAttribute()
    {
        return $this->chapter()->get()->keyBy('course_id')->keys();
    }
}
