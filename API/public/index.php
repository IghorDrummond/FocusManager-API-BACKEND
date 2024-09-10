<?php
/*
===============================================
Fonte: index.php
Descrição: Inicializador das requisições da API
Data: 07/08/2024
Programador(a): Ighor Drummond
===============================================
*/
	//Cria headers para API
	//Retornará sempre um json	
	header('Content-Type: application/json');
	//Habilita CORS para que a API possa ser acessada em varios domínios
	header("Access-Control-Allow-Origin: *");
	//Métodos permitidos na API (GET, POST,  PUT e DELETE)
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	//Configuração da API
	header("Access-Control-Allow-Headers: Content-Type");

	require_once('../vendor/autoload.php');
	$route = new \App\Route;
?>
