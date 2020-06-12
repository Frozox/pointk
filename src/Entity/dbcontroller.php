<?php

namespace App\Entity;

class dbcontroller
{
    private $db;

    function connectGeepsDb(){
        $host='160.228.216.44';
        $username='annuaire';
        $passwd='SuperPandasTeam91!';
        $dbname ='annuaire';
        $port='3306';

        $this->db = mysqli_connect($host,$username,$passwd,$dbname,$port);

        return $this->db;
    }

    function connexionUtilisateur($user, $mdp){
        $sql = "SELECT count(*) FROM compte WHERE login='$user' AND password='$mdp'";
        $query = mysqli_query($this->db,$sql);
        $result = -1;
        if($query)
            $result = $query->fetch_assoc();

        return $result;
    }

    function getUtilisateurConnecte($user, $mdp){
        $sql = "SELECT * FROM compte WHERE login='$user' AND password='$mdp'";
        $query = mysqli_query($this->db,$sql);
        $result = -1;
        if($query)
            $result = $query->fetch_assoc();

        return $result;
    }
}

?>