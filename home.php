<?php
	session_start();
	require_once 'funcoes.php';

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		deslogar();

		header('Location: index.php');
	}
	else{

		if(!isset($_SESSION['usuario'])){

			header('Location: index.php');
		}
		else{

			$user=obterUsurLogado();

		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home|SINEP</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="./css/home.css"/>
		<script src="./js/jquery.min.js"></script>
		<script>
			$(function(){

				$(".cabecalho").append($("<div />").addClass("menu").append($("<ul />").append($("<li />").attr("id","amigos").text("MOSTRAR AMIGOS")).append($("<li />").append($("<form/>").attr({"method":"POST" , "action": "#"}).append($("<input/>").attr({"type": "submit" , "class":"bmenu" , "value": "SAIR"}))))).slideUp());

				$(".cabecalho").hover(function(){
					$("#img").attr("src","./img/menuw.png");
				})
				$(".cabecalho").mouseleave(function(){
					$("#img").attr("src", "./img/menub.png");
					$(".menu").slideUp("fast");
				})

				$(".cabecalho #img").click(function(){
					$(".menu").slideToggle("fast");
				});
			});
		</script>
		<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Rubik|Varela+Round" rel="stylesheet">
		<style>
			body{
				background: url(<?php echo $user['fundo'];?>) fixed;
				background-size: 100%;
				margin: 0 auto;
				text-align: center;
				font-family: 'Oxygen', sans-serif;
			}
			audio{
				width: 50%;
				margin-top: 20px;
				border-radius: 20px;
			}
		</style>
	</head>
	<body>
		<div class="cabecalho"/>
			<h1 class="logo">SINEP</h1>
			<div class="infologo">
				<h1>PERFIL DO USUÁRIO</h1>
				<img id="img" class="menua" src="./img/menub.png" alt="menu"/>
			</div>
		</div>
		<div class="perfil">			
			<img class="imgPer" src="<?php echo $user['perfil'];?>"/>
			<div class="info">
				<div class="caixa">
					<p class="nome"><?php echo $user['nome'] . " " . $user['sobrenome'] . "<br/> (" . $user['username'].")";?></p>
					<hr/>
					<p class="idade"><span>Idade:</span><?php echo " ". $user['idade']; ?></p>
					<hr/>
					<p class="sexo"><span>Sexo:</span><?php echo " ". $user['sexo']; ?></p>
					<hr/>
					<p class="email"><span>Email:</span><?php echo " ". $user['email']; ?></p>
				</div>
				<form method="POST" action="#">
					<input class="botao" type="submit" value="Sair"/>
				</form>
				<audio controls="controls" autoplay="true">
					 <source src="<?php echo $user['musica']?>" type="audio/mpeg"/>
				</audio>
			</div>
		</div>
	</body>
</html>