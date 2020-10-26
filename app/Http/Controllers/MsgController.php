<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gbook;
use App\Models\Msg;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    //
    public function index(Msg $msg)
    {
        $msgs=$msg->orderBy('id','desc')->paginate(2);
        $data =[
            'msgs'=>$msgs,
        ];
        return view('gbook.index',$data);
    }
    public function save(Gbook $request,Msg $msg)
    {
        // $username = $request->input('username');
        // $content = $request->input('content');
        //获取通过验证的数据
        $postdata = $request->validated();
        $msg->create($postdata);
        return redirect()->route('index');
    }
}
