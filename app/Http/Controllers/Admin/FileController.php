<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function index(File $fileModel){
        $files = $fileModel->orderBy('id','desc')->paginate(setting('page_resource'));
        $data=[
            'files'=>$files,
        ];
        return view('admin.file.index',$data);
    }
    public function up(Request $request, File $fileModel){
        $data=[];
        return view('admin.file.up',$data);
    }
    public function save(Request $request, File $fileModel){
        if ($request->hasFile('filename') && $request->file('filename')->isValid()) {
            $file = $request->file('filename');
            if (!in_array($file->extension(), config('project.upload.files'))) {
                alert('不被允许的文件类型','danger');
                return back();
            }
            //文件保存
            $filepath = $file->store('other', 'public');
            //文件信息保存
            $fileModel->saveFile('other_upload',$filepath, $file);
            alert('上传成功');
            return redirect()->route('admin.file');

        }else{
            alert('上传失败','danger');
            return back();
        }
    }
}