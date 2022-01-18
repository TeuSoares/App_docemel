<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$lista = "";
$lista2 = "";
$lucro = "";
$quantidadeVendida = "";

$sql2 = "SELECT SUM(quantidade) as quantidadeVendida,SUM(valor) as lucro,data FROM encomendas
WHERE MONTH(data) =  MONTH(now()) and situacao = 'Entregue' ";
$resultado2 = $conexao->query($sql2);

while($registro2 = mysqli_fetch_array($resultado2)){
    $lucro = $registro2["lucro"];
    $quantidadeVendida = $registro2["quantidadeVendida"];

    $lucro = number_format($lucro, 2, ',', '.');

    $lista2 ="  
        <li>
            <div class='item-content'>
                <div class='item-inner'>
                    <div class='item-title'><strong class='font-atividade'>Quantidade vendida:</strong></div>
                    <div class='item-after'><strong class='badge color-red'>$quantidadeVendida unidades</strong></div>
                </div>
            </div>
        </li>
        <li>
            <div class='item-content'>
                <div class='item-inner'>
                    <div class='item-title'><strong class='font-atividade'>Lucro:</strong></div>
                    <div class='item-after'><strong class='badge color-red'>R$ $lucro</strong></div>
                </div>
            </div>
        </li>
    ";

}

$sql = "SELECT sabor,SUM(quantidade) as quantidadeVendida2,SUM(valor) as lucro2,data FROM encomendas
WHERE MONTH(data) =  MONTH(now()) and situacao = 'Entregue'
GROUP BY sabor 
ORDER BY quantidadeVendida2 DESC ";
$resultado = $conexao->query($sql);

while($registro = mysqli_fetch_array($resultado)){
    $sabor = $registro["sabor"];
    $lucro2 = $registro["lucro2"];
    $quantidadeVendida2 = $registro["quantidadeVendida2"];
    
    $lucro = str_replace(".",",",$lucro);

    $lista.="
        <li>
            <div class='item-content'>
                <div class='item-inner'>
                    <div class='item-title'><strong class='font-atividade'>$sabor - $quantidadeVendida2 unidades</strong></div>
                    <div class='item-after'><strong class='badge color-red'>R$ $lucro2</strong></div>
                </div>
            </div>
        </li>
    ";

}

echo "$lista|$lista2";
?>