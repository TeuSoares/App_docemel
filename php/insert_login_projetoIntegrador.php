<?php
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("funcoes2.php");

$id_usuario = 0;   // em caso de cadastro 
if(isset($_POST["id_usuario"])){
    $id_usuario = $_POST['id_usuario'];   // em caso de edição
}

$codigo = 0;
$cadastro = 1;

$cidade_autocomplete = explode("/",$_POST["cidade_autocomplete"]);

$cidade = $cidade_autocomplete[0];
$uf = $cidade_autocomplete[1];

$nome_c = $_POST['nome_c'];
$bairro = $_POST['bairro'];
$senha_c = MD5($_POST['senha_c']);
$celular = $_POST['celular'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$usuario = $_POST['usuario'];
$userName = $_POST['userName'];
// $cidade_autocomplete = $_POST['cidade_autocomplete'];

$lista = "";
$sql3 = "SELECT * FROM cidades WHERE cidade='$cidade' && uf='$uf' ";
$resultado3 = $conexao->query($sql3);

while($linha3 = mysqli_fetch_array($resultado3)){
    $codigo = $linha3["codigo"];
}

$existe = "";
// Verificando se usuário já existe
$sql2 = "SELECT * FROM usuarios_docemel WHERE usuario='$usuario' ";
$resultado2 = $conexao->query($sql2);

while($linha2 = mysqli_fetch_array($resultado2)){
    $usuario2 = $linha2["usuario"];

    if($usuario2 == $userName){
        $existe = "Gravar";
    }else if($usuario2 !=""){
        $existe = "Já existe";
    }else{
        $existe = "";
    }
}

$sql = "";
$mensagem = "";
if($existe == "Já existe"){
    $mensagem = "existe";
    $sql = "SELECT * FROM usuarios_docemel WHERE usuario='$usuario'";
}else{

    if($id_usuario > 0){
        $sql = "UPDATE usuarios_docemel SET nome='$nome_c',celular='$celular',logradouro='$logradouro',numero=$numero,bairro='$bairro',cidade=$codigo,usuario='$usuario',senha='$senha_c' 
        WHERE id_usuario = $id_usuario";
    
        $mensagem = "Editou";
    }else{
        $sql = "INSERT INTO usuarios_docemel (nome,celular,logradouro,numero,bairro,cidade,usuario,senha)
        VALUES ('$nome_c','$celular','$logradouro',$numero,'$bairro',$codigo,'$usuario','$senha_c')";
    
        $mensagem = "Cadastro";
    }

}

if($conexao->query($sql)){
    echo $mensagem;
}else{
    echo "ERRO: Houve um problema na inclusão. Tente novamente";
}

?>