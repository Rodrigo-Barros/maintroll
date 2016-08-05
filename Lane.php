<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
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
    $server = "br";
    //----------------------------------------Server-------------------------------------------------
    $server = $_GET["server"];
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Dados do Invocador solicitante!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //----------------------------PEGAR O ID do invocador-----------------------------------------
    $summonid = $_GET["id"];
   // invocDados($summonid,$apikey,$drgver,$server);
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!COUNT LANES!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //Pega todas as Runas do Invocador (Gasta Requisição)
    $url = "https://"."$server".".api.pvp.net/api/lol/"."$server"."/v2.2/matchlist/by-summoner/"."$summonid"."?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5&api_key="."$apikey";

    $jsondecoded = json_decode((useCurl($url)),$assoc = true);
    if($jsondecoded == "404"){
        echo "<p>Algo não deveria ter acontecido...</p>";
    }else{
        
        for ($i=0;$i<=(count($jsondecoded["matches"])-1);$i++){
            switch ($jsondecoded["matches"][$i]["lane"]) {
                case "JUNGLE":
                        $JUNGLEcount++;
                    break;
                case "MID":
                        $MIDcount++;
                    break;
                case "MIDDLE":
                        $MIDDLEcount++;
                    break;
                case "TOP":
                        $TOPcount++;
                    break;
                case "BOT":
                        $BOTcount++;
                    break;
                case "BOTTOM":
                        $BOTTOMcount++;
                    break;
            }
            switch ($jsondecoded["matches"][$i]["role"]) {
                case "DUO":
                        $DUOcount++;
                    break;
                case "NONE":
                        $NONEcount++;
                    break;
                case "SOLO":
                        $SOLOcount++;
                    break;
                case "DUO_CARRY":
                        $DUO_CARRYcount++;
                    break;
                case "DUO_SUPPORT":
                        $DUO_SUPPORTcount++;
                    break;
            }
        }/*
            echo "<p>----------------Lane----------------</p>".
            "<p>JUNGLE: ".$JUNGLEcount."</p>".
            "<p>MID: ".$MIDcount."</p>".
            "<p>MIDDLE: ".$MIDDLEcount."</p>".
            "<p>TOP: ".$TOPcount."</p>".
            "<p>BOT: ".$BOTcount."</p>".
            "<p>BOTTOM: ".$BOTTOMcount."</p>".
            "<p>------------------Role---------------</p>".
            "<p>DUO: ".$DUOcount."</p>".
            "<p>NONE: ".$NONEcount."</p>".
            "<p>SOLO: ".$SOLOcount."</p>".
            "<p>DUO_CARRY: ".$DUO_CARRYcount."</p>".
            "<p>DUO_SUPPORT: ".$DUO_SUPPORTcount."</p>";*/
            
        $aux = abs(($BOTTOMcount - ($DUO_SUPPORTcount + $DUO_CARRYcount)) - $DUOcount);
        //echo "<p>aux: ".$aux."</p>";
        $aux = $DUOcount - $aux;
        //echo "<p>aux: ".$aux."</p>";
        $resto = $aux%2;
        //echo "<p>resto: ".$resto."</p>";
        $aux = (int)($aux/2);
        $total = ($JUNGLEcount+$MIDcount+$TOPcount+$BOTTOMcount);
        //echo "<p>aux: ".$aux."</p>";
?>      
<!--|||||||||||||||||||||||||||||||||||||||||||||HTML|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
        <div class="col-xs-12 col-md-6 col-lg-6 backgrounddef">
            <p style = "text-align: center;"><b>Main Ranked Lanes</b></p>
            <div class="trolllanes">
                <div class="legenda">
                    <!-- <p>Total: <b><?php echo  $total ?></b></p> -->
                    <p>ADC: <b id ='carry'><?php echo ($DUO_CARRYcount+$aux+$resto) ?></b></p>
                    <p>SUP: <b id ='support'><?php echo ($DUO_SUPPORTcount+$aux) ?></b></p>
                    <p>JUNGLE: <b id = 'jungle'><?php echo $JUNGLEcount?></b></p>
                    <p>MID: <b id = 'mid'><?php echo $MIDcount?></b></p>
                    <p>TOP: <b id = 'top'><?php echo $TOPcount?></b></p>
                </div>
                <div class="grafico">
          	        <canvas id="GraficoPizza"></canvas>
      	        </div>
            </div>
        </div>
    
<?php } //depois precisa tirar os espaços dos "b" ?>
</div>
</body>
</html>