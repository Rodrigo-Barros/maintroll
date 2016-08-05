<?php

$caminhoRootUrl = ""; // Já está no Root

include_once("config.php");

$server = $_GET["server"];
$nome = $_GET["nome"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
	<title>Main Troll</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/full.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/gif" href="img/Fav_shield.gif"/>
</head>
<?php
    include("PHP/Functions.php");

    //Atualizar os repositorios: sudo apt-get update
    //Instalando o curl do PHP: sudo apt-get instal php5-curl
    
    //----------------------------------------Server-------------------------------------------------
    
    //-------------------------Atualizando o Dragon Date "6.11.1" 01/06/2016------------------------
    
    $objApiLol = new \integracao\api_lol\apiLol($server);
    
    $drgver = $objApiLol->getServerVersion();
    
    //----------------------------PEGAR O ID do invocador-----------------------------------------
    
    $objSummoner = new \integracao\api_lol\Summoner($objApiLol, $nome);
        
?>
<script>
    var id = "<?php echo $objSummoner->getId() ?>";
    var dd = "<?php echo $objApiLol->getServerVersion() ?>";
    var server = "<?php echo $objApiLol->getServerCountry() ?>";
    var jsondecoded_elo = "<?php if($jsondecoded3 == '404'){echo $jsondecoded3;}else{echo '0';}; ?>";
</script>

<body class="full teste1" >

	    <!-- ||||||||||||||||||||||||||||||||NAVEGATOR||||||||||||||||||||||||||||||||||||| -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="icon-border3">
                        <div class="icon-border2">      
                            <div class="icon-border">
                                <a onclick='callmaindados()' href='#'><img class='img-circle icon-invoc' src='<?php echo $objSummoner->getImgUrl(); ?>'></a>
                            </div>
                            <div class="lvl-border" ><p class="lvl"> <?php 
                                if($objSummoner->getId()==0){
                                echo "?";    
                                }else{
                                echo $objSummoner->getLevel();
                                }
                            ?></p></div>
                        </div>
                    </div>
                    <ul>
                        <li>
                            <a onclick='callmaindados()' href='#' class="navbar-brand" style="padding-left: 50px;">
                              <div class="nav">
                                <?php
                                //imagem

                                
                                if($objSummoner->getId()==0){
                                echo "    Unknown";

                                }else
                                echo $objSummoner->getName();
                                ?>
                               </div>
                    
                            </a>
                        </li>
                    </ul>
                </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="nav-bug" style="left: 0px;top: 50px;position: absolute;width: 81px;background: #222;z-index: -1;border-top: 0px solid #222;">.
                    </div>
            		<form class="navbar-form navbar-left" method="get" action="Trollmain.php">
            			<div class="input-group">
            				<input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o invocador"/>
                				<span class="input-group-btn">
                					<button class="btn-square btn-danger  dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                						<?php echo strtoupper($server); ?>
                						<span class="caret"></span>
                					</button>
                					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                						<li><a href="#" onclick="selectserver('br')">Brazil</a></li>
                						<li><a href="#" onclick="selectserver('eune')">EU East</a></li>
                						<li><a href="#" onclick="selectserver('euw')">EU West</a></li>
                						<li><a href="#" onclick="selectserver('jp')">Japan</a></li>
                						<li><a href="#" onclick="selectserver('kr')">Korea</a></li>
                						<li><a href="#" onclick="selectserver('lan')">Latin North</a></li>
                						<li><a href="#" onclick="selectserver('las')">Latin South</a></li>
                						<li><a href="#" onclick="selectserver('na')">America</a></li>
                						<li><a href="#" onclick="selectserver('oce')">Oceania</a></li>
                						<li><a href="#" onclick="selectserver('ru')">Russia</a></li>
                						<li><a href="#" onclick="selectserver('tr')">Turkey</a></li>									
                					</ul>
                					<button class="btn btn-primary" type="submit" >
                						<span class="glyphicon glyphicon-search"></span>
                					</button>
                				</span>
            				</div>
            			<input id = "server" type="hidden" name="server" value="<?php echo $server; ?>"></input>
            		</form>
                    <ul class="nav navbar-nav">
                    <li id="li1" class=""><a href="#" onclick="currentM();">Current Match</a></li>
                        <li id="li2" class=""><a href="#" onclick="callrunes();">Go Runes</a></li>
                        <li id="li3" class="">
                        <a href="#" onclick="calltp();">Hora de Trollar</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"><a href="#">test</a></li>
                    
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    <section id="corpo">
    <div class="container">
        <!-- ||||||||||||||||||||||||||||||||SECTION||||||||||||||||||||||||||||||||||||| -->
        <span id="maindadosdiv" class = "content">
       <?php
        //echo "<p>Level: ".$jsondecoded["$summonid"]["summonerLevel"]."</p>";
           //ELO IMG
            if($objSummoner->getId()==0){
                echo "<img height='128' width='128' src='".eloimg("BLANK")."'>";
                echo  "<p>Not Found</p>";
            }else{
                if($jsondecoded3==404){
                    echo "<p>";
                    echo "<img height='128' width='128' src='img/".enum\EloImg::UNRANKED."'>";
                    echo "<img height='128' width='128' src='img/Roles/".$objSummoner->getMainRole().".gif'>";
                    echo "</p>";
                    echo  "<p>Unranked</p>";
                }else{
                    echo "<div class='col-xs-12'>";
                    echo "<p>";
                    echo "<img height='128' width='128' src='img/".enum\EloImg::getConst($objSummoner->getTier())."'>";
                    echo "<img height='128' width='128' src='img/Roles/".$objSummoner->getMainRole().".gif'>";
                    echo "</p>";
                    echo  "<p>".$objSummoner->getTier()." ".$objSummoner->getDivision()."</p>";
                    //Vitorias
                    echo  "<p>Wins: " .$objSummoner->getWins() . "</p>";
                    //Derrotas
                    echo  "<p>Losses: " .$objSummoner->getLosses(). "</p>";
                    echo "</div>";
                }
            }
                    //ESTATUS DO JOGADOR COM BASE NOS CAMPEOES
                    $startTime = microtime(true);
                    
            

                    echo "<p>---------Summoner Status--------</p>";
                    echo'
                <div style ="color:white" class="stats">
                    <div class="attack">
                        <span >Attack</span>
                        <div class="statsbar">';
                        for($i=0;$i<=$objSummoner->getStatusAtack();$i++)
                        {
                           echo '<div class="stat-section"></div>';
                        }
                        echo'
                        </div>
                    </div>
                    <div class="defense">
                        <span>Defense</span>
                        <div class="statsbar">';
                        for($i=0;$i<=$objSummoner->getStatusDefense();$i++){
                           echo '<div class="stat-section"></div>';
                        }
                        echo'
                        </div>
                    </div>
                    
                    <div class="ability">
            <span>Ability</span>
            <div class="statsbar">';
                        for($i=0;$i<=$objSummoner->getStatusMagic();$i++){
                           echo '<div class="stat-section"></div>';
                        }
                        echo'
            </div>
          </div>
          
          <div class="difficulty">
            <span>Complexity </span>
            <div class="statsbar">';
                        for($i=0;$i<=$objSummoner->getStatusDifficulty();$i++){
                           echo '<div class="stat-section"></div>';
                        }
                        echo'
            </div>
          </div>
        </div>    
                    ';
                    
                    //MAESTRIA DE CAMPEAO
                    echo "<div class='col-xs-12' style='height: 140px; padding-left: 0px; padding-right: 0px;'>";
                        if(array_key_exists("0",$jsondecoded_CM)==true){
                            echo "<div height='134px' width='74px'>";
                                echo "<img style = 'position:absolute; top:9px; left:3px;' height='69' width='69' src='".imagemchamp($jsondecoded_CM[0]['championId'])."'>";
                                echo "<img style = 'position:absolute' height='134' width='74' src='img/Champ_Mastery/".$jsondecoded_CM[0]['championLevel'].".png'>";
                            echo "</div>";
                        }
                        if(array_key_exists("1",$jsondecoded_CM)==true){
                            echo "<div height='134px' width='74px'>";
                                echo "<img style = 'position:absolute; top:9px; left:82px;' height='69' width='69' src='".imagemchamp($jsondecoded_CM[1]['championId'])."'>";
                                echo "<img style = 'position:absolute; left:80px;'' height='134' width='74' src='img/Champ_Mastery/".$jsondecoded_CM[1]['championLevel'].".png'>";
                            echo "</div>";
                        }
                        if(array_key_exists("2",$jsondecoded_CM)==true){
                            echo "<div height='134px' width='74px'>";
                                echo "<img style = 'position:absolute; top:9px; left:162px;' height='69' width='69' src='".imagemchamp($jsondecoded_CM[2]['championId'])."'>";
                                echo "<img style = 'position:absolute;left:160px;' height='134' width='74' src='img/Champ_Mastery/".$jsondecoded_CM[2]['championLevel'].".png'>";
                                echo "</div>";
                        }
                    echo "</div>";
    /*
    position: absolute;
    left: 0px;
    top: 0px;
      "championPoints": 213480,
      "playerId": 550642,
      "championPointsUntilNextLevel": 0,
      "chestGranted": true,
      "championLevel": 5,
      "tokensEarned": 0,
      "championId": 48,
      "championPointsSinceLastLevel": 191880,
      "lastPlayTime": 1465349579000
   */
       ?>
       <div id="lanediv"></div>
        </span>
    	<!--CURRENT MATCH -->
    	<span id="currentMdiv" class = "content"></span>
    	<!--RUNAS -->
        <span id="callrunesdiv" style="overflow: scroll;"class = "content"></span>
    	<!--TROLL POINTS -->
        <span id="trollpointsdiv" class = "content"></span>
	</div><!-- conteiner fim -->
	</section>
        <!-- ||||||||||||||||||||||||||||||||FOOTER||||||||||||||||||||||||||||||||||||| -->
    <aside id="esquerdo">
    </aside>
	
	 <footer id="rodape">
	    <p class = "footer">Copyright © <b style="color:red">Red Devs</b> 2016 <?php echo getCountry($_SERVER["REMOTE_ADDR"]); ?> - <a href="About.html">About us</a></p>
	 </footer>
	</div>		
	<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<!-- ///////////////////////////////////////////////////////    Functions   ////////////////////////////////////////////////////////////// -->
	<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<script type="text/javascript" src="js/jsmain.js">//SCRIPT JS SEPARADO</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" 
integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" 
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js"></script>
<script>//codigo deve ficar separado ou no final sei la!
      //------script auto hide collapse---------
      $('.nav a').click(function() {
        $('.navbar-collapse').collapse('hide');  
      });
      //------------Fim do script----------------
</script>

</body>
