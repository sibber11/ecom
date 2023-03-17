<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_get_routes_are_working()
    {
        //$this->withoutExceptionHandling();
        $routes = Route::getRoutes();
        $authRoutes = [];
        // loop through the routes and fill the auth routes array
        foreach ($routes as $route) {
            if (in_array('auth', $route->middleware()) && !in_array('admin', $route->middleware()) && $route->methods[0] == 'GET') {
                $authRoutes[] = $route;
            }
        }

        $this->signIn();
        foreach ($authRoutes as $route) {
            if (str_contains($route->getName(), 'verification.notice'))
                continue;
            if (str_contains($route->getName(), 'verification.verify'))
                continue;

            if (str_contains($route->getName(), 'checkout.show')){
                $response = $this->get($route->uri);
                $this->customAssertStatus(200, $response, $route);
                continue;
            }
            if (str_contains($route->getName(), 'show')){
                continue;
            }
            $response = $this->get($route->uri);
            $this->customAssertStatus(200, $response, $route);
        }
    }

    public function test_guest_get_routes_are_working()
    {
        // get all the routes
        $routes = Route::getRoutes();
        // loop through the routes and fill the guest routes array
        foreach ($routes as $route) {
            if (in_array('guest', $route->middleware()) && $route->methods[0] == 'GET') {
                $guestRoutes[] = $route;
            }
        }
        // loop through the guest routes and get the response
        foreach ($guestRoutes as $route) {
            $response = $this->get($route->uri);
            // assert the response is ok else show the route name to the console
            $this->customAssertStatus(200, $response, $route);
        }
    }

    public function customAssertStatus($status, \Illuminate\Testing\TestResponse $response, $route): void
    {
        $response_code = $response->getStatusCode();
        self::assertSame($status, $response_code, "Expected response status code [200] but received {$response_code} \n for the route '{$route->getName()}'");
    }
}
