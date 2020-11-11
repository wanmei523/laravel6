<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //学生首页
    public function index(Course $course){
        $data=[
            'courses'=>$course->orderBy('id','desc')->get(),
        ];
        return view('index.index',$data);
    }
}
