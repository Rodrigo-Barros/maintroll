<?php

namespace integracao\api_lol;

class Summoner
{
    protected $objApiLol;

    protected $id;
    protected $imgId;
    protected $level;
    protected $name;
    protected $imgUrl;
    
    protected $eloName;
    protected $tier;
    protected $queue;

    protected $playerOrTeamId;
    protected $division;
    protected $leaguePoints;
    protected $wins;
    protected $losses;
    protected $isHotStreak; 
    protected $isVeteran; 
    protected $isFreshBlood; 
    protected $isInactive;
    
    protected $arrTopChampionMastery;
    protected $mainRole;
    
    protected $statusAtack;
    protected $statusMagic;
    protected $statusDefense;
    protected $statusDifficulty;            


    public function __construct(\integracao\api_lol\apiLol $objApiLol, $summonerName)
    {
        $this->name = $summonerName;
        $this->objApiLol = $objApiLol;
        $this->getSummonerInformation();
        $this->getSummonerElo();
    }
    
    /**
     * 
     * @param \integracao\api_lol\apiLol $objApiLol
     * @param type $summonerName
     * @throws Exception
     */
    private function getSummonerInformation()
    {
        $url = "https://". $this->objApiLol->getServerCountry() .".api.pvp.net/api/lol/" . $this->objApiLol->getServerCountry() . "/v1.4/summoner/by-name/". $this->name ."?api_key=". \enum\ChavesApiLol::apiKey1;
        
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
            $this->id = 0;
            $this->imgId = "img/Tilt.gif";
        }
        else
        {
            $this->id = $jsondecoded[$this->name]["id"];
            $this->imgId = $jsondecoded[$this->name]["profileIconId"];
            $this->level = $jsondecoded[$this->name]["summonerLevel"];
            $this->imgUrl = "https://ddragon.leagueoflegends.com/cdn/".$this->objApiLol->getServerVersion()."/img/profileicon/".$this->imgId.".png";
            $this->name = $jsondecoded[$this->name]["name"];
        }
        
    }
    
    private function getSummonerElo()
    {
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/985/3356
        $url = "https://".$this->objApiLol->getServerCountry().".api.pvp.net/api/lol/".$this->objApiLol->getServerCountry()."/v2.5/league/by-summoner/"."$this->id"."/entry?api_key=".\enum\ChavesApiLol::apiKey1;
        
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar ID do Invocador: " . $ex->getMessage());
        }
        
        $jsondecoded = json_decode($respostaCurl,true);
        
        if( $jsondecoded == "404")
        {
            
        }
        else
        {
            $this->eloName          = $jsondecoded[$this->id][0]["name"];
            $this->tier             = $jsondecoded[$this->id][0]["tier"];
            $this->queue            = $jsondecoded[$this->id][0]["queue"];

            $this->playerOrTeamId   = $jsondecoded[$this->id][0]["entries"][0]["playerOrTeamId"];
            $this->division         = $jsondecoded[$this->id][0]["entries"][0]["division"];
            $this->leaguePoints     = $jsondecoded[$this->id][0]["entries"][0]["leaguePoints"];
            $this->wins             = $jsondecoded[$this->id][0]["entries"][0]["wins"];
            $this->losses           = $jsondecoded[$this->id][0]["entries"][0]["losses"];
            $this->isHotStreak      = $jsondecoded[$this->id][0]["entries"][0]["isHotStreak"];
            $this->isVeteran        = $jsondecoded[$this->id][0]["entries"][0]["isVeteran"];
            $this->isFreshBlood     = $jsondecoded[$this->id][0]["entries"][0]["isFreshBlood"];
            $this->isInactive       = $jsondecoded[$this->id][0]["entries"][0]["isInactive"];
        }
        
        
    }
    
    private function getTopChampionMastery($quantidade = 5)
    {
                
        
        try
        {
            $this->arrTopChampionMastery = ChampionMastery::getTopChampionMastery($this->objApiLol, $this->id, $quantidade);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar Mastery dos campeões do invocador: " . $ex->getMessage());
        }        
        
    }
    
    private function carregarMainRole()
    {
        
        $url = 'https://global.api.pvp.net/api/lol/static-data/'.$this->objApiLol->getServerCountry().'/v1.2/champion?dataById=true&champData=tags&api_key='.\enum\ChavesApiLol::apiKey1;
        
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao buscar ID do Invocador: " . $ex->getMessage());
        }
        
        $arrChampionsTags = json_decode($respostaCurl,true);
        
        foreach ($this->getArrTopChampionMastery() as $objChampionMastery) 
        {
            $principalRoles[] = $arrChampionsTags['data'][$objChampionMastery->getChampionId()]["tags"][0];
            foreach ($arrChampionsTags['data'][$objChampionMastery->getChampionId()]["tags"] as $championTag)
            {
                $allRoles[] = $championTag;
            }

        }   
        
        $contagem = array_count_values($allRoles);
        
        foreach($contagem AS $role => $vezes) {
            if($vezes>$mainvezes){
            $mainrole = $role;
            $mainvezes = $vezes;
            }elseif($vezes==$mainvezes){
                if($role == $principalRoles[0]){
                    $mainrole = $role;
                    $mainvezes = $vezes;
                }
                if($role == $principalRoles[1]&&$mainrole != $principalRoles[0]){
                    $mainrole = $role;
                    $mainvezes = $vezes;
                }
            }
        }
        
        $this->mainRole = $mainrole;
    
        
    }
    
    private function carregarStatus()
    {
        $url = 'https://global.api.pvp.net/api/lol/static-data/'.$this->objApiLol->getServerCountry() .'/v1.2/champion?dataById=true&champData=info&api_key='.\enum\ChavesApiLol::apiKey1;

        
        try
        {
            $respostaCurl = \configuracoes\Curl::executarCurl($url);
        } 
        catch (\Exception $ex) 
        {
            throw new \Exception("Erro ao status dos campeões: " . $ex->getMessage());
        }
        
        $jsondecoded_status = json_decode($respostaCurl, true);
                    
        foreach($this->getArrTopChampionMastery() as $objChampionMastery)
        {
            $status_atack += $jsondecoded_status["data"][$objChampionMastery->getChampionId()]["info"]["attack"];
            $status_magic += $jsondecoded_status["data"][$objChampionMastery->getChampionId()]["info"]["magic"];
            $status_defense += $jsondecoded_status["data"][$objChampionMastery->getChampionId()]["info"]["defense"];
            $status_difficulty += $jsondecoded_status["data"][$objChampionMastery->getChampionId()]["info"]["difficulty"];
        }
        
        $this->statusAtack =  $status_atack;
        $this->statusMagic =  $status_magic;
        $this->statusDefense =  $status_defense;
        $this->statusDifficulty =  $status_difficulty;
        
    }
            
    function getId()
    {
        return $this->id;
    }

    function getImgId()
    {
        return $this->imgId;
    }

    function getLevel()
    {
        return $this->level;
    }

    function getName()
    {
        return $this->name;
    }

    function getImgUrl()
    {
        return $this->imgUrl;
    }

    function getEloName()
    {
        return $this->eloName;
    }

    function getTier()
    {
        return $this->tier;
    }

    function getQueue()
    {
        return $this->queue;
    }

    function getPlayerOrTeamId()
    {
        return $this->playerOrTeamId;
    }

    function getDivision()
    {
        return $this->division;
    }

    function getLeaguePoints()
    {
        return $this->leaguePoints;
    }

    function getWins()
    {
        return $this->wins;
    }

    function getLosses()
    {
        return $this->losses;
    }

    function getIsHotStreak()
    {
        return $this->isHotStreak;
    }

    function getIsVeteran()
    {
        return $this->isVeteran;
    }

    function getIsFreshBlood()
    {
        return $this->isFreshBlood;
    }

    function getIsInactive()
    {
        return $this->isInactive;
    }
    
    /**
     * 
     * @return ChampionMastery[]
     */
    function getArrTopChampionMastery()
    {
        if (empty($this->arrTopChampionMastery))
        {
            $this->getTopChampionMastery();
        }
        
        return $this->arrTopChampionMastery;
    }

    function getMainRole()
    {
        if (empty($this->mainRole))
        {
            $this->carregarMainRole();
        }
        
        return $this->mainRole;
    }
    
    function getStatusAtack()
    {
        if (empty($this->statusAtack))
        {
            $this->carregarStatus();
        }
        
        return $this->statusAtack;
    }

    function getStatusMagic()
    {
        if (empty($this->statusMagic))
        {
            $this->carregarStatus();
        }
        
        return $this->statusMagic;
    }

    function getStatusDefense()
    {
        if (empty($this->statusDefense))
        {
            $this->carregarStatus();
        }
        
        return $this->statusDefense;
    }

    function getStatusDifficulty()
    {
        if (empty($this->statusDifficulty))
        {
            $this->carregarStatus();
        }
        
        return $this->statusDifficulty;
    }




    
}