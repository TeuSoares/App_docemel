<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$lista = "";
$valorTotal = "";
$somarQuantidade = "";
$id_usuario = $_POST["id_usuario"];
$data = date("Y-m-d");
$texto = "";
$envia_sabor_email = "";
$realizarPedido = "";
$imagem = "";

$sql2 = "SELECT sum(valor) as somarTotal,sum(quantidade) as somarQuantidade,realizarPedido FROM encomendas
WHERE fk_id_usuario = $id_usuario and data = '$data' and situacao = 'Aguardando' ";
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
    // $valorTotal = str_replace(".",",",$valorTotal);

}

$sql = "SELECT encomendas.*,cidades.cidade,cidades.uf,nome,celular,logradouro,bairro,numero,realizarPedido FROM encomendas
INNER JOIN usuarios_docemel
ON encomendas.fk_id_usuario = id_usuario
INNER JOIN cidades
ON usuarios_docemel.cidade = codigo
WHERE fk_id_usuario = $id_usuario and data = '$data' and situacao = 'Aguardando' ";
$resultado = $conexao->query($sql);

while($registro = mysqli_fetch_array($resultado)){
    $sabor = $registro["sabor"];
    $quantidade = $registro["quantidade"];
    $valor = $registro["valor"];
    $id_pedido = $registro["id_pedido"];
    $nome = $registro["nome"];
    $logradouro = $registro["logradouro"];
    $bairro = $registro["bairro"];
    $cidade = $registro["cidade"];
    $uf = $registro["uf"];
    $numero = $registro["numero"];
    $celular = $registro["celular"];
    $realizarPedido = $registro["realizarPedido"];
    
    $valor = str_replace(".",",",$valor);
    $envia_sabor_email.="$sabor - $quantidade unidades <br>";

    if($sabor == "Prestígio"){
        $imagem = "img/Prestigio.jpg";
    }else if($sabor == "Doce de leite"){
        $imagem = "img/Doce-de-leite.jpg";
    }else if($sabor == "Brigadeiro"){
        $imagem = "img/Brigadeiro.jpg";
    }else if($sabor == "Nutella"){
        $imagem = "img/Nutella.jpg";
    }else if($sabor == "Leite Ninho"){
        $imagem = "img/Leite-ninho.jpg";
    }else{
        $imagem = "";
    }

    $lista.="
        <li>
            <div class='item-content'>
                <div class='item-inner'>
                    <img src='$imagem' width='44'/>
                    <div class='block-pedidos'>
                        <div class='item-title-row'>
                            <div class='item-title'>
                            <strong>$sabor</strong>
                            </div>
                        </div>
                        <div class='item-subtitle'>
                            <strong>$quantidade unidades</strong>
                        </div>
                    </div>
                </div>
                <div class='item-inner'>
                    <div class='block-pedidos'>
                        <div class='item-title-row'>
                            <div class='item-title'>
                                <strong>R$ $valor</strong>
                            </div>
                        </div>
                        <div class='item-subtitle text-align-center'>
                            <a href='#' class='text-color-red excluirSaborPedido' data='$id_pedido' onclick='removerPedido();'>
                                <strong>Remover</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    ";

    $texto = "<strong>Nome:</strong> $nome <br>
    <strong>Sabores:</strong> $envia_sabor_email 
    <strong>Valor Total:</strong> R$ $valorTotal <br>
    <strong>Realização do pedido:</strong> $realizarPedido <br>
    <strong>Celular:</strong> $celular <br>
    <strong>Logradouro:</strong> $logradouro <br>
    <strong>Bairro:</strong> $bairro <br>
    <strong>Numero:</strong> $numero <br>
    <strong>Cidade:</strong> $cidade/$uf ";

}

echo "$lista|$valorTotal|$somarQuantidade|$texto";
?>