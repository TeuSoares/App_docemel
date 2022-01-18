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
$data_format = ""; 
$data_formatNova = "";
$numberPedido = "";
$quantidadePedidos = "";

$quantidadePedidos = "";
$sql2 = "SELECT COUNT(DISTINCT fk_id_usuario) as quantidadePedidos FROM encomendas
WHERE situacao = 'Vendido' and visualizacao = 1 ";
$resultado2 = $conexao->query($sql2);

while($registro2 = mysqli_fetch_array($resultado2)){
    $quantidadePedidos = $registro2["quantidadePedidos"];
}

$sql = "SELECT encomendas.*,cidades.cidade,cidades.uf,nome,celular,logradouro,bairro,numero,realizarPedido,data FROM encomendas
INNER JOIN usuarios_docemel
ON encomendas.fk_id_usuario = id_usuario
INNER JOIN cidades
ON usuarios_docemel.cidade = codigo
WHERE situacao = 'Vendido' and visualizacao = 1 
GROUP BY fk_id_usuario
ORDER BY id_pedido DESC
LIMIT 20";
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
    $fk_id_usuario = $registro["fk_id_usuario"];
    $data = $registro["data"];
    
    $valor = str_replace(".",",",$valor);

    $data_format = explode('-', $data);
    $data_formatNova = $data_format[2].'/'.$data_format[1].'/'.$data_format[0];

    $lista.="
        <div class='list'>
            <ul>
                <li class='accordion-item'>
                    <a href='#' class='item-content item-link'>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='text-color-red'>$data_formatNova</strong></div>
                        <div class='item-after'><button class='col button button-small button-outline color-green entregue' data-user='$fk_id_usuario' onclick='finalizarEntrega();'>Entregue</button></div>
                    </div>
                    </a>
                    <div class='accordion-item-content item-content'>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Nome:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$nome</strong></div>
                    </div>
                    <div class='accordion-item'>
                        <a href='#' class='item-link sabores' data='$fk_id_usuario' onclick='verSaboresPedidos();'>
                            <div class='item-inner'>
                                <div class='item-title'><strong class='font-atividade'>Sabores</strong></div>
                            </div>
                        </a>
                        <div class='accordion-item-content clickSabores'>
                            
                        </div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Realização do pedido:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$realizarPedido</strong></div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Celular:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$celular</strong></div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Logradouro:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$logradouro</strong></div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Número:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$numero</strong></div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Bairro:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$bairro</strong></div>
                    </div>
                    <div class='item-inner'>
                        <div class='item-title'><strong class='font-atividade'>Cidade:</strong></div>
                        <div class='item-title'><strong class='font-atividade'>$cidade/$uf</strong></div>
                    </div>
                    </div>
                </li>
            </ul>
        </div>
    ";

}

echo "$lista|$quantidadePedidos";
?>