<?php
// Routes

/*$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/

// NOTA: en dependencies.php $container['IndiceName'] el indice es
// igual a: IndiceName:controller para Router.
$app->get('/empleados/[listar[/[{column}[/[{value}]]]]]','EmployeesController:listar')->setName('empleados.listar');
