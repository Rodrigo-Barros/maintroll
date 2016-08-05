<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8">
</head>
<body>
<div>
<?php
    include("PHP/Functions.php");
    //Atualizar os repositorios: sudo apt-get update
    //Instalando o curl do PHP: sudo apt-get instal php5-curl
    
  //$apikey  ="5734c8f8-db53-4c88-bb17-25e0db0caa8d";//Key de desenvolvedor Johnner
    $apikey  ="9b3c87df-bbba-49aa-a5a3-7de0df4f6f6a";//Key de desenvolvedor Trunthor
    $apikey2 ="f83bba86-82b8-4f17-8200-7b2b86784d76";//Key de desenvolvedor Black Mormon
    $apikey3 ="b8d982d4-4eae-472b-8c6c-09512c94d25c";//Key de desenvolvedor BlindaoS2

    //----------------------------------------Server-------------------------------------------------
    $server = $_GET["server"];
    //-------------------------Atualizando o Dragon Date "6.11.1" 01/06/2016------------------------
    $drgver =  $_GET["dd"];
    //----------------------------PEGAR O ID do invocador-----------------------------------------
    $summonid = $_GET["id"];
    
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!RUNAS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //Pega todas as Runas do Invocador (Gasta Requisição)
    $url = "https://"."$server".".api.pvp.net/api/lol/"."$server"."/v1.4/summoner/"."$summonid"."/runes?api_key="."$apikey";
    
    $jsondecoded = json_decode((useCurl($url)),$assoc = true);
    if($jsondecoded == "404"){
        echo "<p>runa nao encontrada</p>";
    }else{
        if(array_key_exists("slots",$jsondecoded[$summonid]["pages"][0])==true){
        $totalrune = count($jsondecoded[$summonid]["pages"][0]["slots"])-1;
        }else{
        $totalrune = -1;
        }
        if($totalrune!=-1){//testa se tem runa
            $rValor = 0;
            $totalpages = count($jsondecoded[$summonid]["pages"])-1;
            for ($runepage=0;$runepage<=$totalpages;$runepage++){
                //$runepage = 2;
                //-----------------------------------CONTAGEM DAS RUNAS-------------------------------------
                unset($arraycontrune);
                for ($i=0;$i<=$totalrune;$i++){//Pega todas as runas
                    $contrune=0;//Zera a contagem
                    for ($ii=0;$ii<=$totalrune;$ii++){//Compara com ela mesma
                        if(($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$i"]["runeId"])==($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"])){
                            $contrune++;//Se for igual conta
                        }
                    }
                $arraycontrune[] = $contrune;//Grava a contagem~~~~~~~~~
                }
                //var_dump($arraycontrune);//<<<<<<<<HELPER
                unset($resumoruna);
                unset($runeflags);
                //--------------------ORGANIZACAO DAS RUNAS E SUA RESPCTIVA CONTAGEM--------------------
                for ($i=0;$i<=$totalrune;$i++){//Pega todoas as runas
                    for ($ii=0;$ii<=$totalrune;$ii++){//Compara c ela mesma
                        if(($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$i"]["runeId"])==($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"])){
                            //Se encotrar algum valor igual grava em um novo array
                            $flag = 0;//Zera a flag
                            for ($iii=0;$iii<=(count($resumoruna)-1);$iii++){//verifica se tem repetido no array
                                if($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]==$resumoruna[$iii]){
                                    $flag=1;//Se for um ja existia alguma runa igual no array
                                }
                            }
                            if($flag==0 && ($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]!=null)){//Se nao existia nenhum igual e diferente de nulo
                                $resumoruna[] = ($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]);//Grava o id da runa~~~~~~~~~~~~~~~
                                $runeflags[] = $ii;//Grava o numero do indice para pegar a quantidade depois ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                            }
                        }
                    }
                }
                //-----------------------------Soma todas os pontos de todas as paginas de runas---------------------
                $url = "http://ddragon.leagueoflegends.com/cdn/".$drgver."/data/pt_BR/rune.json";
                $jsondecoded_runevalor = json_decode((useCurl($url)),$assoc = true);
                for ($i=0;$i<=(count($resumoruna)-1);$i++){
                $rValor = (floatval(runevalor($jsondecoded[$summonid]["pages"]["$runepage"]["slots"][$runeflags[$i]]["runeId"],$jsondecoded_runevalor)) + $rValor);
                }
                
            }//totalpages
        }//testa de tem runa
            //echo "<p>TROLLPOINTS.beta: ".((($summonid/10000)-100)/-4)."</p>";
            //echo "<p>Rune valor: ".($rValor*100)/($totalpages+1)."</p>";
            //echo "<p>WL: ".(winlose($summonid,$apikey,$drgver,$server))."</p>";
            $trollpoint = round(((($summonid/10000)-100)/-4)+(($rValor*100)/($totalpages+1))+(winlose()),0)+2000;
            echo "<p id='trollpointsHide' class='hidden' style='color:white'>".$trollpoint."</p>";
            echo "<h1 style='color:white'>Trollpoints:</h1>";            
            echo "<p id='trollpoints' style= 'font-size:6em; color:white'>0</p>";
    }
    // **********************************************************************************************************************************
    // ************************************************FUNCOES***************************************************************************
    // **********************************************************************************************************************************
    //Função que pega elo, vitorias e derrotas
    function winlose() {
        global $summonid,$apikey,$drgver,$server;
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/985/3356
        $url = "https://na.api.pvp.net/api/lol/"."$server"."/v2.5/league/by-summoner/"."$summonid"."/entry?api_key="."$apikey";
        $jsondecoded = json_decode((useCurl($url)),$assoc = true);
        if($jsondecoded == "404"){
            return 0;
        }else{
        return (($jsondecoded["$summonid"][0][entries][0][wins])*3) - (($jsondecoded["$summonid"][0][entries][0][losses])*2);
        }
    }
    //fim das funçoes
    // *****************************************************************

?>
</div>
</body>
</html>