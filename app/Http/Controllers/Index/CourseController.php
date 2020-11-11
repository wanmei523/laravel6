<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Resource;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //课程首页
    public function index(Course $course){
        $data=[
            'course'=>$course,
        ];
        return view('index.course.index',$data);
    }
    //学生阅读
    public function resource(Course $course, Resource $resource){
        $data=[
            'resource'=>$resource,
            'course'=>$course
        ];
        return view('index.course.resource',$data);
    }
}
