<?php

namespace App\Http\Middleware;

use Closure;

class ResourceRights
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$course,$resource)
    {
        //没成功，通过中间件过滤越权问题
        $resource_ids = $resource->chapter()->get()->keyBy('course_id')->keys();
        if($resource_ids->search($course->id)===false){
            apiErr('越权访问');
        }
        return $next($request);
    }
}
