<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FastRoute\Dispatcher;

class Kernel
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run()
    {
        $request = Request::createFromGlobals();
        $routeInfo = $this->container->get('dispatcher')->dispatch($request->getMethod(), $request->getPathInfo());
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // No matching route was found.
                Response::create("404 Not Found", Response::HTTP_NOT_FOUND)
                    ->prepare($request)
                    ->send();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // A matching route was found, but the wrong HTTP method was used.
                Response::create("405 Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED)
                    ->prepare($request)
                    ->send();
                break;
            case Dispatcher::FOUND:
                // Fully qualified class name of the controller
                $fqcn = $routeInfo[1][0];
                // Controller method responsible for handling the request
                $routeMethod = $routeInfo[1][1];
                // Route parameters (ex. /products/{category}/{id})
                $routeParams = $routeInfo[2];
                // Obtain an instance of route's controller
                // Resolves constructor dependencies using the container
                $controller = $this->container->get($fqcn);
                // Generate a response by invoking the appropriate route method in the controller
                $response = $controller->$routeMethod($request, $routeParams);
                if ($response instanceof Response) {
                    // Send the generated response back to the user
                    $response
                        ->prepare($request)
                        ->send();
                }
                break;
            default:
                // According to the dispatch(..) method's documentation this shouldn't happen.
                // But it's here anyways just to cover all of our bases.
                Response::create('Received unexpected response from dispatcher.', Response::HTTP_INTERNAL_SERVER_ERROR)
                    ->prepare($request)
                    ->send();
                return;
        }
    }
}