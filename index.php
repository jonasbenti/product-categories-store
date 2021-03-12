<?php

spl_autoload_register( function($class)
{
    $dir_src = './control/';
    if(file_exists($dir_src.$class. '.php'))
    {
        require_once $dir_src.$class . '.php';
    }
});

$classe = isset($_REQUEST['class']) ? $_REQUEST['class'] : null;
$metodo = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if (class_exists($classe)) 
{
    $pagina = new $classe($_REQUEST);
    if(!empty($metodo) && method_exists($classe, $metodo))
    {
        $pagina->$metodo($_REQUEST);
    }
    $pagina->show();
}
else 
{
    header("Location: index.php?class=Dashboard");
}