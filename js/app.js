var app = new Framework7({
  // App root element
  root: '#app',
  // App Name
  name: 'My App',
  // App id
  id: 'com.myapp.test',
  // Enable swipe panel
  panel: {
    swipe: 'left',
  },
  // Add default routes
  routes: [
    {
      name: 'home',
      path: '/home/',
      url: 'index.html?a=x',
      on:{
        pageInit:function(){
          pageIndex();
        },
      }, 
    },
    {
      name: 'login',
      path: '/login/',
      url: 'login.html?a=c',
      on:{
        pageInit:function(){
          pageLogin();
        },
      }, 
    },
    {
      path: '/cadastro/',
      url: 'cadastro.html?a=b',
      on:{
        pageInit:function(){
          pageCadastro();
        },
      }, 
    },
    {
      name: 'encomendar',
      path: '/encomendar/',
      url: 'encomendar.html?a=6',
      on:{
        pageInit:function(){
          pageEncomendar();
        },
      }, 
    },
    {
      name: 'apresentacao',
      path: '/apresentacao/',
      url: 'apresentacao.html?a=5',
    },
    {
      name: 'adm',
      path: '/adm/',
      url: 'faturamentoADM.html?a=7',
      on:{
        pageInit:function(){
          pageADM();
        },
      }, 
    },
    {
      name: 'pedidos',
      path: '/pedidos/',
      url: 'pedidos.html?a=11',
      on:{
        pageInit:function(){
          pageEntregas();
        },
      }, 
    },
    {
      name: 'pedidosClientes',
      path: '/pedidosClientes/',
      url: 'pedidosClientes.html?a=10',
      on:{
        pageInit:function(){
          pagePedidoClientes();
        },
      }, 
    },
    {
      name: 'recuperarSenha',
      path: '/recuperarSenha/',
      url: 'recuperarSenha.html?a=10',
      on:{
        pageInit:function(){
          confirmarDadosRecuperacao();
          alterarSenha();
        },
      }, 
    },
  ],
  // ... other parameters
});
var mainView = app.views.create('.view-main');

var cod_usuario = localStorage.getItem("id_usuarioDoceMel");
var nome_user = localStorage.getItem("nome_doceMel");
var usuario_doceMel = localStorage.getItem("usuario_doceMel");

var popup = app.popup.open(".popup-inicial");

setTimeout(function(){
  var popupClose = app.popup.close(".popup-inicial", true);
}, 3000);

// Usuário painel - Docemel_adm // Senha - 258456dm

function pageLogin(){

  $(document).ready(function(){

    localStorage.removeItem("id_usuarioRecuperar");

    $("#entrar").on('click', function(e){
      e.preventDefault();
      
      var nome = $("#nome").val();
      var senha = $("#senha").val();
  
      if(nome.trim() == "" || senha.trim() == ""){
        app.dialog.alert("Os campos usuário e senha são obrigatórios","AVISO");
        return false
      }
  
      // Requisição AJAX
      app.request({
        // url:"php/login.php",
        url:"php/login_projeto.php",
        type:"POST",
        dataType:"json",
        data:$("#Formlogin").serialize(),
        success:function(data){
          if(data.resultado != 0){
  
            app.dialog.alert("Bem-Vindo "+data.nome,"AVISO");
  
            localStorage.setItem('id_usuarioDoceMel',data.id_usuario);
            localStorage.setItem('nome_doceMel',data.nome);
            localStorage.setItem('usuario_doceMel',data.usuario);

            var idLogin = localStorage.getItem("id_usuarioDoceMel");

            if(idLogin == "2"){
              mainView.router.navigate({name:'pedidos'});
              fechaAlert();
            }else{
              mainView.router.navigate({name:'home'});
              fechaAlert();
            }
  
          }else{
            app.dialog.alert("Usuário ou senha incorretos","AVISO");
          }
  
        },
        error:function(e){
  
        }
      });
  
    });

  });

}
  
