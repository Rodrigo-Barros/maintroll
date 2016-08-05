<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8">
</head>
<body>
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
    //echo $url;
    $runepage = 0;
    $jsondecoded = json_decode((useCurl($url)),$assoc = true);
    
    if($jsondecoded == "404"){
        echo "<p>runa nao encontrada</p>";
    }else{
            $totalrune = runecontest($jsondecoded,$summonid,$runepage);
            $rValor = 0;
            $totalpages = count($jsondecoded[$summonid]["pages"])-1;//Pega todas as paginas
            //-----------------------------------------MONTA O NAV link das runas----------------------------------
            echo'
            <nav id="nav-main" class="text-center">
                <ul class="pagination">';
                for($i=0;$i<=$totalpages;$i++){
                    if($jsondecoded[$summonid]["pages"]["$i"]["current"]==0)
                    echo "<li id='rp".$i."' class='' Style='background:#222'><a  onclick='runepage(".$i.",".$totalpages.");' href='#' Style='color:#222'>".($i+1)."</a></li>";
                    else
                    echo "<li id='rp".$i."' class='active' Style='background:#222'><a  onclick='runepage(".$i.",".$totalpages.");' href='#' Style='color:red'><b>".($i+1)."</b></a></li>";
                }
            echo '
                </ul>
            </nav>
            
            ';
            //Fim do Nav de link das runas
            for ($runepage=0;$runepage<=$totalpages;$runepage++){
                //$runepage = 1;
                //-----------------------------------CONTAGEM DAS RUNAS-------------------------------------
                unset($arraycontrune);//zera o array                
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
                unset($resumoruna);//zera o array
                unset($runeflags);                
                //--------------------ORGANIZACAO DAS RUNAS E SUA RESPCTIVA CONTAGEM--------------------
                for ($i=0;$i<=$totalrune;$i++){//Pega todoas as runas
                    for ($ii=0;$ii<=$totalrune;$ii++){//Compara c ela mesma
                        if(($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$i"]["runeId"])==($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"])){
                            //Se encotrar algum valor igual grava em um novo array
                            $flag = 0;//Zera a flag
                            for ($iii=0;$iii<=(count($resumoruna)-1);$iii++){//verifica se tem repetido no array
                                if($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]==$resumoruna[$iii]){
                                    $flag=1;//ja existia alguma runa igual no array
                                }
                            }
                            if($flag==0 && ($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]!=null)){//Se nao existia nenhum igual e diferente de nulo
                                $resumoruna[] = ($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]["$ii"]["runeId"]);//Grava o id da runa~~~~~~~~~~~~~~~
                                $runeflags[] = $ii;//Grava o numero do indice para pegar a quantidade depois ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                            }
                        }
                    }
                }

// ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||                
// |||||||||||||||||||||||||||||||||||||||||||      MOSTRA AS RUNAS     |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
                // Cria as paginas e escolhe a pagina que irá aparecer...
                if($jsondecoded[$summonid]["pages"]["$runepage"]["current"]==0){
                    echo "<div class ='hidden' id='runepage".$runepage."'>";//DIV INDIVIDUAL DA PAGINA DE RUNA
                }else{
                  echo "<div class ='content' id='runepage".$runepage."'>";                    
                }
                //=-=-=-=-=-=-=-=-==-=-=-=-=-=-=-=-=-=-Valor do Conjunto de Runas=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
                echo "<h1 class='text-center' style='color:white'>".$jsondecoded[$summonid]["pages"]["$runepage"]["name"]."</h1>";//nome
                echo "<div class='col-xs-6 col-md-6'>"; //Bootstrap separation div
                $rValor = 0;
                $url = "https://ddragon.leagueoflegends.com/cdn/".$drgver."/data/pt_BR/rune.json";
                $jsondecoded_runevalor = json_decode((useCurl($url)),$assoc = true);
                for ($i=0;$i<=(count($resumoruna)-1);$i++){
                    $rValor = floatval(runevalor($jsondecoded[$summonid]["pages"]["$runepage"]["slots"][$runeflags[$i]]["runeId"],$jsondecoded_runevalor)) + $rValor;
                }
                echo  "<p>Rune Valor: ".($rValor*100)."</p>";//valor das runas
                echo "<p>Total: ".runecontest($jsondecoded,$summonid,$runepage)."</p>";//quantidade de runas
                
                //MOSTRA O TOTAL DOS ATRIBUTOS
                $url = "https://ddragon.leagueoflegends.com/cdn/".$drgver."/data/pt_BR/rune.json";
                $jsondecoded_runeinf = json_decode((useCurl($url)),$assoc = true);
                unset($nomeatrib);//zera o array
                unset($atribatrib);//zera o array
                for ($i=0;$i<=(count($resumoruna)-1);$i++){
                    $flag = 0;
                    for ($ii=0;$ii<=(count($nomeatrib)-1);$ii++){
                        if( $nomeatrib[$ii] == runeinf($resumoruna[$i],$jsondecoded_runeinf,8)){
                            $atribatrib[$ii] = $atribatrib[$ii] + abs((runeinf($resumoruna[$i],$jsondecoded_runeinf,4))*$arraycontrune[$runeflags[$i]]);
                            $flag = 1;
                        }
                    }
                    if($flag == 0){
                    $nomeatrib[] = runeinf($resumoruna[$i],$jsondecoded_runeinf,8);
                    $atribatrib[] = abs(runeinf($resumoruna[$i],$jsondecoded_runeinf,4))*$arraycontrune[$runeflags[$i]];
                    }
                }

                for ($i=0;$i<=(count($nomeatrib)-1);$i++){             
                    if(substr(runetype($nomeatrib[$i],"aa"),-1)=="%"){
                    echo "<p>".substr(runetype($nomeatrib[$i],"pt_BR"),0,-1)." = ".(100*$atribatrib[$i])."%</p>"; 
                    }else{
                    echo "<p>".runetype($nomeatrib[$i],"pt_BR")." = ".$atribatrib[$i]."</p>";
                    }
                }
                echo "</div>";//Bootstrap separation div
                
                //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=Mostra Valor Das Runas individual-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-
                
                echo "<div class='col-xs-6 col-md-6'>"; //Bootstrap separation div
                for ($i=0;$i<=(count($resumoruna)-1);$i++){
                    
                    echo "<fieldset>";
                    echo "<legend style='color:white'>".runeinf($resumoruna[$i],$jsondecoded_runeinf,0)."</legend>";
                    echo "<p>";
                    echo runeinf($resumoruna[$i],$jsondecoded_runeinf,1);
                    echo " ".runeinf($resumoruna[$i],$jsondecoded_runeinf,2)." ";
                    echo "x".$arraycontrune[$runeflags[$i]];
//                    echo " Total: ".runeinf($resumoruna[$i],$jsondecoded_runeinf,4)*$arraycontrune[$runeflags[$i]]."</p>";
                    echo "</p>";
                    echo "</fieldset>";
                }
                echo "</div>";//Bootstrap separation div
                echo "</div>";
            }//totalpages
    }
?>
</body>

</html>