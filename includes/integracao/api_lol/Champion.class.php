<?php

namespace integracao\api_lol;

class Champion
{
    protected $id;
    protected $key;
    protected $name;
    protected $title;
    protected $arrRole;
    
    public function __construct($rowChampion)
    {
        $this->id = $rowChampion['id'];
        $this->key = $rowChampion['key'];
        $this->name = $rowChampion['name'];
        $this->title = $rowChampion['title'];
        $this->arrRole = $rowChampion['tags'];
    }
    
    function getId()
    {
        return $this->id;
    }

    function getKey()
    {
        return $this->key;
    }

    function getName()
    {
        return $this->name;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getArrRole()
    {
        return $this->arrRole;
    }


   
}