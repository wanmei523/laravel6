<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gbook;
use App\Http\Resources\Msg as AppMsg;
use App\Models\Msg;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    //
    public function index(Msg $msg){
        $data = $msg->orderBy('id','desc')->paginate(3);
        return AppMsg::collection($data);
    }

    public function save(Gbook $request ,Msg $msg){
        $data=$request->validated();
        $item=$msg->create($data);
        return ['code'=>0,'msg'=>'success','data'=>$item];
    }
}
