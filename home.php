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
		<style>
			body{
				background: url(<?php echo $user['fundo']; ?>) no-repeat fixed;
				background-size: 100%;
				margin: 0 auto;
				text-align: center
			}
			img{
				border-radius: 50%;
				border: solid 5px #FFF;
				margin: 0 auto;
				width: 200px;
			}
			.info{
				background-color: white;
			}
		</style>
	</head>
	<body>
		<img src="<?php echo $user['perfil'];?>"/>
		<div class="info">
			<p class="nome"><?php echo $user['nome'] . " " . $user['sobrenome'];?></p>
			<p class="idade"><?php echo $user['idade']; ?></p>
			<p class="sexo"><?php echo $user['sexo']; ?></p>
			<p class="email"><?php echo $user['email']; ?></p>
			<p class="username"></p>
			<form method="POST" action="#">
				<input type="submit" value="Sair"/>
			</form>
		</div>
	</body>
</html>