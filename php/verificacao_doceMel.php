<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$quantidadePedidos = "";

$sql = "SELECT COUNT(DISTINCT fk_id_usuario) as quantidadePedidos FROM encomendas
WHERE situacao = 'Vendido'";
$resultado = $conexao->query($sql);

while($registro = mysqli_fetch_array($resultado)){
    $quantidadePedidos = $registro["quantidadePedidos"];
}

echo $quantidadePedidos;
?>