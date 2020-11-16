<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['adminuser_id', 'title', 'desc', 'image', 'sort'];
    //protected $appends = ['image_link'];
    
    //获取图片地址
    public function getImageLinkAttribute()
    {
        if (empty($this->image)) {
            return asset('static/images/course-default.jpg');
        }
        return asset('storage/' . $this->image);
    }
    public function chapter()
    {
        return $this->hasMany('App\Models\Chapter')->orderBy('sort','asc');
    }
}
