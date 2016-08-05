<?php

namespace integracao\api_lol;

class ChampionMastery
{
    /**
     *
     * @var apiLol
     */
    protected $championId;
    protected $championLevel;
    protected $championPoints;
    protected $lastPlayTime;
    protected $championPointsSinceLastLevel;    
    protected $championPointsUntilNextLevel;
    protected $chestGranted;
    protected $tokensEarned;
    
    public function __construct(array $rowChampionMastery)
    {
        $this->championId = $rowChampionMastery['championId'];
        $this->championLevel = $rowChampionMastery['championLevel'];
        $this->championPoints = $rowChampionMastery['championPoints'];
        $this->lastPlayTime = $rowChampionMastery['lastPlayTime'];
        $this->championPointsSinceLastLevel = $rowChampionMastery['championPointsSinceLastLevel'];
        $this->championPointsUntilNextLevel = $rowChampionMastery['championPointsUntilNextLevel'];
        $this->chestGranted = $rowChampionMastery['chestGranted'];
        $this->tokensEarned = $rowChampionMastery['tokensEarned'];

    }
    
    public static function getTopChampionMastery(apiLol $objApiLol, $idSummoner, $quantidade = 5)
    {
                
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/985/3356
        $url = "https://".$objApiLol->getServerCountry().".api.pvp.net/championmastery/location/".$objApiLol->getServerSigla()."/player/".$idSummoner."/topchampions?count=" . $quantidade . "&api_key=".\enum\ChavesApiLol::apiKey3;
                
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar Mastery dos campeões do invocador: " . $ex->getMessage());
        }
        
        $jsondecoded = json_decode($respostaCurl,true);
        
        $arrChampionMastery = array();
        
        if( $jsondecoded == "404")
        {
            $arrChampionMastery = null;
        }
        else
        {
            foreach ($jsondecoded as $rowChampionMastery)
            {
                $objChampionMastery = new ChampionMastery($rowChampionMastery);
                
                $arrChampionMastery[$objChampionMastery->championId] = $objChampionMastery;
            }
            
        }
        
        return $arrChampionMastery;
        
    }
    
    function getChampionId()
    {
        return $this->championId;
    }

    function getChampionLevel()
    {
        return $this->championLevel;
    }

    function getChampionPoints()
    {
        return $this->championPoints;
    }

    function getLastPlayTime()
    {
        return $this->lastPlayTime;
    }

    function getChampionPointsSinceLastLevel()
    {
        return $this->championPointsSinceLastLevel;
    }

    function getChampionPointsUntilNextLevel()
    {
        return $this->championPointsUntilNextLevel;
    }

    function getChestGranted()
    {
        return $this->chestGranted;
    }

    function getTokensEarned()
    {
        return $this->tokensEarned;
    }

   
}