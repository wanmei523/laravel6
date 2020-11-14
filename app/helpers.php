<?php

use App\Exceptions\ApiException;
use App\Exceptions\ExceptionCode;

function alert($msg, $type = 'success')
{
    session()->flash($type, $msg);
}

function setting($key){
    $data=app('App\Models\Setting')->kv();
    return $data[$key];
}

function apiErr($message,$code=ExceptionCode::ERROR,$data=[],$statusCode=400){
    throw new ApiException($message,$code,$data,$statusCode);
}