function pageCadastro(){

  $(document).ready(function(){

    var v_id = localStorage.getItem('id_usuarioDoceMel');
    if(v_id!=""){ // Edição
      app.request.post('php/busca_perfil.php', {id_usuario: v_id}, function(resposta){
        dados = (resposta).split('|');  
        $("#nome_c").val(dados[0]);  
        $("#celular").val(dados[1]);
        $("#logradouro").val(dados[2]); 
        $("#numero").val(dados[3]);   
        $("#bairro").val(dados[4]);
        $("#cidade_autocomplete").val(dados[5]);
        $("#usuario").val(dados[6]); 
      });
    }

    $("#celular").mask("(00) 00000-0000");
    $("#numero").mask("00000");

    var listaCidades = "";
    app.request.post('php/lista_de_cidadesSP.php', { }, function (resposta) {
        listaCidades = (resposta).split(',');
    })
    
    var autocompleteDropdownSimple = app.autocomplete.create({
        inputEl: '#cidade_autocomplete',
        openIn: 'dropdown',
        source: function (query, render) {
          var results = [];
          if (query.length === 0) {
            render(results);
            return;
          }
          // Find matched items
          for (var i = 0; i < listaCidades.length; i++) {
            if (listaCidades[i].toLowerCase().indexOf(query.toLowerCase()) >= 0) results.push(listaCidades[i]);
          }
          // Render items by passing array with result items
          render(results);
        }
    });

    $("#cadastrar").on('click',function(e){
      e.preventDefault();
  
      var nome = $("#nome_c").val();
      var senha = $("#senha_c").val();
      var celular_c = $("#celular").val();
      var logradouro_c = $("#logradouro").val();
      var numero_c = $("#numero").val();
      var bairro_c = $("#bairro").val();
      var cidade_c = $("#cidade_autocomplete").val();
      var usuario_c = $("#usuario").val();
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var v_user = localStorage.getItem("usuario_doceMel");
    
      if(nome.trim() == "" || nome.length > 40 || nome.length < 5){
        app.dialog.alert("Informe nome e sobrenome","AVISO");
        return false;
      }
      if(celular_c.trim() == "" || celular_c.length > 15 || celular_c.length < 15){
        app.dialog.alert("Verifique a informação digitada no campo celular","AVISO");
        return false;
      }
      if(senha.trim() == "" || senha.length > 8 || senha.length < 6){
        app.dialog.alert("A senha deve conter entre 6 até 8 caracteres","AVISO");
        return false;
      }
      if(logradouro_c.trim() == "" || logradouro_c.length > 40 || logradouro_c.length < 2){
        app.dialog.alert("Verifique a informação digitada no campo logradouro","AVISO");
        return false;
      }
      if(numero_c.trim() == "" || numero_c.length > 4){
        app.dialog.alert("Verifique a informação digitada no campo número","AVISO");
        return false;
      }
      if(bairro_c.trim() == "" || bairro_c.length > 40 || bairro_c.length < 2){
        app.dialog.alert("Verifique a informação digitada no campo bairro","AVISO");
        return false;
      }
      if(cidade_c.trim() == ""){
        app.dialog.alert("Verifique a informação digitada no campo cidade","AVISO");
        return false;
      }
      if(usuario_c.trim() == "" || usuario_c.length > 15 || usuario_c.length < 2){
        app.dialog.alert("Verifique a informação digitada no campo usuário","AVISO");
        return false;
      }
    
      // INSERT
      //app.request.post('php/insert_login.php',{
      app.request.post('php/insert_login_projetoIntegrador.php',{
        nome_c:nome,
        usuario:usuario_c,
        celular:celular_c,
        senha_c:senha,
        bairro:bairro_c,
        cidade_autocomplete:cidade_c,
        numero:numero_c,
        logradouro:logradouro_c,
        id_usuario:v_id,
        userName:v_user,
      },
      function(resposta){

        if(resposta == "Cadastro"){
          app.dialog.alert("Cadastro realizado com sucesso","");
          mainView.router.navigate({name:'login'});
        }else if(resposta == "Editou"){
          app.dialog.alert("Dados atualizados com sucesso!!","");
          mainView.router.navigate({name:'home'});
        }else{
          app.dialog.alert("Este usuário já está em uso","AVISO");
        }  
        
      });
    
    });

  });

}

