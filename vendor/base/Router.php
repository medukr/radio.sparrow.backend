<?php
/**
 * Created by andrii
 * Date: 06.05.19
 * Time: 17:59
 */

namespace app;

class Router
{
    private $root_dir;

    private $uri;
    private $route;

    private $controller;
    private $action;
    private $arguments;
    private $otherArguments;

    public function __construct($uri)
    {
        $this->root_dir = dirname(__FILE__, 3);
        $this->uri = strtolower(urldecode(trim($uri, '/')));
    }

    public function getUri(){
        return $this->uri;
    }

    public function run(){

        $this->setDefaults();
        $this->parseUri();

    }

    private function parseUri(){
        $parse_uri = explode('?', $this->uri);

//Парсинг контроллеров
        if (current($parse_uri)){
            $path = current($parse_uri);

            $path_parts = explode('/', $path);

            $this->controller = current($path_parts);
             array_shift($path_parts);

            if (current($path_parts)){
                $this->action = current($path_parts);
                array_shift($path_parts);
            }

            array_shift($parse_uri);
        }


//Парсинг аргументов
        $this->arguments['get'] = $_GET;
        $this->arguments['post'] = $_POST;


//        if (current($parse_uri)){
//            $data = current($parse_uri);
//
//            $arguments = explode('&', $data);
//
//            foreach ($arguments as $argument){
//                $exparg = explode('=', $argument);
//                if (count($exparg) < 3 && next($exparg)){
//                    $this->arguments[$exparg[0]] = $exparg[1];
//                }
//            }
//
//            array_shift($parse_uri);
//        }
//
//        if (current($parse_uri)){
//            $this->otherArguments = $parse_uri;
//        }


    }


    private function setDefaults()
    {
        $this->controller = App::$app->getConfig()->getWebConfig()['default']['controller'];
        $this->action = App::$app->getConfig()->getWebConfig()['default']['action'];;
        $this->arguments['get'] = [];
        $this->arguments['post'] = [];
        $this->otherArguments = [];
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams($type = null)
    {
        switch ($type){
            case 'get': return $this->arguments['get'];
            break;
            case 'post': return $this->arguments['post'];
            break;
            default: return $this->arguments;
        }

    }

    /**
     * @return mixed
     */
    public function getOtherParams()
    {
        return $this->otherArguments;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->root_dir;
    }

}