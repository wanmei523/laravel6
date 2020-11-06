<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\File;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //列表
    public function index(Request $request,Course $course){
        $data=[];
        return view('admin.course.index',$data);
    }
    //详情
    public function detail(Request $request,Course $course){
        $data=[];
        return view('admin.course.detail',$data);
    }
    //课程添加编辑
    public function add(Request $request,Course $course){
        $data=[];
        return view('admin.course.add',$data);
    }
    //课程保存
    public function save(CourseAdd $request,Course $course,File $fileModel){}
    //课程删除
    public function remove(Request $request,Course $course){}
    //章节添加编辑
    public function chapterAdd(Request $request,Course $course,Chapter $chapter){
        $data=[];
        return view('admin.course.chapter_add',$data);
    }
    //章节保存
    public function chapterSave(Request $request,Course $course,Chapter $chapter){}
    //章节删除
    public function chapterRemove(Request $request,Course $course,Chapter $chapter){}
    //资源添加编辑
    public function resourceAdd(Request $request,Course $course,Chapter $chapter){
        $data=[];
        return view('admin.course.resource_add',$data);
    }
    //资源保存
    public function resourceSave(Request $request,Course $course,Chapter $chapter){}

}
