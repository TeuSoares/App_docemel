<?php
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("funcoes2.php");

$lista = "";
$valorTotal = "";
$somarQuantidade = "";
$texto = "";
$envia_sabor_email = "";
$realizarPedido = "";
$imagem = "";
$data_format = ""; 
$data_formatNova = "";
$numberPedido = "";
$quantidadePedidos = "";
$id_usuario = $_POST["id_usuario"];

$sql2 = "SELECT sum(valor) as somarTotal,sum(quantidade) as somarQuantidade,realizarPedido FROM encomendas
WHERE fk_id_usuario = $id_usuario  and situacao = 'Vendido' ";
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

$sql = "SELECT * FROM encomendas WHERE fk_id_usuario = $id_usuario and situacao = 'Vendido' ";
$resultado = $conexao->query($sql);

while($registro = mysqli_fetch_array($resultado)){
    $sabor = $registro["sabor"];
    $quantidade = $registro["quantidade"];
    $data = $registro["data"];
    $valor = $registro["valor"];
    
    $valor = str_replace(".",",",$valor);

    $data_format = explode('-', $data);
    $data_formatNova = $data_format[2].'/'.$data_format[1].'/'.$data_format[0];

    $envia_sabor_email.="
        <div class='item-inner'>
            <div class='item-title'><strong class='font-atividade'>$sabor:</strong></div>
            <div class='item-after'><strong class='font-atividade badge color-red'>$quantidade Unidades</strong></div>
            <div class='item-after'><strong class='font-atividade badge color-red'>R$ $valor</strong></div>
        </div>
    ";

    $lista ="
        <div class='list'>
            <ul>
            <li>
                <div class='item-content'>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='text-color-red'>$data_formatNova</strong></div>
                        <div class='item-after'><button class='col button button-small button-outline color-red cancelar'>Cancelar</button></div>
                    </div>
                </div>
            </li>
            <li>
                <div class='item-content'>
                    $envia_sabor_email
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Valor total do pedido</strong></div>
                        <div class='item-after'><strong class='font-atividade badge color-red'>R$ $valorTotal</strong></div>
                    </div>
                </div>
            </li>
            </ul>
        </div> 
    ";

}

echo $lista;
?>