<?php
namespace app\middlewares;

final class ExampleMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {
        $user_data = [
            'username' => "TestUser"
        ];

        $request = $request->withAttribute('user_data', $user_data);
        return $response = $next($request, $response);

    }
}

?>