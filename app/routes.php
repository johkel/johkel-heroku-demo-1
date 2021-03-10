<?php
// https://github.com/nikic/FastRoute
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    // /
    $r->addRoute('GET', '[/]', 'HomeController::index');

    // tasks
    $r->get( '/tasks', 'TasksController::index');
    $r->get('/tasks/{id:\d+}[/]', 'TasksController::show');
    $r->get('/tasks/{id:\d+}/edit[/]', 'TasksController::edit');
    $r->post('/tasks/{id:\d+}[/]', 'TasksController::update');
    $r->get('/tasks/{id:\d+}/delete[/]', 'TasksController::delete');
    $r->get('/tasks/new[/]', 'TasksController::new');
    $r->post('/tasks', 'TasksController::store');


    // users
    $r->addGroup('/admin', function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', 'AdminController::index');
        $r->addRoute('GET', '/{id:\d+}[/]', 'AdminController::show');
    });

});



// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        // Rutten hittades alltså inte
        // Kan vara en "Kunde inte hittas" a'la GitHub eller en ren redirect
        echo "404. Rutten hittades inte. Rutt: <strong> $uri </strong>. <a href='/'>Startsida</a>";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        // Rutten hittades men inte med rätt metod, exempelvis att post finns men inte get
        // Kan vara en "Kunde inte hittas" eller en ren redirect till /
        echo "405. Rutten är inte tillåten med denna metod. Tillåtna:";
        foreach ($allowedMethods as $method) {
            echo " " . $method;
        }
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars

        // bryt handler till class and method på ::
        list($class, $method) = explode('::', $handler, 2);

        // lägg till namespacing
        $class = '\\App\\Controllers\\' . $class;

        // skapa instans av klass och kör metod
        call_user_func_array([new $class, $method], $vars);
        break;
}
