<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //通过json响应异常时，默认字段
        if($request->expectsJson()){
            $data = [
                'message'=>$exception->getMessage(),
                'code'=>$exception->getCode(),
                'statusCode'=>400,//默认的响应状态码
                'data'=>[],
            ];
            //如果异常中包含getStatusCode方法，则从中获取HTTP状态码
            if(method_exists($exception,'getStatusCode')){
                $data['statusCode']=$exception->getStatusCode();
            }
            //业务异常，可能包含data，状态码由开发人员指定，默认400
            if($exception instanceof ApiException){
                $data['data']=$exception->getData();
                $data['statusCode']=$exception->getStatusCode();
            }
            //表单异常（需要通过status属性获取HTTP状态码）
            if($exception instanceof ValidationException){
                $data['statusCode']=$exception->status;
                $data['data']=$exception->errors();
                $data['code']=ExceptionCode::VALIDATION_ERROR;
            }
            //如果处于调试模式，追加调试信息
            if(config('app.debug')){
                $data['exception'] = get_class($exception);
                $data['file'] = $exception->getFile();
                $data['line'] = $exception->getLine();
                $data['trace'] = collect($exception->getTrace())->map(function($trace){
                    return Arr::except($trace,['args']);
                });
            }
            return response()->json($data,$data['statusCode']);
        }
        return parent::render($request, $exception);
    }
}
