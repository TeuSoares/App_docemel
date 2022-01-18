<?php

function  con_mysql(){
    $servidor = "localhost";
    $banco = "doce_mel";
    $usuario = "root";
    $senha = "";

    try{
        $con = new PDO("mysql:host=$servidor;dbname=$banco",
        $usuario,
        $senha

        );

        return $con;
        // echo "Conectou";
    }catch(PDOException $e){
        echo $e->getMessage();
    }

}

?>