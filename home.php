<?php
	session_start();
	require_once 'funcoes.php';

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		if($_POST['enviar']=="SAIR"){

			deslogar();

			header("Location: index.php");
		}
		else{

			$user=obterUsurLogado();

			$id_amigo= $_POST['id'];

			$id_pessoa = $user['id'];

			$conexao = mysqli_connect("localhost", "root", "","redeSocial");

			$solicitacao="INSERT INTO amigos VALUES ($id_pessoa, $id_amigo)";

			if (mysqli_query($conexao,$solicitacao)===TRUE){

				mysqli_close($conexao);

				header("Location: home.php");

			} else {
				
				mysqli_close($conexao);

				header("Location: home.php");
			}
		}
	}else{

		if(isset($_SESSION['usuario']) == FALSE && isset($_GET['uid'])== FALSE){

			header('Location: erro.php');

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

				$(".cabecalho").append($("<div />").addClass("menu").append($("<ul />").append($("<li />").attr("id","amigos").text("MOSTRAR AMIGOS")).append($("<li />").append($("<form/>").attr({"method":"POST" , "action": "#"}).append($("<input/>").attr({"type": "submit" , "name" : "enviar" ,"class":"bmenu" , "value": "SAIR"}))))).hide());

				$(".cabecalho").hover(function(){
					$("#img").attr("src","./img/menub.png");
				})
				$(".cabecalho").mouseleave(function(){
					$("#img").attr("src", "./img/menuw.png");
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
				background: url(<?php 
					if(!isset($_GET['uid'])){
						echo $user['fundo'];
					}
					if(isset($_GET['uid'])){
						$idProcurado= $_GET['uid'];

						$conexao = mysqli_connect("localhost", "root", "","redeSocial");

						$requisicao = "SELECT * FROM usuarios WHERE id = $idProcurado";

							if($resposta=mysqli_query($conexao,$requisicao)){
								foreach ($resposta as $dado) {
									$nomeProcurado = $dado['usuario'];
								}
								$fotoFund = "./dados/".$nomeProcurado."/background.jpeg";

								echo $fotoFund;
							}
					}
					?>) fixed;
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
				<h1>PERFIL DO USUÁRIO| <?php echo $user['username'] ?></h1>
				<img id="img" class="menua" src="./img/menuw.png" alt="menu"/>
			</div>
		</div>
		<?php
			if(isset($_SESSION['usuario'])){

				if(isset($_GET['uid'])){
					$conexao = mysqli_connect("localhost", "root", "","redeSocial");

					if(mysqli_connect_errno()){
						header('Location: index.php');
					}

					$idprocurado = $_GET['uid'];

					$confirmacaoU = "SELECT * FROM usuarios WHERE id = $idprocurado";

					if($resposta = mysqli_query($conexao,$confirmacaoU)){
						foreach ($resposta as $dado) {
							$id= $dado['id'];
							$nome= $dado['nome'];
							$sobrenome= $dado['sobrenome'];
							$usuario = $dado['usuario'];
							$sexo= $dado['sexo'];
							$idade = $dado['idade'];
							$email = $dado['email'];
						}
					}
					else{

						header('Location: erro.php');
						die();
					}

					mysqli_free_result($resposta);

					$perfil = "./dados/".$usuario."/portrait.jpeg";

		?>
		<div class="perfil">		
			<img class="imgPer" src="<?php echo $perfil;?>"/>
			<div class="info">
				<div class="caixa">
					<p class="nome"><?php echo $nome . " " . $sobrenome . "<br/> (" . $usuario.")";?></p>
					<hr/>
					<form method="POST" action="home.php">
						<input class="id" type="number" name="id" value="<?php echo $id; ?>"/>
						<input type="submit" name="enviar" value = "ADICIONAR AOS AMIGOS" class="amigo"/>
					</form>
					<hr/>
					<p class="idade"><span>Idade:</span><?php echo " ". $idade; ?></p>
					<hr/>
					<p class="sexo"><span>Sexo:</span><?php echo " ". $sexo; ?></p>
					<hr/>
					<p class="email"><span>Email:</span><?php echo " ". $email; ?></p>
					<hr/>
					<div class="div-amigos">
					<h1 class="amizades">AMIGOS</h1>
						<?php

							$mostrarAmigos ="SELECT * FROM amigos WHERE id_pessoa = $idprocurado";

							$contagem = mysqli_query($conexao, $mostrarAmigos);
							$numAmigos = mysqli_num_rows($contagem);

							if ($numAmigos == 0) {
								?>
								<h4>SEM AMIGOS :(</h4>
								<?php
							}

							if($resposta = mysqli_query($conexao,$mostrarAmigos)){
						?>
						<table>
						<?php
								foreach ($resposta as $dado){

									$id= $dado['id_amigo'];

									$confirmacaoU ="SELECT * FROM usuarios WHERE id = $id ";

									if($resposta = mysqli_query($conexao,$confirmacaoU)){

										foreach ($resposta as $dado){
											$nomeA = $dado['nome'];
											$sobreA = $dado['sobrenome'];
											$userA = $dado['usuario'];
											$perfilA = "./dados/".$userA."/portrait.jpeg";
										}
										?>
											<tr>
												<td><img src="<?php echo $perfilA;?>"/></td>
												<td><?php echo $nomeA ." ". $sobreA ." (" . $userA . ")";  ?></td>
											</tr>
											<?php
									}
								}
							?>
							</table>
							<?php
							}

							mysqli_free_result($resposta);

						?>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
			if(!isset($_GET['uid'])){
		?>
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
					<hr/>
					<div class="div-amigos">
					<h1 class="amizades">AMIGOS</h1>
						<?php

							$conexao = mysqli_connect("localhost", "root", "","redeSocial");

							$usid= $user['id'];
							$mostrarAmigos ="SELECT * FROM amigos WHERE id_pessoa = $usid ";

							$contagem = mysqli_query($conexao, $mostrarAmigos);
							$numAmigos = mysqli_num_rows($contagem);

							if ($numAmigos == 0) {
								?>
								<h4>SEM AMIGOS :(</h4>
								<?php
							}

							if($resposta = mysqli_query($conexao,$mostrarAmigos)){
						?>
						<table>
						<?php
								foreach ($resposta as $dado){

									$id= $dado['id_amigo'];

									$confirmacaoU ="SELECT * FROM usuarios WHERE id = $id ";

									if($resposta = mysqli_query($conexao,$confirmacaoU)){

										foreach ($resposta as $dado){
											$nomeA = $dado['nome'];
											$sobreA = $dado['sobrenome'];
											$userA = $dado['usuario'];
											$perfilA = "./dados/".$userA."/portrait.jpeg";
										}
										?>
											<tr>
												<td><img src="<?php echo $perfilA; ?>"/></td>
												<td><?php echo $nomeA ." ". $sobreA ." (" . $userA . ")";  ?></td>
											</tr>
											<?php
									}
								}
							?>
							</table>
							<?php
							}

							mysqli_free_result($resposta);

						?>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		}
		if(!isset($_SESSION['usuario'])){

				if (isset($_GET['uid'])){

					$conexao = mysqli_connect("localhost", "root", "","redeSocial");

					if(mysqli_connect_errno()){
						header('Location: index.php');
					}

					$idprocurado= $_GET['uid'];

					$confirmacaoU ="SELECT * FROM usuarios WHERE id = $idprocurado";

					if($resposta = mysqli_query($conexao,$confirmacaoU)){

							foreach ($resposta as $dado){

								$id= $dado['id'];
								$nome= $dado['nome'];
								$sobrenome= $dado['sobrenome'];
								$usuario = $dado['usuario'];
								$sexo= $dado['sexo'];
								$idade = $dado['idade'];
								$email = $dado['email'];
							}
							$perfil = "./dados/".$usuario."/portrait.jpeg";
					}
					else{
						header("Location: erro.php");
					}

					mysqli_free_result($resposta);
				
		?>
		<div class="perfil">		
			<img class="imgPer" src="<?php echo $perfil;?>"/>
			<div class="info">
				<div class="caixa">
					<p class="nome"><?php echo $nome . " " . $sobrenome . "<br/> (" . $usuario.")";?></p>
					<hr/>
					<p class="idade"><span>Idade:</span><?php echo " ". $idade; ?></p>
					<hr/>
					<p class="sexo"><span>Sexo:</span><?php echo " ". $sexo; ?></p>
					<hr/>
					<p class="email"><span>Email:</span><?php echo " ". $email; ?></p>
				</div>
			</div>
		</div>
		<?php
			}
		}
		?>
	</body>
</html>