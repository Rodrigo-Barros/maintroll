<?php
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// ||||||||||||||||||||||||||||||||||||                          FUNCOES PHP                             |||||||||||||||||||||||||||||||||||||||||||||||||||
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // Recebe uma URL e retorna o JSON.

    function useCurl($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // SSL FIX
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($curl);
        //echo "<p>$url</p><p>Status: ". curl_getinfo($curl)["http_code"]."</p>";//Opcional <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<HELPER
        if((curl_getinfo($curl)["http_code"])=="200" ){
            curl_close($curl);
            $out = $json;
        }else{
            $out = curl_getinfo($curl)["http_code"];
            curl_close($curl);
        }
        return $out;
    }
    
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||    

    //Recebe o Id do invocador e devolve JSON com o nome, level e imagem do invocador.

    function invocDados($summonid) {
        global $server,$apikey;
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/1079/3724
        $url = "https://".$server.".api.pvp.net/api/lol/".$server."/v1.4/summoner/".$summonid."?api_key=" . "$apikey" ;
        $jsondecoded = json_decode((useCurl($url)),$assoc = true);
        return $jsondecoded;
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Recebe o Id do invocador e devolve JSON com informações do ELO.

    function invocElo($summonid,$apikey) {
        global $server,$drgver;
        //API REFERENCE:  https://developer.riotgames.com/api/methods#!/985/3356
        $url = "https://"."$server".".api.pvp.net/api/lol/"."$server"."/v2.5/league/by-summoner/"."$summonid"."/entry?api_key="."$apikey";
        $jsondecoded = json_decode((useCurl($url)),$assoc = true);
        return $jsondecoded;
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Recebe o nome do Elo e devolve URL da Imagem.

    function eloimg($elo){
        switch ($elo){
        case "BLANK":
                return "img/Elo/Blank.png";
        case "BRONZE":
                return "img/Elo/Bronze.png";
        case "SILVER":
                return "img/Elo/Silver.png";
        case "GOLD":
                return "img/Elo/Gold.png";
        case "PLATINUM":
                return "img/Elo/Platinum.png";
        case "DIAMOND":
                return "img/Elo/Diamond.png";
        case "MASTER":
                return "img/Elo/Master.png";
        case "CHALLENGER":
                return "img/Elo/Challenger.png";
        case "UNRANKED":
                return "img/Elo/Unranked.png";
        }
    }
    
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Imagem sei la

    function masteryCimg($mChamp){
                return "img/Champ_Mastery/".$mChamp;
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Retorna principais Tag dos campeoes
    
    function cTag($cTag){
        for($i=0;$i<=(count($array)-1);$i++){
            $counter++;
            $flag = 0;
            for($ii=0;$ii<=(count($cTag["tags"])-1);$ii++){
                
                if($cTag["tags"][$i] == $array[$ii]){
                    $arrayc[$ii]++;
                    $flag = 1;
                }
            }if($flag==1){
            $arrayc[]++;
            $array[] = $cTag["tags"][$i];
            }
        }
        $out = 0;
        for($i=0;$i<=(count($arrayc)-1);$i++){
        if($arrayc[$i] > $out)
        $out = $arrayc[$i];
        }

        
        
        
        return $counter;
    }
    
    
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Recebe o Id do campeão e devolve a URL da imagem.

    function imagemchamp($champId) {
            global $apikey,$drgver;
            $url2 = "https://global.api.pvp.net/api/lol/static-data/br/v1.2/champion/".$champId."?api_key="."$apikey";
            $jsondecoded2 = json_decode((useCurl($url2)),$assoc = true);
            if($jsondecoded2 == "404"){
            echo "<b>Erro 404</b>'";
            }else{
                if($jsondecoded2[name] == "Wukong")
                $jsondecoded2[name] = "MonkeyKing";
            $caracter = array(" ", "."); 
            return "https://ddragon.leagueoflegends.com/cdn/".$drgver."/img/champion/".str_replace($caracter,'',$jsondecoded2[name]).".png";//imagem do campeão
            }
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

     /* Função mostra as informações das Runas
     
     Parmetro 3 define qual informação está sendo solicitada:
    0 = Nome
    1 = Imagem
    2 = Descrição
    3 = Tier da runa
    4 = Atributo
    5 = Tag do atributo (removido)
    6 = flat ou perLevel(removido)
    7 = Tag do tipo da runa(removido)
    8 = ATRUBUTO(NOVO)
    Obs. Runa Hibrida muda algumas coisas e nao está implementado ainda */
    
    function runeinf($runeid,$jsondecoded,$case) {
        global $drgver;
        if($jsondecoded == "404"){
        echo "<b>Erro 404, algo n encontrado</b>'";
        }else{
            switch ($case) {
                case 0:
                    $out = $jsondecoded["data"][$runeid]["name"];
                    break;
                case 1:
                    $aux = $jsondecoded["data"][$runeid]["image"]["full"];
                    echo "<img class='img-runes' src='https://ddragon.leagueoflegends.com/cdn/".$drgver."/img/rune/".$aux."'>";
                    break;
                case 2:
                    $out = $jsondecoded["data"][$runeid]["description"];
                    break;
                case 3:
                    $out = $jsondecoded["data"][$runeid]["rune"]["tier"];
                    break;
                case 4:
                    $aux = key($jsondecoded["data"][$runeid]["stats"]);
                    $out = $jsondecoded["data"][$runeid]["stats"][$aux];
                    break;
                    /*
                case 5:
                    $out = $jsondecoded["data"][$runeid]["tags"][0];
                    break;
                case 6:
                    $out = $jsondecoded["data"][$runeid]["tags"][1];
                    break;
                case 7:
                    $out = $jsondecoded["data"][$runeid]["tags"][2];
                    break; */
                case 8:
                    $out = key($jsondecoded["data"][$runeid]["stats"]);
                    break;
            }
            return $out;
        }
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    //Conta quantas runas a pagina tem.
    
    function runecontest($jsondecoded,$summonid,$runepage){
        if(array_key_exists("slots",$jsondecoded[$summonid]["pages"]["$runepage"])==true){
            $out = count($jsondecoded[$summonid]["pages"]["$runepage"]["slots"]);
        }else{
        $out = 0;
        }
        return $out;
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        
    //Determina qual Role é a principal com base nos 5 champs de maior maestria

    function whoRole($championMastery,$apikey,$server){
        for($i=0;$i<=4;$i++){
            $url = 'https://global.api.pvp.net/api/lol/static-data/'.$server.'/v1.2/champion/'.$championMastery[$i]['championId'].'?champData=tags&api_key='.$apikey;
            $jsondecoded_cTags = json_decode((useCurl($url)),$assoc = true);
//            nasaPrint($jsondecoded_cTags);
            $principalRoles[] = $jsondecoded_cTags["tags"][0];
            for($ii=0;$ii<=(count($jsondecoded_cTags["tags"])-1);$ii++){
                $allRoles[] = $jsondecoded_cTags["tags"][$ii];
            }
        }
        $contagem = array_count_values($allRoles);
        nasaPrint($contagem);
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
        //echo "<p>$role - $vezes</p>";
        }
        return $mainrole;
    }

// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // Pega o id da pessoa no site e devolve a tag do país (está em desenvolvimento).

    function getCountry($ip){
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
        
        if($xml->geoplugin_status == 200){
        return $xml->geoplugin_countryCode ;
        }
        else{
            $out = $xml->geoplugin_status;
        return $out;
        }
    }
    
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    //    
    function getServer($server){
        switch ($server) {
                case    'br':
                    return 'BR1';
                case	'eune':
                    return 'EUN1';
				case	'euw':
				    return 'EUW1';
				case	'jp':
				    return 'JP1';
				case	'kr':
				    return 'KR';
				case	'lan':
				    return 'LA1';
				case	'las':
				    return 'LA2';
				case	'na':
				    return 'NA1';
				case	'oce':
				    return 'OC1';
				case	'ru':
				    return 'RU';
				case	'tr':
				    return 'TR1';
        }
    }
    
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // Compara o valor da runa com o respectivo valor da Quintaessencia.
    
    function runevalor($runeid,$jsondecoded) {
        if($jsondecoded == "404"){
        echo "<b>Erro 404, algo n encontrado</b>'";
        }else{
            $atbkey = key($jsondecoded["data"][$runeid]["stats"]);
            $atbR = $jsondecoded["data"][$runeid]["stats"][$atbkey];
            switch ($atbkey) {
                case key($jsondecoded["data"][5336]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5336]["stats"]);
                        $atbQ = $jsondecoded["data"][5336]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5337]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5337]["stats"]);
                        $atbQ = $jsondecoded["data"][5337]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5339]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5339]["stats"]);
                        $atbQ = $jsondecoded["data"][5339]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5341]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5341]["stats"]);
                        $atbQ = $jsondecoded["data"][5341]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5343]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5343]["stats"]);
                        $atbQ = $jsondecoded["data"][5343]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5345]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5345]["stats"]);
                        $atbQ = $jsondecoded["data"][5345]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5346]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5346]["stats"]);
                        $atbQ = $jsondecoded["data"][5346]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5347]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5347]["stats"]);
                        $atbQ = $jsondecoded["data"][5347]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5348]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5348]["stats"]);
                        $atbQ = $jsondecoded["data"][5348]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5349]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5349]["stats"]);
                        $atbQ = $jsondecoded["data"][5349]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5350]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5350]["stats"]);
                        $atbQ = $jsondecoded["data"][5350]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5351]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5351]["stats"]);
                        $atbQ = $jsondecoded["data"][5351]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5352]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5352]["stats"]);
                        $atbQ = $jsondecoded["data"][5352]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5355]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5355]["stats"]);
                        $atbQ = $jsondecoded["data"][5355]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5356]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5356]["stats"]);
                        $atbQ = $jsondecoded["data"][5356]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5357]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5357]["stats"]);
                        $atbQ = $jsondecoded["data"][5357]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5358]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5358]["stats"]);
                        $atbQ = $jsondecoded["data"][5358]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5359]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5359]["stats"]);
                        $atbQ = $jsondecoded["data"][5359]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5360]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5360]["stats"]);
                        $atbQ = $jsondecoded["data"][5360]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5361]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5361]["stats"]);
                        $atbQ = $jsondecoded["data"][5361]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5362]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5362]["stats"]);
                        $atbQ = $jsondecoded["data"][5362]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5363]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5363]["stats"]);
                        $atbQ = $jsondecoded["data"][5363]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5365]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5365]["stats"]);
                        $atbQ = $jsondecoded["data"][5365]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5366]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5366]["stats"]);
                        $atbQ = $jsondecoded["data"][5366]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5367]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5367]["stats"]);
                        $atbQ = $jsondecoded["data"][5367]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5368]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5368]["stats"]);
                        $atbQ = $jsondecoded["data"][5368]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5373]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5373]["stats"]);
                        $atbQ = $jsondecoded["data"][5373]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5374]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5374]["stats"]);
                        $atbQ = $jsondecoded["data"][5374]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5406]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5406]["stats"]);
                        $atbQ = $jsondecoded["data"][5406]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5409]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5409]["stats"]);
                        $atbQ = $jsondecoded["data"][5409]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5412]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5412]["stats"]);
                        $atbQ = $jsondecoded["data"][5412]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][5418]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][5418]["stats"]);
                        $atbQ = $jsondecoded["data"][5418]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][8019]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][8019]["stats"]);
                        $atbQ = $jsondecoded["data"][8019]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][8020]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][8020]["stats"]);
                        $atbQ = $jsondecoded["data"][8020]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][8021]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][8021]["stats"]);
                        $atbQ = $jsondecoded["data"][8021]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][8022]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][8022]["stats"]);
                        $atbQ = $jsondecoded["data"][8022]["stats"][$atbkeyQ];
                    break;
                case key($jsondecoded["data"][8035]["stats"]):
                        $atbkeyQ = key($jsondecoded["data"][8035]["stats"]);
                        $atbQ = $jsondecoded["data"][8035]["stats"][$atbkeyQ];
                    break;
                default:
                    $atbQ = 0;
            }
            //echo "<p>(100 x ".abs($atbR).")/".abs($atbQ)."=".(100*abs($atbR))/abs($atbQ)."</p>";
            return (abs($atbQ)/abs($atbR));
        }
    }
// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
   
    // Compara a identificação do tipo da runa e devolve o nome limpo na liguagem correta.
    
    function runetype($atbkey,$language) {
        switch ($atbkey) {
            case "FlatArmorMod":
                if($language == "pt_BR")
                return "Armadura";
                else
                return "Armor";
            case "FlatAttackSpeedMod":
                if($language == "pt_BR")
                return "Velocidade de ataque"; 
                else
                return "Attack Speed";
            case "FlatBlockMod":
                if($language == "pt_BR")
                return "Block"; 
                else
                return "Block";
            case "FlatCritChanceMod":
                if($language == "pt_BR")
                return "Crit Chance %"; 
                else
                return "Crit Chance %";
            case "FlatCritDamageMod":
                if($language == "pt_BR")
                return "Dano Crítico"; 
                else
                return "Crit Damage";
            case "FlatEXPBonus":
                if($language == "pt_BR")
                return "EXP Bonus"; 
                else
                return "EXP Bonus";
            case "FlatEnergyPoolMod":
                if($language == "pt_BR")
                return "Energia"; 
                else
                return "Energy Pool";
            case "FlatEnergyRegenMod":
                if($language == "pt_BR")
                return "Regerção de Energia"; 
                else
                return "Energy Regen";
            case "FlatHPPoolMod":
                if($language == "pt_BR")
                return "HP"; 
                else
                return "HP Pool";
            case "FlatHPRegenMod":
                if($language == "pt_BR")
                return "Regeneração de HP"; 
                else
                return "HP Regen";
            case "FlatMPPoolMod":
                if($language == "pt_BR")
                return "MP"; 
                else
                return "MP Pool";
            case "FlatMPRegenMod":
                if($language == "pt_BR")
                return "Regeneração de MP"; 
                else
                return "MP Regen";
            case "FlatMagicDamageMod":
                if($language == "pt_BR")
                return "Dano Mágico"; 
                else
                return "Magic Damage";
            case "FlatMovementSpeedMod":
                if($language == "pt_BR")
                return "Velocidade de Movimento"; 
                else
                return "Movement Speed";
            case "FlatPhysicalDamageMod":
                if($language == "pt_BR")
                return "Dano Físico"; 
                else
                return "Physical Damage";
            case "FlatSpellBlockMod":
                if($language == "pt_BR")
                return "Defesa Mágica"; 
                else
                return "Spell Block";
            case "PercentArmorMod":
                if($language == "pt_BR")
                return "Armadura %"; 
                else
                return "Armor %";
            case "PercentAttackSpeedMod":
                if($language == "pt_BR")
                return "Velocidade de Ataque %"; 
                else
                return "Attack Speed %";
            case "PercentBlockMod":
                if($language == "pt_BR")
                return "Block"; 
                else
                return "Block";
            case "PercentCritChanceMod":
                if($language == "pt_BR")
                return "Crit Chance %"; 
                else
                return "Crit Chance %";
            case "PercentCritDamageMod":
                if($language == "pt_BR")
                return "Crit Damage %"; 
                else
                return "Crit Damage %";
            case "PercentDodgeMod":
                if($language == "pt_BR")
                return "Dodge %"; 
                else
                return "Dodge %";
            case "PercentEXPBonus":
                if($language == "pt_BR")
                return "EXP Bonus %"; 
                else
                return "EXP Bonus %";
            case "PercentHPPoolMod":
                if($language == "pt_BR")
                return "HP %"; 
                else
                return "HP Pool %";
            case "PercentHPRegenMod":
                if($language == "pt_BR")
                return "Regeneração de HP %"; 
                else
                return "HP Regen %";
            case "PercentLifeStealMod":
                if($language == "pt_BR")
                return "Roubo de Vida %"; 
                else
                return "Life Steal %";
            case "PercentMPPoolMod":
                if($language == "pt_BR")
                return "MP"; 
                else
                return "MP Pool";
            case "PercentMPRegenMod":
                if($language == "pt_BR")
                return "Regeneração de MP %"; 
                else
                return "MP Regen %";
            case "PercentMagicDamageMod":
                if($language == "pt_BR")
                return "Dano Mágico %"; 
                else
                return "Magic Damage %";
            case "PercentMovementSpeedMod":
                if($language == "pt_BR")
                return "Velocidade de Movimento %"; 
                else
                return "Movement Speed %";
            case "PercentPhysicalDamageMod":
                if($language == "pt_BR")
                return "Dano Físico %"; 
                else
                return "Physical Damage %";
            case "PercentSpellBlockMod":
                if($language == "pt_BR")
                return "Defesa Mágica %"; 
                else
                return "Spell Block %";
            case "PercentSpellVampMod":
                if($language == "pt_BR")
                return "Vampirismo Mágico %"; 
                else
                return "Spell Vamp %";
            case "rFlatArmorModPerLevel":
                if($language == "pt_BR")
                return "Armor"; 
                else
                return "Armor";
            case "rFlatArmorPenetrationMod":
                if($language == "pt_BR")
                return "Penetração de Armadura"; 
                else
                return "Armor Penetration";
            case "rFlatArmorPenetrationModPerLevel":
                if($language == "pt_BR")
                return "Penetração de Armadura P/L"; 
                else
                return "Armor Penetration P/L";
            case "rFlatCritChanceModPerLevel":
                if($language == "pt_BR")
                return "Crit Chance P/L %"; 
                else
                return "CritChance P/L %";
            case "rFlatCritDamageModPerLevel":
                if($language == "pt_BR")
                return "Crit Damage P/L %"; 
                else
                return "Crit Damage P/L %";
            case "rFlatDodgeMod":
                if($language == "pt_BR")
                return "Dodge"; 
                else
                return "Dodge";
            case "rFlatDodgeModPerLevel":
                if($language == "pt_BR")
                return "Dodge P/L"; 
                else
                return "Dodge P/L";
            case "rFlatEnergyModPerLevel":
                if($language == "pt_BR")
                return "Energy P/L"; 
                else
                return "Energy P/L";
            case "rFlatEnergyRegenModPerLevel":
                if($language == "pt_BR")
                return "Regeneração de Energia P/L"; 
                else
                return "Energy Regen P/L";
            case "rFlatGoldPer10Mod":
                if($language == "pt_BR")
                return "Gold P10s"; 
                else
                return "Gold P10s";
            case "rFlatHPModPerLevel":
                if($language == "pt_BR")
                return "HP P/L"; 
                else
                return "HP P/L";
            case "rFlatHPRegenModPerLevel":
                if($language == "pt_BR")
                return "Regeneração de HP P/L"; 
                else
                return "HP Regen P/L";
            case "rFlatMPModPerLevel":
                if($language == "pt_BR")
                return "MP P/L"; 
                else
                return "MP P/L";
            case "rFlatMPRegenModPerLevel":
                if($language == "pt_BR")
                return "Regeneração e MP P/L"; 
                else
                return "MP Regen";
            case "rFlatMagicDamageModPerLevel":
                if($language == "pt_BR")
                return "Dano Mágico P/L"; 
                else
                return "Magic Damage P/L";
            case "rFlatMagicPenetrationMod":
                if($language == "pt_BR")
                return "Penetração Mágica"; 
                else
                return "Magic Penetration";
            case "rFlatMagicPenetrationModPerLevel":
                if($language == "pt_BR")
                return "Penetração Mágica P/L"; 
                else
                return "Magic Penetration P/L";
            case "rFlatMovementSpeedModPerLevel":
                if($language == "pt_BR")
                return "Velocidade de Movimento P/L"; 
                else
                return "Movement Speed";
            case "rFlatPhysicalDamageModPerLevel":
                if($language == "pt_BR")
                return "Dano Físico P/L"; 
                else
                return "Physical Damage P/L";
            case "rFlatSpellBlockModPerLevel":
                if($language == "pt_BR")
                return "Defesa Mágica P/L"; 
                else
                return "Spell Block P/L";
            case "rFlatTimeDeadMod":
                if($language == "pt_BR")
                return "Time Dead"; 
                else
                return "Time Dead";
            case "rFlatTimeDeadModPerLevel":
                if($language == "pt_BR")
                return "Time Dead P/L"; 
                else
                return "Time Dead P/L";
            case "rPercentArmorPenetrationMod":
                if($language == "pt_BR")
                return "Penetração de Armadura"; 
                else
                return "Armor Penetration";
            case "rPercentArmorPenetrationModPerLevel":
                if($language == "pt_BR")
                return "Penetração de Armadura P/L"; 
                else
                return "Armor Penetration P/L";
            case "rPercentAttackSpeedModPerLevel":
                if($language == "pt_BR")
                return "Velocidade de Ataque %"; 
                else
                return "Attack Speed %";
            case "rPercentCooldownMod":
                if($language == "pt_BR")
                return "Cooldown %"; 
                else
                return "Cooldown %";
            case "rPercentCooldownModPerLevel":
                if($language == "pt_BR")
                return "Cooldown P/L %"; 
                else
                return "Cooldown P/L %";
            case "rPercentMagicPenetrationMod":
                if($language == "pt_BR")
                return "Armor"; 
                else
                return "Magic Penetration";
            case "rPercentMagicPenetrationModPerLevel":
                if($language == "pt_BR")
                return "Penetração Mágica P/L %"; 
                else
                return "MagicPenetration P/L %";
            case "rPercentMovementSpeedModPerLevel":
                if($language == "pt_BR")
                return "Velocidade de Movimento %"; 
                else
                return "Movement Speed %";
            case "rPercentTimeDeadMod":
                if($language == "pt_BR")
                return "Time Dead %"; 
                else
                return "Time Dead %";
            case "rPercentTimeDeadModPerLevel":
                if($language == "pt_BR")
                return "Time Dead %"; 
                else
                return "Time Dead %";
        }
    }
    
    function nasaPrint($string)
    {
        echo "<div style='width: 80%; margin: 0 auto;background-color:white;color='black'>";
        echo "<pre>";
        print_r($string);
        echo "</pre>";
        echo "</div>";
    }
?>