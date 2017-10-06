<?php
	$cor = "red";
	$aviso="none";
	$aviso2="";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$nome= $_POST['nome'];
		$sobre= $_POST['sobrenome'];
		if(isset($_POST['sexo'])){
			$sexo= $_POST['sexo'];
		}
		$email= $_POST['email'];
		$user= $_POST['userName'];
		$senha= $_POST['senha'];
		$conf= $_POST['confir'];
		$ftPer= $_FILES['ftPer'];
		$ftFun= $_FILES['ftFun'];
		$music= $_FILES['music'];
		if($senha == $conf && $nome != "" && $sobre != "" && isset($_POST['sexo']) && $email !="" && $user != "" && $senha != "" && isset($_FILES['ftPer']) && isset($_FILES['ftFun']) && isset($_FILES['music'])){

			if($ftPer['type']=="image/jpeg" && $ftFun['type']=="image/jpeg" && $music['type'] = "audio/mp3"){

				if(!file_exists('dados/'.$user)){
					mkdir('dados/'.$user);

					$caminho= getcwd()."/dados/".$user;

					move_uploaded_file($ftPer['tmp_name'], $caminho."/portrait.jpeg");
					move_uploaded_file($ftFun['tmp_name'], $caminho."/background.jpeg");
					move_uploaded_file($music['tmp_name'], $caminho."/music.mp3");

					$aviso2 = "Cadastro efetuado! <3";
					$aviso = "block";
					$cor = "pink"; 
				}
				else{
					$aviso2 = "Usuário existente, foto de perfil e fundo mudadas! ;)";
					$cor="pink";
					$aviso= "block";
					$caminho= getcwd()."/dados/".$user;
					
					move_uploaded_file($ftPer['tmp_name'], $caminho."/portrait.jpeg");
					move_uploaded_file($ftFun['tmp_name'], $caminho."/background.jpeg");
					move_uploaded_file($music['tmp_name'], $caminho."/music.mp3");
				}
			}
			else{
				$aviso2 = "Uma das imagens não é JPEG, ou a música não é mp3!;)";
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
				<input class="Male" name="sexo" type="radio" value="M">Masculino
				<input class="Female" name="sexo" type="radio" value="F"/>Feminino
				<input class="Outro" name="sexo" type="radio" value="O">Outro
				<input class="email" name="email" type="email" placeholder="Digite seu e-mail">
				<input class="userName" name="userName" type="text" placeholder="Digite seu username"/>
				<input class="password" name="senha" type="password" placeholder="Digite sua senha"/>
				<input class="confPassword" name="confir" type="password" placeholder="Confirme sua senha"/>
				<label for="ftPer">Perfil: </label>
				<input type="file" class="foto" name="ftPer"/>
				<label for="ftPer">Fundo: </label>
				<input type="file" class="foto" name="ftFun"/>
				<label for="ftPer">Sua música: </label>
				<input type="file" class="foto" name="music"/>
				<h3 style="color: <?php echo $cor; ?> ; display: <?php echo $aviso; ?>;"><?php echo $aviso2; ?></h3>
				<input class="send" type="submit" value="CADASTRAR">
				<button class="send"><a href="index.php">Voltar</a></button>
			</form>
		</div>
	</body>
</html>