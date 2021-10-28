<?php

namespace Modricl\Activator\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class AuthorizationMiddleware
{
    private const API_KEYS = 'activator.api_keys';
    private const UUID_REGEX = '~^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$~i';

    public function handle($request, Closure $next)
    {
        $request_key = $request->header('X-API-KEY');
        $allowed_keys = config(self::API_KEYS);

        if (preg_match(self::UUID_REGEX, $request_key) > 0 && $request_key != null) {
            foreach ($allowed_keys as $key) {
                if ($key['key'] == $request_key) {
                    Log::info("Activator API: Credentials [ " . $key['name'] . " ] are accessing URL " . $request->path());
                    return $next($request);
                }
            }
        }

        return response()->json([
            'error' => [
                'message' => 'Not authorized'
            ]
        ], 403);
    }
}