function pageIndex(){
  $(document).ready(function(){

    $("#btn-adicionar1").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var prestigio2 = $("#prestigio").val();
      var quantPristigio2 = $("#quantPristigio").val();

      if(quantPristigio2 == "" || quantPristigio2 < 1){
        app.dialog.alert("A quantidade não pode ser 0","AVISO");
        return false;
      }

      valorPagar = 5 * quantPristigio2;
      valorPagar = valorPagar.toFixed(2);

      app.request.post('php/prestigio.php', {id_usuario:v_id,prestigio:prestigio2,valorPrestigio:valorPagar,quantPristigio:quantPristigio2}, function(resposta){
    
        $("#quantPristigio").val(0);
        app.dialog.alert(resposta,"");
        fechaAlert();

      }); 

    });

    $("#btn-adicionar2").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var doceLeite2 = $("#doceLeite").val();
      var quantDCL2 = $("#quantDCL").val();

      if(quantDCL2 == "" || quantDCL2 < 1){
        app.dialog.alert("A quantidade não pode ser 0","AVISO");
        return false;
      }

      valorPagar = 5 * quantDCL2;
      valorPagar = valorPagar.toFixed(2);

      app.request.post('php/doce_de_leite.php', {id_usuario:v_id,doceLeite:doceLeite2,valorDLC:valorPagar,quantDCL:quantDCL2}, function(resposta){
    
        $("#quantDCL").val(0);
        app.dialog.alert(resposta,"");
        fechaAlert();

      }); 

    });

    $("#btn-adicionar3").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var brigadeiro2 = $("#brigadeiro").val();
      var quantBrigadeiro2 = $("#quantBrigadeiro").val();

      if(quantBrigadeiro2 == "" || quantBrigadeiro2 < 1){
        app.dialog.alert("A quantidade não pode ser 0","AVISO");
        return false;
      }

      valorPagar = 5 * quantBrigadeiro2;
      valorPagar = valorPagar.toFixed(2);

      app.request.post('php/brigadeiro.php', {id_usuario:v_id,brigadeiro:brigadeiro2,valorBRI:valorPagar,quantBrigadeiro:quantBrigadeiro2}, function(resposta){
    
        $("#quantBrigadeiro").val(0);
        app.dialog.alert(resposta,"");
        fechaAlert();

      }); 

    });

    $("#btn-adicionar4").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var nutella2 = $("#nutella").val();
      var quantNutella2 = $("#quantNutella").val();

      if(quantNutella2 == "" || quantNutella2 < 1){
        app.dialog.alert("A quantidade não pode ser 0","AVISO");
        return false;
      }

      valorPagar = 6 * quantNutella2;
      valorPagar = valorPagar.toFixed(2);

      app.request.post('php/nutella.php', {id_usuario:v_id,nutella:nutella2,valorNUT:valorPagar,quantNutella:quantNutella2}, function(resposta){
    
        $("#quantNutella").val(0);
        app.dialog.alert(resposta,"");
        fechaAlert();

      }); 

    });

    $("#btn-adicionar5").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      var leiteNinho2 = $("#leiteNinho").val();
      var quantLEN2 = $("#quantLEN").val();

      if(quantLEN2 == "" || quantLEN2 < 1){
        app.dialog.alert("A quantidade não pode ser 0","AVISO");
        return false;
      }

      valorPagar = 6 * quantLEN2;
      valorPagar = valorPagar.toFixed(2);

      app.request.post('php/leite_ninho.php', {id_usuario:v_id,leiteNinho:leiteNinho2,valorLEN:valorPagar,quantLEN:quantLEN2}, function(resposta){
    
        $("#quantLEN").val(0);
        app.dialog.alert(resposta,"");
        fechaAlert();

      }); 

    });

    $("#continuar").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioDoceMel");
      app.request.post('php/verPedido.php', {id_usuario:v_id}, function(resposta){
        dados = (resposta).split("|");
        
        if(dados[0] !=""){
          mainView.router.navigate({name:'encomendar'});
        }else{
          app.dialog.alert("Para continuar você precisa adicionar ao menos 1 sabor","AVISO");
        }

      }); 
      
    });

    // Excluir pedidos de 2 dias atás, que estavam situação aguardando
    var v_id = localStorage.getItem("id_usuarioDoceMel");
    app.request.post('php/excluir_pedidos_antigos.php', {id_usuario:v_id}, function(resposta){ }); 

    $(".logout").on("click", function(){
      localStorage.removeItem("id_usuarioDoceMel");
      localStorage.removeItem("nome_doceMel");
      mainView.router.navigate({name:'login'});
      localStorage.removeItem("usuario_doceMel");
    });
  });
}

