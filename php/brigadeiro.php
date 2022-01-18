<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$brigadeiro = $_POST["brigadeiro"];   
$id_usuario = $_POST["id_usuario"];
$quantBrigadeiro = $_POST["quantBrigadeiro"];
$valorBRI = $_POST["valorBRI"];
$data = date("Y-m-d");

$SQL = "INSERT INTO encomendas (fk_id_usuario,sabor,quantidade,valor,data,realizarPedido,situacao,visualizacao) VALUES ($id_usuario,'$brigadeiro',$quantBrigadeiro,$valorBRI,'$data','','Aguardando',1) ";

if($conexao->query($SQL)){
    echo "Adicionado ao pedido";
}else{
    echo "Houve um erro na tentativa de adicionar ao carrinho. Tente novamente!!";
}

?>