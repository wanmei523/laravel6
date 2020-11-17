<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;

use App\Http\Resources\Course as AppCourse;
use App\Http\Resources\Resource as AppResource;
use App\Models\Course;
use App\Models\Resource;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function index(Course $course){
        $courses=$course->orderBy('sort','desc')->get();
        return AppCourse::collection($courses);
        //return new AppCourse(Course::find(1));
    }
    public function course(Course $course){
        $course->load('chapter');
        //$course = Course::with('chapter')-> find($id);
        return new AppCourse($course);
    }
    public function resource(Course $course, Resource $resource){
        $resource_ids = $resource->resource_rights;
        if($resource_ids->search($course->id)===false){
            apiErr('越权访问');
        }
        return new AppResource($resource);
    }
}
