<?php


namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{

    protected $localhost = 'http://localhost:57827';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $possibleOrigins = explode(",", env('COSR_URL'));

        if (in_array($request->header('origin'), $possibleOrigins)) {
            $origin = $request->header('origin');
        } else {
            $origin = $this->localhost;
        }

        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Accept, Authorization, X-Requested-With, Application, api-key, content-length, bpid, order'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
