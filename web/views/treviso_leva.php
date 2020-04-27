<?php


function getFirstsParamsTreviso() {

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://ricerchegenealogiche.archiviodistatotreviso.beniculturali.it/Ruoli/RuoliMatricolari.aspx",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	));

	$response = curl_exec($curl);
	curl_close($curl);
	
	$doc = new simple_html_dom();
	
	// get DOM from URL or file
	$html = $doc->load($response);
	$form = $html->find('#form1', 0);
	$inputs = $form->find('input[@type=hidden]');

	//print_r($inputs);
	$array = array();

	foreach($inputs as $e) {	
		$array[$e->name] = $e->value;
	}

	return $array;
}

function getPaginationTreviso($page) {
	
	$doc = new simple_html_dom();

	// get DOM from URL or file
	$html = $doc->load($page);
	
	$table = $html->find('#GridView1', 0);
	//linha com paginação da tabela
	$links = $table->find('tr', -1)->find('a');
	
	$final = 1;
	
	if (!empty($links)) {

		$regrex = '/\$(\d+)\'/';

		$response = array();

		foreach($links as $link) {

			preg_match($regrex, $link->href, $resultados);
			
			if (!empty ($resultados[1])) {
				$response[] = $resultados[1];
				$final = max($response);
			}
		}
	}

	return $final;
	
}


function doSearchTreviso($array, $cognome, $nome, $button, $page) {
	

	if (!empty($page)) {
		$array['__EVENTTARGET'] =  'GridView1';
		$array['__EVENTARGUMENT'] =  'Page$'. $page;
	}
	
	$array['TextBox1'] =  $cognome;
	$array['TextBox2'] =  $nome;
	if ($button == true) { $array['Button1'] =  'Cerca / Find'; }

	//print_r($array);

	$curl = curl_init();		
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://ricerchegenealogiche.archiviodistatotreviso.beniculturali.it/Ruoli/RuoliMatricolari.aspx",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $array,
	));

	$response = curl_exec($curl);

	curl_close($curl);

	return 	$response;
}



function getOtherParamsTreviso($page) {
	
	$doc = new simple_html_dom();
	
	$html = $doc->load($page);

	$form = $html->find('#form1', 0);

	$inputs = $form->find('input[@type=hidden]');

	$array = array();
	
	foreach($inputs as $input) {	
		$array[$input->name] = $input->value;
	}
	
	return $array;
	
}

/*
function uppercaseText($text) {
	
	$text = strtoupper($text);
	
return $text;
}
*/

function buildTableResultTreviso($page) {
	
	$doc = new simple_html_dom();
	
	// get DOM from URL or file
	$html = $doc->load($page);

	//pega a tabela inteira
	$table = $html->find('#GridView1', 0);

	$rowData = array();
	
	foreach($table->find('tr') as $row) {
		
		//echo 'controle'. count($row->find('td'));
		$controle = count($row->find('td'));
		
		if ($controle == 12) {
			
			
			//tratar data de nascimento
			$dia = $row->find('td', 8)->plaintext;
			$mes = $row->find('td', 7)->plaintext;
			$ano = $row->find('td', 6)->plaintext;
			
			if ($dia == '' and $mes == '') {
				$data_nascimento = $ano;
			} else {
				$data_nascimento = $dia.'/'.$mes.'/'.$ano;
			}
			
		
			for($i=0; $i<=11; $i++){
				
				$row->find('td', $i)->plaintext = strtoupper($row->find('td', $i)->plaintext);
						
				if (empty(uppercaseText($row->find('td', $i)->plaintext))) {
					$row->find('td', $i)->plaintext = '';
				}
				
			}
			
			
			$titles = array(
			//"matricola_id" => $row->find('td', 0)->plaintext,
			"nome_completo" => $row->find('td', 1)->plaintext.' '.$row->find('td', 2)->plaintext,
			//"nome" => $row->find('td', 2)->plaintext,
			"nome_pai" => $row->find('td', 1)->plaintext.' '.$row->find('td', 3)->plaintext,
			//"sobrenome_mae" => $row->find('td', 4)->plaintext,
			"nome_mae" => $row->find('td', 4)->plaintext.' '.$row->find('td', 5)->plaintext,
			"data_nascimento" => $data_nascimento,
			//"data_nascimento" => $row->find('td', 8)->plaintext.'/'.$row->find('td', 7)->plaintext.'/'.$row->find('td', 6)->plaintext,
			//"ano_nascimento" => $row->find('td', 6)->plaintext,
			//"mes_nascimento" => $row->find('td', 7)->plaintext,
			//"dia_nascimento" => $row->find('td', 8)->plaintext,
			"comune_nascimento" => $row->find('td', 9)->plaintext,
			"provincia" => $row->find('td', 10)->plaintext,
			//"unidade_arquivista" => $row->find('td', 11)->plaintext,
			);
		
			$rowData[] = $titles;
		
		}
	}

	//pega o tamanho do array
	$array_lenght = count($rowData);
	//remove os 3 ultimos itens do array da tabela
	//unset($rowData[$array_lenght - 1], $rowData[$array_lenght - 2], $rowData[$array_lenght - 3]);
	
	array_pop($rowData);

	return $rowData;	
}






function finalResultTreviso($cognome_param, $nome_param) {
	
	$first_params = getFirstsParamsTreviso();
	
	$get_first_page = doSearchTreviso($first_params, $cognome_param, $nome_param, true, '');
	
	$pages = getPaginationTreviso($get_first_page); //11
	
	$other_params = getOtherParamsTreviso($get_first_page);
	
	//echo 'Aqui -> '. $pages;
	
	$count = 1;

	$response = array();
	
	$response = buildTableResultTreviso($get_first_page);


	while ($count != $pages):
	
		$count++;
	
		//echo 'Entrou - ' .$count. '=?' .$pages.'<br>'; 
		
		$get_pages = doSearchTreviso($other_params, $cognome_param, $nome_param, false, $count);
		
		$pages2 = getPaginationTreviso($get_pages); //11
		
		$table_result = buildTableResultTreviso($get_pages);

		$response = array_merge($response, $table_result);
		
		
		
	endwhile;
	
	$final_result = array();
	
	
	
	if(!empty($response)) {
		
		//$final_result['treviso']['status'] = true;
		$final_result['treviso']['msg'] = 'OK!';
		$final_result['treviso']['dados'] = $response;
		
	} else {
		
		//$final_result['treviso']['status'] = false;
		$final_result['treviso']['msg'] = 'Nenhum Registro Encontrado!';
		$final_result['treviso']['dados'] = null;

		
	}
	
	$final_result['treviso']['total_registro'] = count($response);
	

	return $final_result;

}