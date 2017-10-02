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
			$senha=$_POST['senha'];

			if( $senha == "" || $usu == ""){
				$aviso1="Usuário não especificado";
				$aviso2="Senha não especificada";
			}
			else{
				if($senha == 'root' && $usu == 'root'){
					echo "socorro";

					$user=[];

					$user['id'] = 1;
					$user['nome'] ="Root";
					$user['sobrenome'] = "Pavani Netto";
					$user['sexo'] = "F";
					$user['idade'] = "16";
					$user['email'] = "RootdaMilenaedoJoao@rootmail.com";
					$user['username'] = "root";
					$user['senha'] = hash("SHA512", $senha);
					$user['perfil'] = "./dados/root/portrait.jpg";
					$user['fundo'] = "./dados/root/background.jpg"; 

					logar($user);

					header('Location:home.php');
				}
				else{
					$aviso3="block";
				}
			}
		}
		else{
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
		</div>
	</body>
</html>