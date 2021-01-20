<?php

namespace Espora\HttpLogger\Middleware;

use Closure;

use Espora\HttpLogger\Models\HttpLog;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If it's not enabled don't log anything
        if (!config('http-logger.enabled')) {
            return $next($request);
        }

        $_data = [];
        $_data['ip'] = $request->ip();
        $fullUrl = $request->fullUrl();
        $_data['url'] = substr($fullUrl, 256);
        $_data['method'] = $request->method();
        $_data['req_header'] = json_encode($request->headers->all());
        $_data['req_body'] = $request->getContent();
        $_data['res_header'] = '';
        $_data['res_body'] = '';

        $httpLog = HttpLog::create($_data);

        $request->merge('mid_http_log_id', $httpLog->id);

        $response = $next($request);

        $httpLog->res_header = json_encode($response->headers->all());
        $httpLog->res_body = $response->getContent();
        $httpLog->save();

        return $response;
    }
}
