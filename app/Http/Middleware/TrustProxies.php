
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies (needed for Render / Cloudflare)
     */
    protected $proxies = '*';

    /**
     * Use X-Forwarded headers
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}