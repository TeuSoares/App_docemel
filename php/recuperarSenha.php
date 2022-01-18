<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$id_usuario = $_POST["id_usuario"];  
$senhaNovaConf = MD5($_POST["senhaNovaConf"]); 

$SQL = "UPDATE usuarios_docemel SET senha = '$senhaNovaConf' WHERE id_usuario = $id_usuario ";

if($conexao->query($SQL)){
  echo  "Senha alterada com sucesso!!";
}else{
  echo  "Houve um problema ao alterar a senha. Tente novamente!!";
}

?>