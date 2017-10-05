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
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="./css/home.css"/>
		<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Rubik|Varela+Round" rel="stylesheet">
		<style>
			body{
				background: url(<?php echo $user['fundo']; ?>) no-repeat fixed;
				background-size: 100%;
				margin: 0 auto;
				text-align: center;
				font-family: 'Oxygen', sans-serif;
			}
		</style>
	</head>
	<body>
		<div class="cabecalho"/>
			<h1 class="logo">SINEP</h1>
			<h1 class="infologo">PERFIL DO USUÁRIO</h1>
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
			</div>
		</div>
	</body>
</html>