function pageEncomendar(){
  $(document).ready(function(){
    var v_id = localStorage.getItem("id_usuarioDoceMel");

    app.request.post('php/verPedido.php', {id_usuario:v_id}, function(resposta){
      dados = (resposta).split("|");

      if(dados[0] !=""){
        $("#listaPedido").html(dados[0]);

        $("#pedido_email").val(dados[3]);

        $("#valorTotal").html("<strong class='color-total'>R$: "+dados[1]+"</strong>");

        $(document).on("click", ".excluirSaborPedido", function(){
          var id = $(this).attr('data');
          localStorage.setItem('id_pedido', id); 
        });
      }else{
        mainView.router.navigate({name:'home'});
      }
      
    }); 

  });
}

function retirar(){
  localStorage.setItem("realizarPedido","retirar");
  var v_id = localStorage.getItem("id_usuarioDoceMel");
  app.request.post('php/retirar.php', {id_usuario:v_id}, function(resposta){
    pageEncomendar();
  }); 
}

function entregar(){
  localStorage.setItem("realizarPedido","entregar");
  var v_id = localStorage.getItem("id_usuarioDoceMel");
  app.request.post('php/entregar.php', {id_usuario:v_id}, function(resposta){
    pageEncomendar();
  }); 
}

// Botão encomendar
function clickEncomendar(){

  var v_pedidoEmail = $("#pedido_email").val();
  var v_id = localStorage.getItem("id_usuarioDoceMel");
  var v_realizarPedido = localStorage.getItem("realizarPedido");

  if(v_realizarPedido == "" || v_realizarPedido == null){
    app.dialog.alert("Selecione como vai ser a realização do pedido","AVISO");
    return false;
  }

  app.request.post('php/verificacao_doceMel.php', {}, function(resposta){
    
    if(resposta >=20){
      app.dialog.alert("Já foi atingido a quantidade máxima de pedidos para esta semana. Seu pedido ficou agendado para a proxima semana","AVISO");
    }

  }); 

  app.request.post('php/encomendar_pedido.php', {id_usuario:v_id}, function(resposta){

    app.dialog.alert(resposta,"");
    app.views.current.router.back();
    localStorage.removeItem("realizarPedido");

  }); 

}

function removerPedido(){
  $(document).ready(function(){
    var id = localStorage.getItem('id_pedido');
    var v_id = localStorage.getItem('id_usuarioDoceMel');

    app.dialog.confirm("Deseja remover esse sabor do pedido?","",function(){
      app.request.post("php/removerPedido.php",{
        id_pedido:id,id_usuario:v_id
      },function(resposta){
          
        localStorage.removeItem("id_pedido");
        pageEncomendar();
          
      })
    });
  });
}

// Page ADM
function pageADM(){
  $(document).ready(function(){

    app.request.post('php/faturamentoADM.php', {}, function(resposta){
      dados = (resposta).split("|");

      $("#saboresVendidos").html(dados[0]);
      $("#faturamento").html(dados[1]);
      
    }); 

    $(".logout").on("click", function(){
      localStorage.removeItem("id_usuarioDoceMel");
      localStorage.removeItem("nome_doceMel");
      mainView.router.navigate({name:'login'});
      localStorage.removeItem("fk_id_usuario");
      localStorage.removeItem("usuario_doceMel");
    });

  });
}

// PageEntregas
function pageEntregas(){
  $(document).ready(function(){

    localStorage.removeItem("fk_id_usuario");

    app.request.post('php/verEntregas.php', {}, function(resposta){
      dados = (resposta).split("|");

      $(".pedidosEntrega").html(dados[0]);
      $(".numberPedidos").html("Total de pedidos("+dados[1]+")");

      $(document).on("click", ".sabores", function(){
        var id = $(this).attr('data');
        localStorage.setItem('fk_id_usuario', id); 
      });

      $(document).on("click", ".entregue", function(){
        var id2 = $(this).attr('data-user');
        localStorage.setItem('fk_id_usuario', id2); 
      });
      
    }); 

    $(".logout").on("click", function(){
      localStorage.removeItem("id_usuarioDoceMel");
      localStorage.removeItem("nome_doceMel");
      mainView.router.navigate({name:'login'});
      localStorage.removeItem("fk_id_usuario");
      localStorage.removeItem("usuario_doceMel");
    });

  });
}

