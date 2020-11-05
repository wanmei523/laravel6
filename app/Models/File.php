<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class File extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['adminuser_id','filetype','filepath','client_filename','fileext','filesize'];
    //文件写入数据库方法
    public function saveFile($type,$file_path,$file){
        $data = [
            'adminuser_id'=>Auth::guard('admin')->id(),
            'filetype'=>$type,
            'filepath'=>$file_path,
            'client_filename'=>$file->getClientOriginalName(),
            'fileext'=>$file->extension(),
            'filesize'=>$file->getClientSize(),
        ];
        return $this->create($data);
    }
    //文件地址获取
    public function getFileLinkAttribute(){ 
        return asset('storage/'.$this->filepath);
    }
}
