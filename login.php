<?php
	session_start();
	
	if(isset($_SESSION['usuario'])){
		header('Location:home.php');
	}
	else{

		require_once 'funcoes.php';

		$aviso1="";
		$aviso2="";
		$aviso3="none";

		if($_SERVER["REQUEST_METHOD"]=="POST"){

			$usu=$_POST['user'];

			if( hash('sha512', $_POST['senha']) == hash('sha512', "") || $usu == ""){

				$aviso1="Usuário não especificado";
				$aviso2="Senha não especificada";

			}
			else{

				$conexao = mysqli_connect("localhost", "root", "","redeSocial");

				if (mysqli_connect_errno()) {
					header("Location: login.php");
					exit();
				}

				$confirmacaoU ="SELECT * FROM usuarios WHERE usuario = '$usu'";

				$existe = FALSE;

				if ($resposta = mysqli_query($conexao,$confirmacaoU)){

					foreach ($resposta as $dado){

						if(hash('sha512', $_POST['senha']) == $dado['senha']){

							$user=[];

							$user['id'] = $dado['id'];
							$user['nome'] =$dado['nome'];
							$user['sobrenome'] = $dado['sobrenome'];
							$user['sexo'] = $dado['sexo'];
							$user['idade'] = $dado['idade'];
							$user['email'] = $dado['email'];
							$user['username'] = $usu;
							$user['perfil'] = "./dados/".$usu."/portrait.jpeg";
							$user['fundo'] = "./dados/".$usu."/background.jpeg";

							logar($user);

							header('Location:home.php');
							$existe = TRUE;

						}
					}

					if( $existe == FALSE){
						$aviso2="Senha errada";
					}

					mysqli_free_result($resposta);

				}
				else{
					$aviso3="block";
				}
				mysqli_close($conexao);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
	</head>
	<body>
		<div class="login">
			<div class="bemvindo">
				<h1>LOGIN|SINEP</h1>
			</div>
			<form method="POST" action="#" method="POST">
				<label for="user">Usuário</label>
				<input type="text" name="user" placeholder="<?php echo $aviso1; ?>"/>
				<label for="senha">Senha</label>
				<input type="password" name="senha" placeholder="<?php echo $aviso2; ?>" />
				<h3 style=" color: red; display:<?php echo $aviso3;?>;">Usuário não existente<h3>
				<input id="enviar" type="submit" value="ENTRAR">
			</form>
				<button id="enviar"><a href="index.php">VOLTAR</a></button>
		</div>
	</body>
</html>