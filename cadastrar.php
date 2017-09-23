<?php
	$cor = "red";
	$aviso="none";
	$aviso2="";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$nome= $_POST['nome'];
		$sobre= $_POST['sobrenome'];
		$sexo= $_POST['sexo'];
		$email= $_POST['email'];
		$user= $_POST['userName'];
		$senha= $_POST['senha'];
		$conf= $_POST['confir'];
		$ftPer= $_FILES['ftPer'];
		$ftFun= $_FILES['ftFun'];

		if($senha == $conf && $nome != "" && $sobre != "" && $sexo != "" && $email !="" && $user != "" && $senha != "" && isset($_FILES['ftPer']) && isset($_FILES['ftFun'])){

			if(!file_exists('dados/'.$user)){
				mkdir('dados/'.$user);

				$caminho= "dados/".$user;

				move_uploaded_file($ftPer['tmp_name'], $caminho);
				move_uploaded_file($ftFun['tmp_name'], $caminho);

				$aviso2 = "Cadastro efetuado! <3";
				$aviso = "block";
				$cor = "pink"; 
			}
			else{
				$aviso2 = "usuário ja existe, desculpe! ;)";
				$aviso= "block";
			}
		}
		else{
			$aviso2 = "Campos não preenchidos ou errados! :(";
			$aviso= "block";
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cadastro</title>
		<link rel="stylesheet" type="text/css" href="./css/cadastrar.css">
		<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
	</head>
	<body>
		<div class="cadastro">
			<h1 class="titulo">CADASTRO|SINEP</h1>
			<form class="form" enctype="multipart/form-data" action="#" method="POST">
				<input class="firstName" name="nome" type="text" placeholder="Digite seu nome">
				<input class="lastName" name="sobrenome" type="text" placeholder="Digite seu sobrenome">
				<input class="Male" name="sexo" type="radio" name="sexo" value="M">Male
				<input class="Female" name="sexo" type="radio" name="sexo" value="F"/>Female
				<input class="email" name="email" type="email" placeholder="Digite seu e-mail">
				<input class="userName" name="userName" type="text" placeholder="Digite seu username"/>
				<input class="password" name="senha" type="password" placeholder="Digite sua senha"/>
				<input class="confPassword" name="confir" type="password" placeholder="Confirme sua senha"/>
				<input type="file" class="foto" name="ftPer"/>
				<input type="file" class="foto" name="ftFun"/>
				<h3 style="color: <?php echo $cor; ?> ; display: <?php echo $aviso; ?>;"><?php echo $aviso2; ?></h3>
				<input class="send" type="submit" value="CADASTRAR">
			</form>
		</div>
	</body>
</html>