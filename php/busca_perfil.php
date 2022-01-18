<?php
header("Access-Control-Allow-Origin:*");
include("funcoes2.php");

$nome= "";
$celular = "";
$logradouro= "";
$numero = "";
$bairro = "";
$cidade= "";
$uf = "";
$usuario = "";
$senha = ""; 

$id_usuario = $_POST['id_usuario'];   // em caso de edição

if($id_usuario > 0){
	$sql = "SELECT id_usuario,nome,celular,logradouro,numero,bairro,usuario,senha,cidades.cidade,cidades.uf
	FROM usuarios_docemel
	INNER JOIN cidades
	ON usuarios_docemel.cidade = codigo
	WHERE id_usuario = $id_usuario ";
	$resultado = $conexao->query($sql);

	while($linha = mysqli_fetch_array($resultado)){
		$nome = $linha["nome"];
		$celular = $linha["celular"];
		$logradouro = $linha["logradouro"];
		$numero = $linha["numero"];
		$bairro = $linha["bairro"];
		$cidade = $linha["cidade"];
		$uf = $linha["uf"];
		$usuario = $linha["usuario"];
		$senha = $linha["senha"];
	}
}else{
	$sql = "";
}

echo "$nome|$celular|$logradouro|$numero|$bairro|$cidade/$uf|$usuario|$senha";
?>