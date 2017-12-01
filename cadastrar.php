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
		$idade = $_POST['idade'];
		$email= $_POST['email'];
		$user= $_POST['userName'];
		$ftPer= $_FILES['ftPer'];
		$ftFun= $_FILES['ftFun'];

		$senha = hash("sha512", $_POST['senha']);

		if($senha == hash("sha512", $_POST['confir']) && $nome != "" && $idade != 0 && $sobre != "" && isset($_POST['sexo']) && $email !="" && $user != "" && hash("sha512", $_POST['senha']) != hash("sha512","") && isset($_FILES['ftPer']) && isset($_FILES['ftFun']) && substr_count($user, " ")==0){

			if($ftPer['type']=="image/jpeg" && $ftFun['type']=="image/jpeg" && $idade >= 12){

				if(!file_exists('dados/'.$user)){

					$conexao = mysqli_connect("localhost", "root", "","redeSocial");

					if (mysqli_connect_errno()){
						header("Location: cadastrar.php");
						exit();
					}

					$user = mysqli_real_escape_string($conexao, $user);

					$contagem = mysqli_query($conexao, 'SELECT * FROM usuarios');
					$id = mysqli_num_rows($contagem);

					$solicitacao="INSERT INTO usuarios VALUES ($id,'$nome','$sobre','$sexo',$idade,'$email','$user','$senha');";

					if (mysqli_query($conexao,$solicitacao)===TRUE){

						mkdir('dados/'.$user);

						$caminho= getcwd()."/dados/".$user;

						move_uploaded_file($ftPer['tmp_name'], $caminho."/portrait.jpeg");
						move_uploaded_file($ftFun['tmp_name'], $caminho."/background.jpeg");

						$aviso2 = "Cadastro efetuado! <3";
						$aviso = "block";
						$cor = "pink";

					} else {
						$aviso2 = "Campos não preenchidos ou errados! :(";
						$aviso= "block";
					}

					mysqli_close($conexao);

				}
				else{
					$aviso2 = "Usuário existente, foto de perfil e fundo mudadas! ;)";
					$cor="pink";
					$aviso= "block";
					$caminho= getcwd()."/dados/".$user;
					
					move_uploaded_file($ftPer['tmp_name'], $caminho."/portrait.jpeg");
					move_uploaded_file($ftFun['tmp_name'], $caminho."/background.jpeg");
				}
			}
			else{
				$aviso2 = "Uma das imagens não é JPEG ou idade menor que 12!;)";
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
			<form class="form" enctype="multipart/form-data" action="#" method="POST"/>
				<input class="firstName" name="nome" type="text" placeholder="Digite seu nome"/>
				<input class="lastName" name="sobrenome" type="text" placeholder="Digite seu sobrenome"/>
				<input class="Male" name="sexo" type="radio" value="Masculino"/>Masculino
				<input class="Female" name="sexo" type="radio" value="Feminino"/>Feminino
				<input class="Outro" name="sexo" type="radio" value="Outro"/>Outro
				<input class="email" name="email" type="email" placeholder="Digite seu e-mail"/>
				<input class="idade" name="idade" type="number" placeholder="Digite a sua idade (+12)"/>
				<input class="userName" name="userName" type="text" placeholder="Digite seu username"/>
				<input class="password" name="senha" type="password" placeholder="Digite sua senha"/>
				<input class="confPassword" name="confir" type="password" placeholder="Confirme sua senha"/>
				<label for="ftPer">Perfil: </label>
				<input type="file" class="foto" name="ftPer"/>
				<label for="ftPer">Fundo: </label>
				<input type="file" class="foto" name="ftFun"/>
				<h3 style="color: <?php echo $cor; ?> ; display: <?php echo $aviso; ?>;"><?php echo $aviso2; ?></h3>
				<input class="send" type="submit" value="CADASTRAR">
				<button class="send"><a href="index.php">VOLTAR</a></button>
			</form>
		</div>
	</body>
</html>