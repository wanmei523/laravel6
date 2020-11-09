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
    //反向一对多关联
    public function adminUser()
    {
        return $this->belongsTo('App\Models\AdminUser','adminuser_id');
    }
    //文件类型获取器
    public function getFileTypeFormatAttribute(){ 
        return config('project.upload.type')[$this->filetype]??"无效的类别";
    }
    //文件大小获取器
    function getFileSizeFormatAttribute(){
        $p = 0;
        $format = 'bytes';
        if ($this->filesize > 0 && $this->filesize < 1024) {
            $p = 0;
            return number_format($this->filesize) . ' ' . $format;
        }
        if ($this->filesize >= 1024 && $this->filesize < pow(1024, 2)) {
            $p = 1;
            $format = 'KB';
        }
        if ($this->filesize >= pow(1024, 2) && $this->filesize < pow(1024, 3)) {
            $p = 2;
            $format = 'MB';
        }
        if ($this->filesize >= pow(1024, 3) && $this->filesize < pow(1024, 4)) {
            $p = 3;
            $format = 'GB';
        }
        if ($this->filesize >= pow(1024, 4) && $this->filesize < pow(1024, 5)) {
            $p = 3;
            $format = 'TB';
        }
        $this->filesize /= pow(1024, $p);
        return number_format($this->filesize, 3) . ' ' . $format;
    }
}
