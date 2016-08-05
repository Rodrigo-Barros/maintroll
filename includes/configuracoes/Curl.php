<?php

namespace configuracoes;

class Curl
{
    
    public static function executarCurl($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // SSL FIX
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($curl);
        //echo "<p>$url</p><p>Status: ". curl_getinfo($curl)["http_code"]."</p>";//Opcional <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<HELPER
        if((curl_getinfo($curl)["http_code"])=="200" ){
            curl_close($curl);
            $out = $json;
        }
        else
        {
            $msgErro = curl_getinfo($curl)["http_code"];
            curl_close($curl);
            throw new \Exception($msgErro);
        }
        
        return $out;
    }
    
}