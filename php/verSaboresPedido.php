<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$lista = "";
$valorTotal = "";
$somarQuantidade = "";
$data = date("Y-m-d");
$texto = "";
$envia_sabor_email = "";
$realizarPedido = "";
$imagem = "";
$id_usuario = $_POST["id_usuario"];

$sql2 = "SELECT sum(valor) as somarTotal,sum(quantidade) as somarQuantidade,realizarPedido FROM encomendas
WHERE situacao = 'Vendido' and fk_id_usuario = $id_usuario";
$resultado2 = $conexao->query($sql2);

while($registro2 = mysqli_fetch_array($resultado2)){
    $somarTotal = $registro2["somarTotal"];
    $somarQuantidade = $registro2["somarQuantidade"];
    $realizarPedido = $registro2["realizarPedido"];

    if($realizarPedido == "Entregar" and $somarQuantidade < 7){
        $valorTotal = $somarTotal + 3.00;
    }else{
        $valorTotal = $somarTotal;
    }

    $valorTotal = number_format($valorTotal, 2, ',', '.');

}

$sql3 = "SELECT sabor,quantidade FROM encomendas
INNER JOIN usuarios_docemel
ON encomendas.fk_id_usuario = id_usuario
WHERE situacao = 'Vendido' and fk_id_usuario = $id_usuario  ";
$resultado3 = $conexao->query($sql3);

while($registro3 = mysqli_fetch_array($resultado3)){
    $sabor = $registro3["sabor"];
    $quantidade = $registro3["quantidade"];
    
    $envia_sabor_email.= "
    <div class='item-inner'>
        <div class='item-title'><strong class='font-atividade'>$sabor:</strong></div>
        <div class='item-after'><strong class='badge color-red'>$quantidade Unidades</strong></div>
    </div>";

    $lista = "
        $envia_sabor_email
        <div class='item-inner'>
            <div class='item-title'><strong class='font-atividade'>Valor total:</strong></div>
            <div class='item-after'><strong class='badge color-red'>R$ $valorTotal</strong></div>
        </div>";

}

echo $lista;
?>