function verSaboresPedidos(){
  $(document).ready(function(){
    var fk_user = localStorage.getItem("fk_id_usuario");

    app.request.post('php/verSaboresPedido.php', {id_usuario:fk_user}, function(resposta){

      $(".clickSabores").html(resposta);

    }); 

  });
}

function finalizarEntrega(){
  $(document).ready(function(){
    var fk_user = localStorage.getItem("fk_id_usuario");

    app.dialog.confirm("Deseja finalizar esse pedido?","",function(){

      app.request.post('php/pedidoEntregue.php', {id_usuario:fk_user}, function(resposta){

        app.dialog.alert(resposta);
        pageEntregas();
        localStorage.removeItem("fk_id_usuario");
        
      }); 

    });
  });
}

function pagePedidoClientes(){
  $(document).ready(function(){
    var v_id = localStorage.getItem("id_usuarioDoceMel");

    app.request.post('php/verPedidosClientes.php', {id_usuario:v_id}, function(resposta){

      $("#pedidoCliente").html(resposta);

      $(".cancelar").on("click", function(){
        app.dialog.confirm("Deseja cancelar esse pedido?","",function(){
          app.request.post('php/excluir_pedidos_cliente.php', {id_usuario:v_id}, function(resposta){
            app.dialog.alert("Pedido cancelado com sucesso!!","AVISO");
            mainView.router.navigate({name:'home'});
            fechaAlert();
          }); 
        });
      });

    }); 

  });
}

function confirmarDadosRecuperacao(){
  $(document).ready(function(){

    $(".recuperarSenha").hide();
    $(".alterarSenha").hide();
    $("#celularRecuperar").mask("(00) 00000-0000");

    $("#confDados").on("click", function(){
      var userRecuperar2 = $("#userRecuperar").val();
      var celularRecuperar2 = $("#celularRecuperar").val();

      app.request.post('php/confirmarDadosRecuperacao.php', {userRecuperar:userRecuperar2,celularRecuperar:celularRecuperar2}, function(resposta){
        dados = (resposta).split("|");
  
        if(dados[1] !="" && dados[2] !=""){
          $(".recuperarSenha").show();
          $(".alterarSenha").show();
          $(".confDados").hide();
          localStorage.setItem("id_usuarioRecuperar",dados[0]);
        }else{
          app.dialog.alert("Dados informados não existem","AVISO");
        }
  
      }); 
    });

  });
}

function alterarSenha(){
  $(document).ready(function(){

    $("#alterarSenha").on("click", function(){
      var v_id = localStorage.getItem("id_usuarioRecuperar");
      var novaSenha = $("#senhaNova").val();
      var senhaNovaConf2 = $("#senhaNovaConf").val();

      if(senhaNovaConf2 != novaSenha){
        app.dialog.alert("Digite a mesma senha nos dois campos","AVISO");
        return false;
      }else if(senhaNovaConf2.trim() == "" || senhaNovaConf2.length > 8 || senhaNovaConf2.length < 6){
        app.dialog.alert("A senha deve conter entre 6 á 8 caracteres!!","AVISO");
        return false;
      }else{
        app.request.post('php/recuperarSenha.php', {id_usuario:v_id,senhaNovaConf:senhaNovaConf2}, function(resposta){
        
          if(resposta == "Senha alterada com sucesso!!"){
            app.dialog.alert(resposta,"AVISO");
            localStorage.removeItem("id_usuarioRecuperar");
            mainView.router.navigate({name:'login'});
          }else{
            app.dialog.alert(resposta,"AVISO");
          }
    
        }); 
      }

    });

  });
}

$(document).ready(function(){
  if(cod_usuario == "2"){
    pageIndex();
    pageADM();
    pageEntregas();
    mainView.router.navigate({name:'pedidos'});
  }else if(cod_usuario){
    pageIndex();
  }else{
    mainView.router.navigate({name:'apresentacao'});
    pageLogin();
  }
});

function fechaAlert(){
  setTimeout(function(){
    app.dialog.close();
  },1000);
}