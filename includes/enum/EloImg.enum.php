<?php

namespace enum;

abstract class EloImg
{
    const BLANK = "Elo/Blank.png";
    const BRONZE = "Elo/Bronze.png";
    const SILVER = "Elo/Silver.png";
    const GOLD = "Elo/Gold.png";
    const PLATINUM = "Elo/Platinum.png";
    const DIAMOND = "Elo/Diamond.png";
    const MASTER = "Elo/Master.png";
    const CHALLENGER = "Elo/Challenger.png";
    const UNRANKED = "Elo/Unranked.png";
    
    public static function getConst($name) {
        return constant("\\enum\EloImg::$name");
    }
     
}