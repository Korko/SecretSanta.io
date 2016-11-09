<?php

namespace Korko\SecretSanta\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;

class Language implements Middleware {

    private $app;
    private $redirector;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $handledDomains = config('app.domains');
        $currentDomain = $request->getHost();

        foreach($handledDomains as $locale => $domain) {
            if(preg_match('#'.preg_quote($domain, '#').'$#', $currentDomain)) {
                $this->app->setLocale($locale);
            }
        }

        return $next($request);
    }

}