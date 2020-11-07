<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterWrite;
use App\Http\Requests\CourseWrite;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //列表
    public function index(Request $request, Course $course)
    {
        $courses = $course->orderBy('sort', 'asc')->get();
        $data = [
            'courses' => $courses,
        ];
        return view('admin.course.index', $data);
    }
    //详情
    public function detail(Request $request, Course $course)
    {
        $data = [
            'course'=>$course,
        ];
        return view('admin.course.detail', $data);
    }
    //课程添加编辑
    public function add(Request $request, Course $course)
    {
        $data = [
            'course' => $course,
        ];
        return view('admin.course.add', $data);
    }
    //课程保存
    public function save(CourseWrite $request, Course $course, File $fileModel)
    {
        //获取验证后的数据
        $data = $request->validated();
        //image设置默认空值，否则报错
        //$data['image']='';这里添加以后修改课程头图会丢失，所以只能数据表里面追加默认值
        //设置adminuser_id
        $data['adminuser_id']=Auth::guard('admin')->id();
        //文件上传检查
        //是否上传文件和文件有效性
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            if (!in_array($file->extension(), config('project.upload.image'))) {
                alert('不被允许的文件类型');
                return back();
            }
            //文件保存
            $data['image'] = $file->store('course', 'public');
            //文件信息保存
            $fileModel->saveFile('course_image', $data['image'], $file);
        }
        //有传入id则是编辑，否则保存
        if ($course->id) {
            $course->update($data);
        } else {
            $course->create($data);
        }
        //提示成功然后跳转
        alert('操作成功');
        return redirect()->route('admin.course');
    }
    //课程删除
    public function remove(Request $request, Course $course)
    {
        $course->delete();
        alert('删除成功');
        return back();
    }
    //章节添加编辑
    public function chapterAdd(Course $course, Chapter $chapter)
    {
        $data = [
            'course'=>$course,
            'chapter'=>$chapter,
        ];
        return view('admin.course.chapter_add', $data);
    }
    //章节保存
    public function chapterSave(ChapterWrite $request, Course $course, Chapter $chapter)
    {
        $data=$request->validated();
        $data['course_id']=$course->id;
        $data['adminuser_id']=Auth::guard('admin')->id();
        if($chapter->id){
            $chapter->update($data);
        }else{
            $chapter->create($data);
        }
        alert('操作成功');
        return redirect()->route('admin.course.detail',[$course->id]);
    }
    //章节删除
    public function chapterRemove(Request $request, Course $course, Chapter $chapter)
    { }
    //资源添加编辑
    public function resourceAdd(Request $request, Course $course, Chapter $chapter)
    {
        $data = [];
        return view('admin.course.resource_add', $data);
    }
    //资源保存
    public function resourceSave(Request $request, Course $course, Chapter $chapter)
    { }
}
