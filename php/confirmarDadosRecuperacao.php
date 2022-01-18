<?php
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("funcoes2.php");

$id_usuario = "";
$usuario = "";
$celular = "";

$userRecuperar = $_POST["userRecuperar"];
$celularRecuperar = $_POST["celularRecuperar"];

$sql = "SELECT id_usuario,usuario,celular FROM usuarios_docemel WHERE usuario = '$userRecuperar' and celular = '$celularRecuperar' ";
$resultado = $conexao->query($sql);

while($registro = mysqli_fetch_array($resultado)){
    $id_usuario = $registro["id_usuario"];
    $usuario = $registro["usuario"];
    $celular = $registro["celular"];
}

echo "$id_usuario|$usuario|$celular";
?>