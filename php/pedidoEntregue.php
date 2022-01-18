<?php
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("funcoes2.php");

$id_usuario = $_POST["id_usuario"];   

$SQL = "UPDATE encomendas SET situacao = 'Entregue', visualizacao = 0 WHERE fk_id_usuario = $id_usuario and situacao = 'Vendido' and visualizacao = '1' ";

if($conexao->query($SQL)){
    echo "Entrega finalizada!!";
}else{
    echo "Houve um erro ao tentar finalizar a entrega. Tente Novamente!!";
}

?>