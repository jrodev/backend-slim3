<?php

namespace App\Controllers;

use Libs\DataLoader;

/**
 * Acciones para el Controlador Empleados
 */
class EmployeesController
{
    protected $view;
    protected $router;
    protected $dataLoader;

    /**
     * La instanciación del controller se hace en dependencies.php
     * @param Twig $view     Motor de plantillas
     * @param Routes $router   Ruteo
     * @param DataLoader $loadJson Carga el archivo employees,json
     */
    public function __construct($view, $router, $loadJson)
    {
        $this->view = $view;
        $this->router = $router;
        $this->dataLoader = $loadJson;
    }

    /**
     * Lista los empleados segun los paramentros que se pasen por url
     * @param  Request $req
     * @param  Response $resp
     * @param  Array $arg  Contiene las variables que se pasan por url en la ruta
     * @return String renderiza usando Twig
     */
    public function listar($req, $resp, $arg)
    {
        //var_dump($arg);
        $hasQuery = (key_exists('column',$arg) && key_exists('value',$arg));
        $aKeyVal = $hasQuery?[$arg['column'],$arg['value']]:[];
        $result = $this->_getEmployeesEquals($aKeyVal);
        /*echo sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        exit;*/
        return $this->view->render($resp, 'views/empleados/listar.twig', ['employees' => $result]);

    }

    /**
     * Metodo privado que retorna un json como array segun criterio de busqueda
     * @param  array  $aKeyVal de la forma: ['column','value']
     * @return Array          array de resultados de converitir el json file.
     */
    private function _getEmployeesEquals($aKeyVal=[])
    {
        // All result
        $arrEmpl = $this->dataLoader->load('employees');

        // Si no se manda el array keyVal se devuelve todo
        if (count($aKeyVal)!=2) { return $arrEmpl; }

        $aResult = [];

        $column = $aKeyVal[0];
        $value  = $aKeyVal[1];

        foreach ($arrEmpl as $index => $row) {
            if( key_exists($column, $row) && $row[$column]==$value ){
                $aResult[] = $row;
            }
        }
        return $aResult;
    }

}
