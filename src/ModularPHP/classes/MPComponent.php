<?php

class MPComponent {

    public $template = NULL;
    public $ModularPHP;

    public function __construct($p)
    {
        $this->ModularPHP = $p;

        foreach ($p->Modules as $m=>$ref) {
            $this->{$m} = $ref;
        }

    }

    public function __GET($params) {
        $this->template = MPHelper::getError(404);
        include($this->template);
    }

    public function __POST($params) {
        $this->template = MPHelper::getError(404);
        include($this->template);
    }

    private function showComponent($cmp) {

    }


    public function __render() {
        if($this->template != null) {
            foreach ($this->getFields() as $val) {
                ${$val} = $this->{$val};
            }

            $reflection = new ReflectionClass($this);

            if(MPHelper::contains(".twig", $this->template)) {

                $loader = new \Twig\Loader\FilesystemLoader(dirname($reflection->getFileName()) );
                $twig = new \Twig\Environment($loader, [
                    'cache' => __dir__.'/../cache',
                ]);

                $twig = new \Twig\Environment($loader);
                $function = new \Twig\TwigFunction('component', function ($name) {
                    $this->ModularPHP->loadComponent(array("component" => $name));
                });

                $twig->addFunction($function);

                //getComponent($name)

                $twigArray = array();

                foreach ($this as $k => $v) {
                    $twigArray[$k] = $v;
                }

                echo $twig->render($this->template, $twigArray);

            } else {
                include(dirname($reflection->getFileName()) . "\\" . $this->template);
            }
        }
    }

    public function getFields()
    {
        $fields = array();

        foreach ($this as $u => $v) {
            array_push($fields, $u);
        }

        return $fields;
    }

    public static function Load($mp, $req = "GET") {

        $class = static::class;
        $obj = new $class($mp);

        if($req == "GET") {
            $obj->__GET($_GET);
        } else if($req == "POST") {
            $obj->__POST($_POST);
        } else {
            return false;
        }
    }

}