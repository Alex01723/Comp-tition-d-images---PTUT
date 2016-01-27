<?php

namespace App\Http\Middleware;
use Closure;

class AdminMiddleware {
    /*
     *  Récupérateur intermédiaire de routes pour vérifier le type de l'utilisateur
     */
    public function handle($request, Closure $next) {
        if ($request->user() == null || !$request->user()->est_adm()) {
            return Response("Accès interdit");
        }

        return $next($request);
    }
}