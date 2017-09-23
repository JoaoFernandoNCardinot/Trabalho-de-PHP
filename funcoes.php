<?php
	function logar($usuario){
			$_SESSION['usuario'] = $usuario;
	}
	function deslogar(){
		unset($_SESSION['usuario']); //elimina a sessão
	}
	function obterUsurLogado(){
		if(isset($_SESSION['usuario']))
			return $_SESSION['usuario'];
		else
			return false;
	}
	function finalizarSessao(){
		session_detroy();
	}
?>