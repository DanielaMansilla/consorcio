<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    $url =(isset($_GET['url']) ? $_GET['url'] : "");    
    
    $url = explode("/",$url);
    echo $url;
    
    if (function_exists($url[0]))

        $url[0]();
    else
        
        echo "No existe la funcion";        
    
    
    
    function about()
    {
        echo "Ejecutaste About";
    }
    function contacts()
    {
        echo "Ejecutaste Contactos";
    }
    
?>