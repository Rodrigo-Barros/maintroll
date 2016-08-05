<?php

namespace enum;

abstract class ServerSigla
{
    const br = "BR1";
    const eune = "EUN1";
    const euw = "EUW1";
    const jp = "JP1";
    const kr = "KR";
    const lan = "LA1";
    const las = "LA2";
    const na = "NA1";
    const oce = "OC1";
    const ru = "RU";
    const tr = "TR1";
    
    
    public static function getConst($name) {
        
        return constant("\\enum\ServerSigla::$name");
    }
     
}