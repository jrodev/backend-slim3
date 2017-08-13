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
    public function listar($req, $resp, $args)
    {
        //var_dump($args); exit;
        $aKeyVal = [];
        $aViewParams = [];
        // SI es POST buscar
        if ( $req->isPost() ) {
            $aPost = $req->getParsedBody();
            $hasEmail = key_exists('email', $aPost);
            if($hasEmail) {
                $aKeyVal = ['email', $aPost['email']];
                $aViewParams['email'] = $aPost['email'];
            }
        }
        // Si es busqueda por ID
        if (key_exists('id', $args)) {
            $aKeyVal = ['id', $args['id']];
            $aViewParams['id'] = $args['id'];
            $aResult = $this->_getEmployeesEquals($aKeyVal);
            // asignando solo el empleado
            if (count($aResult)) { $aViewParams['employee'] = $aResult[0]; }
        } else {
            // asignando todos los empledos
            $aViewParams['employees'] = $this->_getEmployeesEquals($aKeyVal);
        }
        // SINO rederizando la vista
        return $this->view->render($resp, 'views/empleados/listar.twig', $aViewParams);
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
        $column = trim($aKeyVal[0]);
        $value  = trim($aKeyVal[1]);

        foreach ($arrEmpl as $index => $row) {
            if( key_exists($column, $row) && $row[$column]==$value ){
                $aResult[] = $row;
            }
        }
        return $aResult;
    }

}
