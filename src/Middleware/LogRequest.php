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
        $_data['url'] = $request->url();
        $_data['method'] = $request->method();
        $_data['req_header'] = json_encode($request->headers->all());
        $_data['req_body'] = $request->getContent();

        $response = $next($request);

        $_data['res_header'] = json_encode($response->headers->all());
        $_data['res_body'] = $response->getContent();

        HttpLog::create($_data);

        return $response;
    }
}
