<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$leiteNinho = $_POST["leiteNinho"];   
$id_usuario = $_POST["id_usuario"];
$quantLEN = $_POST["quantLEN"];
$valorLEN = $_POST["valorLEN"];
$data = date("Y-m-d");

$SQL = "INSERT INTO encomendas (fk_id_usuario,sabor,quantidade,valor,data,realizarPedido,situacao,visualizacao) VALUES ($id_usuario,'$leiteNinho',$quantLEN,$valorLEN,'$data','','Aguardando',1) ";

if($conexao->query($SQL)){
    echo "Adicionado ao pedido";
}else{
    echo "Houve um erro na tentativa de adicionar ao carrinho. Tente novamente!!";
}

?>