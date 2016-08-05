<!DOCTYPE html>
<html>
<body>
<div>
    <p id="teste011"></p>
<?php
        include("PHP/Functions.php");
        //Atualizar os repositorios: sudo apt-get update
        //Instalando o curl do PHP: sudo apt-get instal php5-curl
        //$apikey = "5734c8f8-db53-4c88-bb17-25e0db0caa8d";//Key de desenvolvedor Johnner
        $apikey  ="9b3c87df-bbba-49aa-a5a3-7de0df4f6f6a";//Key de desenvolvedor Trunthor
        $apikey2 ="f83bba86-82b8-4f17-8200-7b2b86784d76";//Key de desenvolvedor Black Mormon
        $apikey3 ="b8d982d4-4eae-472b-8c6c-09512c94d25c";//Key de desenvolvedor BlindaoS2
        $server = "br";
        //----------------------------------------Server-------------------------------------------------
        $server = $_GET["server"];
        //-------------------------Atualizando o Dragon Date "6.11.1" 01/06/2016------------------------
        $drgver =  $_GET["dd"];
        //----------------------------PEGAR O ID do invocador-----------------------------------------
        $summonid = $_GET["id"];
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!CURRENT MATCH!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/976/3336
        $json_premade = '{"gameId":813289528,"mapId":11,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","gameQueueConfigId":410,"participants":[{"teamId":100,"spell1Id":4,"spell2Id":11,"championId":64,"profileIconId":1108,"summonerName":"Ojeda Love U","bot":false,"summonerId":21750147,"runes":[{"count":9,"runeId":5245},{"count":1,"runeId":5289},{"count":8,"runeId":5295},{"count":9,"runeId":5317},{"count":1,"runeId":5335},{"count":2,"runeId":5365}],"masteries":[{"rank":5,"masteryId":6111},{"rank":1,"masteryId":6122},{"rank":5,"masteryId":6131},{"rank":1,"masteryId":6142},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6321},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6343},{"rank":3,"masteryId":6351},{"rank":2,"masteryId":6352},{"rank":1,"masteryId":6362}]},{"teamId":100,"spell1Id":4,"spell2Id":14,"championId":53,"profileIconId":1151,"summonerName":"Drop o Bobinho","bot":false,"summonerId":476990,"runes":[{"count":8,"runeId":5245},{"count":1,"runeId":5251},{"count":9,"runeId":5299},{"count":9,"runeId":5317},{"count":3,"runeId":5365}],"masteries":[{"rank":5,"masteryId":6211},{"rank":1,"masteryId":6221},{"rank":5,"masteryId":6232},{"rank":1,"masteryId":6241},{"rank":5,"masteryId":6311},{"rank":1,"masteryId":6322},{"rank":5,"masteryId":6332},{"rank":1,"masteryId":6343},{"rank":5,"masteryId":6351},{"rank":1,"masteryId":6362}]},{"teamId":100,"spell1Id":4,"spell2Id":7,"championId":110,"profileIconId":568,"summonerName":"VAYNE IS MY MAIN","bot":false,"summonerId":5610179,"runes":[{"count":8,"runeId":5245},{"count":1,"runeId":5251},{"count":9,"runeId":5289},{"count":9,"runeId":5317},{"count":3,"runeId":5337}],"masteries":[{"rank":5,"masteryId":6114},{"rank":1,"masteryId":6122},{"rank":5,"masteryId":6134},{"rank":1,"masteryId":6142},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6322},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6343},{"rank":5,"masteryId":6351},{"rank":1,"masteryId":6362}]},{"teamId":100,"spell1Id":4,"spell2Id":14,"championId":25,"profileIconId":659,"summonerName":"Songbird Titan","bot":false,"summonerId":3263368,"runes":[{"count":9,"runeId":5273},{"count":9,"runeId":5290},{"count":9,"runeId":5317},{"count":3,"runeId":5357}],"masteries":[{"rank":5,"masteryId":6114},{"rank":1,"masteryId":6121},{"rank":5,"masteryId":6134},{"rank":1,"masteryId":6142},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6323},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6342},{"rank":5,"masteryId":6352},{"rank":1,"masteryId":6362}]},{"teamId":100,"spell1Id":14,"spell2Id":4,"championId":17,"profileIconId":777,"summonerName":"Captain Noburu","bot":false,"summonerId":543560,"runes":[{"count":6,"runeId":5245},{"count":3,"runeId":5247},{"count":2,"runeId":5289},{"count":7,"runeId":5290},{"count":9,"runeId":5317},{"count":2,"runeId":5337},{"count":1,"runeId":5357}],"masteries":[{"rank":5,"masteryId":6111},{"rank":1,"masteryId":6122},{"rank":5,"masteryId":6134},{"rank":1,"masteryId":6141},{"rank":5,"masteryId":6151},{"rank":1,"masteryId":6162},{"rank":5,"masteryId":6211},{"rank":1,"masteryId":6223},{"rank":5,"masteryId":6231},{"rank":1,"masteryId":6241}]},{"teamId":200,"spell1Id":4,"spell2Id":7,"championId":119,"profileIconId":962,"summonerName":"l xJP l","bot":false,"summonerId":542288,"runes":[{"count":9,"runeId":5245},{"count":5,"runeId":5289},{"count":4,"runeId":5301},{"count":2,"runeId":5305},{"count":2,"runeId":5311},{"count":5,"runeId":5317},{"count":3,"runeId":5337}],"masteries":[{"rank":5,"masteryId":6111},{"rank":1,"masteryId":6122},{"rank":5,"masteryId":6131},{"rank":1,"masteryId":6142},{"rank":5,"masteryId":6151},{"rank":1,"masteryId":6162},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6322},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6343}]},{"teamId":200,"spell1Id":4,"spell2Id":14,"championId":103,"profileIconId":588,"summonerName":"Pequeno Asiatico","bot":false,"summonerId":411175,"runes":[{"count":9,"runeId":5289},{"count":9,"runeId":5316},{"count":3,"runeId":5357},{"count":9,"runeId":5402}],"masteries":[{"rank":5,"masteryId":6114},{"rank":1,"masteryId":6122},{"rank":5,"masteryId":6134},{"rank":1,"masteryId":6141},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6322},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6343},{"rank":5,"masteryId":6351},{"rank":1,"masteryId":6362}]},{"teamId":200,"spell1Id":14,"spell2Id":4,"championId":43,"profileIconId":870,"summonerName":"Honor Games","bot":false,"summonerId":2105935,"runes":[{"count":9,"runeId":5273},{"count":9,"runeId":5289},{"count":9,"runeId":5317},{"count":3,"runeId":5357}],"masteries":[{"rank":5,"masteryId":6211},{"rank":1,"masteryId":6221},{"rank":5,"masteryId":6231},{"rank":1,"masteryId":6241},{"rank":5,"masteryId":6311},{"rank":1,"masteryId":6322},{"rank":5,"masteryId":6332},{"rank":1,"masteryId":6342},{"rank":5,"masteryId":6352},{"rank":1,"masteryId":6363}]},{"teamId":200,"spell1Id":11,"spell2Id":4,"championId":107,"profileIconId":588,"summonerName":"Werhli","bot":false,"summonerId":3171870,"runes":[{"count":9,"runeId":5253},{"count":6,"runeId":5295},{"count":3,"runeId":5296},{"count":9,"runeId":5317},{"count":3,"runeId":5368}],"masteries":[{"rank":5,"masteryId":6114},{"rank":1,"masteryId":6121},{"rank":5,"masteryId":6131},{"rank":1,"masteryId":6141},{"rank":5,"masteryId":6312},{"rank":1,"masteryId":6323},{"rank":5,"masteryId":6331},{"rank":1,"masteryId":6343},{"rank":5,"masteryId":6352},{"rank":1,"masteryId":6362}]},{"teamId":200,"spell1Id":3,"spell2Id":4,"championId":157,"profileIconId":23,"summonerName":"Y A N Z l N","bot":false,"summonerId":14710689,"runes":[{"count":7,"runeId":5245},{"count":2,"runeId":5247},{"count":9,"runeId":5289},{"count":9,"runeId":5317},{"count":3,"runeId":5337}],"masteries":[{"rank":5,"masteryId":6111},{"rank":1,"masteryId":6121},{"rank":5,"masteryId":6131},{"rank":1,"masteryId":6141},{"rank":5,"masteryId":6151},{"rank":1,"masteryId":6161},{"rank":5,"masteryId":6211},{"rank":1,"masteryId":6223},{"rank":5,"masteryId":6231},{"rank":1,"masteryId":6241}]}],"observers":{"encryptionKey":"WXUXMzLJHGO9RGoJdqf2b8MIydH9aNQG"},"platformId":"BR1","bannedChampions":[{"championId":203,"teamId":100,"pickTurn":1},{"championId":39,"teamId":200,"pickTurn":2},{"championId":238,"teamId":100,"pickTurn":3},{"championId":12,"teamId":200,"pickTurn":4},{"championId":50,"teamId":100,"pickTurn":5},{"championId":8,"teamId":200,"pickTurn":6}],"gameStartTime":1466421689183,"gameLength":1740}';
        //$url = "https://"."$server".".api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/".getServer($server)."/"."$summonid"."?api_key="."$apikey";
        //$jsondecoded = json_decode((useCurl($url)),$assoc = true);// UMA SOLICITACAO
        
        $jsondecoded = json_decode($json_premade,$assoc = true);// UMA SOLICITACAO
        if($jsondecoded == "404"){
        echo "<p style='color:white'>Nenhum partida ativa encontrada</p>";
        }else{
            //echo  "<p>Game Type: ".$jsondecoded["gameType"]."</p>";
            echo  "<p>Game Mode:  ".$jsondecoded["gameMode"]."</p>";
            echo  "<p>Mapa: ".$jsondecoded["mapId"]."</p>";
            echo  "<p>Game Length: ".$jsondecoded["gameLength"]."</p>";
            //Banidos

            //inicio tabela
            echo '
            <div class="container">
    		<div class="row">
    		<div class="col-xs-6 col-md-6">
    			<table class="table table-responsive">
    				<thead>
    					<tr>
    						<td style = "text-align: left"><p>BANS: Time 01</p></td>
    					</tr>
    				</thead>
    				<tbody>';
            //TABELA 1 
                echo "<tr><td style = 'text-align: left'>";
            for ($i=0;$i<=5;$i++){
                if($jsondecoded["bannedChampions"][$i]["teamId"]==100){
            echo  " <img height='32' width='32' src=".imagemchamp($jsondecoded["bannedChampions"][$i]["championId"])."> ";
                }
            }
                echo "</tr>";
            echo'
    				</tbody>
    			</table>
    		</div>
    		<div class="col-xs-6 col-md-6">
    			<table class="table table-responsive">
    				<thead>
    					<tr>
    						<td style = "text-align: right"><p>BANS: Time 02</p></td>
    					</tr>
    				</thead>
    				<tbody>';
            //Tabela 2
                echo "<tr><td style = 'text-align: right'>";
            for ($i=0;$i<=5;$i++){
                if($jsondecoded["bannedChampions"][$i]["teamId"]==200){
            echo  " <img height='32' width='32' src=".imagemchamp($jsondecoded["bannedChampions"][$i]["championId"])."> ";
                }
            }
                echo "</td></tr>";
            echo'
                        </tbody>
            			</table>
            		</div>
            	</div>';            
            
            //-------------------------------------------LISTA DE JOGADORES------------------------------------------
            //TIME 100
            echo '
    		<div class="row">
    		<div class="col-xs-12 col-md-6">
    		<!-- tabela para o current game  time 01-->	
    			<table style = "background-color: rgba(0,0,255,0.6)" class="table table-responsive table-hover-black">
    				<thead>
    					<tr class="info">
    						<td colspan="5" style="text-align: center">Time 01</td>
    					</tr>
    				</thead>
    				<tbody>
    				<tr style="color:white">
    				    <td class="text-center">Campeão</td>
    				    <td>Liga/Elo</td>
    				    <td>Vitórias</td>
    				    <td colspan="2">Derrotas</td>
    				</tr>';
             
            for ($i=0;$i<=9;$i++){
                if($jsondecoded["participants"][$i]["teamId"] == "100"){
                $jsondecodedelo = invocElo($jsondecoded["participants"][$i]["summonerId"],$apikey2);
                $playerId = $jsondecoded["participants"][$i]["summonerId"];
                echo "<tr>";
                echo "<td>";
                echo "<img class='img-align' height='32' width='32' src='https://ddragon.leagueoflegends.com/cdn/".$drgver."/img/profileicon/".$jsondecoded["participants"][$i]["profileIconId"].".png'>";
               // echo "</td>";
                //echo "<td>";
                echo  "<p class='text-center'>".$jsondecoded["participants"][$i]["summonerName"]."</p>";
                echo "</td>";                
                //echo  "<p> Team ".$jsondecoded["participants"][$i]["teamId"]."</p>";
                //echo  "<p>".$jsondecoded["participants"][$i]["summonerId"]."</p>";
                if($jsondecodedelo != "404"){
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>".$jsondecodedelo["$playerId"][0]["tier"]." ".$jsondecodedelo["$playerId"][0]["entries"][0]["division"]."</p>";
                    echo "</td>";
                    //Vitorias
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>Wins: " .$jsondecodedelo["$playerId"][0][entries][0][wins] . "</p>";
                    echo "</td>";
                    //Derrotas
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>Losses: " .$jsondecodedelo["$playerId"][0][entries][0][losses]. "</p>";
                    echo "</td>";
                }else{
                     echo '<td colspan="3" style="text-align: center"><p>Not Ranked</p></td>';
                }
                //imagem do campeão
                //API REFERENCE:  https://developer.riotgames.com/api/methods#!/1055/3622
                echo "<td>";
                echo "<img height='32' width='32' src=".imagemchamp($jsondecoded["participants"][$i]["championId"]).">";
                echo "</td>";
                echo "</tr>";
                }
            }
            echo'
    				</tbody>
    			</table>
    		</div>
    
    		<!-- col-xs-12 exibe apenas uma tabela por vez na versão mobile, col-xs-6 divide em duas tabelas a versão para desktops-->
    
    		<div class="col-xs-12 col-md-6">
    		<!--- tabela current game time 02-->
    			<table style = "background-color: rgba(222, 40, 40, 0.6)" class="table table-responsive table-hover-black">
    				<thead>
    					<tr class="danger">
    						<td colspan="5" style="text-align: center">Time 02</td>
    					</tr>
    				</thead>
    				<tbody>
    				<tr style="color:white">
    				    <td class="text-center">Campeão</td>
    				    <td>Liga/Elo</td>
    				    <td>Vitórias</td>
    				    <td colspan="2">Derrotas</td>
    				</tr>';
            //TIME 200
            for ($i=0;$i<=9;$i++){ 
                if($jsondecoded["participants"][$i]["teamId"] == "200"){
                $jsondecodedelo = invocElo($jsondecoded["participants"][$i]["summonerId"],$apikey3);
                $playerId = $jsondecoded["participants"][$i]["summonerId"];
                echo "<tr>";
                echo "<td>";
                echo "<img class='img-align' height='32' width='32' src='https://ddragon.leagueoflegends.com/cdn/".$drgver."/img/profileicon/".$jsondecoded["participants"][$i]["profileIconId"].".png'>";
               // echo "</td>";
                //echo "<td>";
                echo  "<p class='text-center'>".$jsondecoded["participants"][$i]["summonerName"]."</p>";
                echo "</td>";                
                //echo  "<p> Team ".$jsondecoded["participants"][$i]["teamId"]."</p>";
                //echo  "<p>".$jsondecoded["participants"][$i]["summonerId"]."</p>";
                if($jsondecodedelo != "404"){
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>".$jsondecodedelo["$playerId"][0]["tier"]." ".$jsondecodedelo["$playerId"][0]["entries"][0]["division"]."</p>";
                    echo "</td>";
                    //Vitorias
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>Wins: " .$jsondecodedelo["$playerId"][0][entries][0][wins] . "</p>";
                    echo "</td>";
                    //Derrotas
                    echo "<td style='vertical-align:middle'>";
                    echo  "<p>Losses: " .$jsondecodedelo["$playerId"][0][entries][0][losses]. "</p>";
                    echo "</td>";
                }else{
                     echo '<td colspan="3" style="text-align: center"><p>Not Ranked</p></td>';
                }
                //imagem do campeão
                //API REFERENCE:  https://developer.riotgames.com/api/methods#!/1055/3622
                echo "<td>";
                echo "<img height='32' width='32' src=".imagemchamp($jsondecoded["participants"][$i]["championId"]).">";
                echo "</td>";
                echo "</tr>";
                }
            }
            echo'
                        </tbody>
            			</table>
            		</div>
            	</div>';
        }
?>
</div>
</body>
</html>