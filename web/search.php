<?php
header('Content-Type: application/json');

include('utils/simple_html_dom.php');
include('padova_e_rovigo.php');
include('treviso_leva.php');
include('treviso_renitenti.php');
include('venezia.php');
include('vicenza_leva.php');
include('vicenza_ruolli99.php');



//verifica se o submit do form não é vazio para a variável search
if(!empty($_REQUEST['search'])) {
	
	//atribui à variável o valor da consulta do form
	$sobrenome = $_REQUEST['search'];


	//$sobrenome = 'CANALI';
	$nome = '';


	$final_result_treviso = array();
	//$final_result_treviso = finalResultTreviso($sobrenome, $nome);

	$final_result_treviso2 = array();
	//$final_result_treviso2 = finalResultTreviso2($sobrenome, $nome);

	$final_result_padova = array();
	$final_result_padova = finalResult($sobrenome, $nome);
	
	$final_result_venezia = array();
	$final_result_venezia = finalResultVenezia($sobrenome, $nome);	
	
	$final_result_vicenza = array();
	$final_result_vicenza = finalResultVicenza($sobrenome, $nome);	

	$final_result_vicenza2 = array();
	$final_result_vicenza2 = finalResultVicenza2($sobrenome, $nome);	


	$total = array_merge($final_result_treviso, $final_result_treviso2, $final_result_padova, $final_result_venezia, $final_result_vicenza, $final_result_vicenza2);



	$post_data = json_encode($total);
	


	echo $post_data;
}

?>