<?php

namespace integracao\api_lol;

class apiLol
{
    protected $serverCountry;
    protected $serverVersion;

    function getServerCountry()
    {
        return $this->serverCountry;
    }

    function getServerVersion()
    {
        return $this->serverVersion;
    }

    function setServerCountry($serverCountry)
    {
        $this->serverCountry = $serverCountry;
    }

    function setServerVersion($serverVersion)
    {
        $this->serverVersion = $serverVersion;
    }
    
    function getServerSigla()
    {
        return \enum\ServerSigla::getConst($this->serverCountry);
    }
    
        
    public function __construct($serverCountry)
    {
        $this->serverCountry = $serverCountry;
        $this->serverVersion = $this->getApiVersion($serverCountry);
    }
    
    private function getApiVersion($server)
    {
        $url = "https://global.api.pvp.net/api/lol/static-data/"."$server"."/v1.2/versions?api_key=". \enum\ChavesApiLol::apiKey1;
        
        try
        {
            $retornoCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar versão da Api: " . $ex->getMessage());
        }
        
        $jsondecoded = json_decode($retornoCurl,true);
        
        $versao =  ($jsondecoded[0]);//usado no campo de versão nas URLs
        
        return $versao;
    }
    
    private function getSummonerInformation($nomeInvocador)
    {
        $nomeInvocador = strtolower(str_replace(" ","",$nomeInvocador));//Tira os espaços e coloca td minusculo

        $url = "https://". $this->serverCountry .".api.pvp.net/api/lol/" . $this->serverCountry . "/v1.4/summoner/by-name/". $nomeInvocador ."?api_key=". \enum\ChavesApiLol::apiKey1;
        
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar ID do Invocador: " . $ex->getMessage());
        }
        
        $jsondecoded = json_decode($respostaCurl,true);

        if($jsondecoded == "404"||$jsondecoded == "403")
        {
            $this->summonerId = 0;
            $this->summonerImg = "img/Tilt.gif";
        }
        else
        {
            $this->summonerId = ($jsondecoded[$nomeInvocador]["id"]);
            //Pegar os dados do invocador atravez da função
            //  echo $summonid;
            $jsondecoded = invocDados($summonid);
            $imagemInvoc = "<img class='img-circle icon-invoc' src='https://ddragon.leagueoflegends.com/cdn/".$drgver."/img/profileicon/".$jsondecoded["$summonid"]["profileIconId"].".png'>";
            $jsondecoded3 = invocElo($summonid,$apikey);
        }
    }
    
    private function getSummonerImg()
    {
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/1079/3724
        $url = "https://".$this->serverCountry.".api.pvp.net/api/lol/".$this->serverCountry."/v1.4/summoner/".$this->summonerId."?api_key=" . \enum\ChavesApiLol::apiKey1 ;
        
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar ícone do Invocador: " . $ex->getMessage());
        }
        
        $jsondecoded = json_decode($respostaCurl,$assoc = true);
        return $jsondecoded;
        
        global $server,$drgver;
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/985/3356
        $url = "https://"."$server".".api.pvp.net/api/lol/"."$server"."/v2.5/league/by-summoner/"."$summonid"."/entry?api_key="."$apikey";
        $jsondecoded = json_decode((useCurl($url)),$assoc = true);
        return $jsondecoded;
    }
    
}