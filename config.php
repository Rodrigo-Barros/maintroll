<?php

set_include_path( '.'
                         . PATH_SEPARATOR . realpath( $caminhoRootUrl . 'includes' ) . DIRECTORY_SEPARATOR

                         . PATH_SEPARATOR . get_include_path() );

spl_autoload_register(
        

    function( $classname ) 
    {
        require_once fileExistsReturningPath(str_replace( '\\', DIRECTORY_SEPARATOR, $classname) ) ;
    }

);

/**
* Verifica se o arquivo existe com ou sem sufixos e retorna o caminho encontrado, 
*  se não encontrou retorna null
* @param string $fullClassPathWithouExt
* @return null|string
*/
function fileExistsReturningPath($fullClassPathWithouExt)
{
    $fullClassPathWithouExt = preg_replace("/\\\\/", "/", $fullClassPathWithouExt);
    $fullClassPathWithouExt = 'includes/' . $fullClassPathWithouExt;

    
   if(file_exists($fullClassPathWithouExt.".php"))
       return $fullClassPathWithouExt.".php";
   $arraySufixos = array(
       'class','interface','enum','exception','page',
       'dados'
   );
   foreach($arraySufixos AS $sufixo)
   {
       if(\file_exists($fullClassPathWithouExt.".".$sufixo.".php"))
           return $fullClassPathWithouExt.".".$sufixo.".php";
   }
   return null;
}