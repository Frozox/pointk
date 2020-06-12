<?php

namespace App\Entity;

class connexionType
{
    protected $identifiant;
    protected $motdepasse;

    public function getIdentifiant(){
        return $this->identifiant;
    }

    public function setIdentifiant($_identifiant){
        $this->identifiant = $_identifiant;
    }

    public function getMotdepasse(){
        return $this->motdepasse;
    }

    public function setMotdepasse($_motdepasse){
        $this->motdepasse = $_motdepasse;
    }
}

?>