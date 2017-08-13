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
$app->get('/empleados[/[listar[/[{id}[/]]]]]','EmployeesController:listar')->setName('empleados.listar');

// Para buscar por Email
$app->post('/empleados[/[listar[/]]]', 'EmployeesController:listar');
