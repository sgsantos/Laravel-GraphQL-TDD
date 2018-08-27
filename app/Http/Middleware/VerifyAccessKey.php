<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessKey
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
        // api-key de seguridad de la API
        $api_key = [
            'api_key' => '$2y$10$Wjxb/0Mks8PaWSqHbAVuSunmym/R6njTGWrikUv5h0ug7qlxN.5WO'
        ];


        /** Adicionando api-key para probar la API....
         *  En el momento que se despliegue el API, es necesario quitar esta línea para
         * que tenga efecto la seguridad impuesta.....
         */
        $request->headers->add($api_key);



        // Obtenemos el api-key que el usuario envia
        $key = $request->headers->get('api_key');


        // Si coincide con el valor almacenado en la aplicacion
        // la aplicacion se sigue ejecutando
        if (isset($key) == env('API_KEY')) {
            return $next($request);
        } else {
            // Si falla devolvemos el mensaje de error
            return response()->json(['error' => 'You are not authorized to access this API' ], 401);
        }

//        return $next($request);
    }
}
