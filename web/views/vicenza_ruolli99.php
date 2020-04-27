<?php

function getParamstVicenza2() {
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://www.arsas.org/ruoli99",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	));

	$response = curl_exec($curl);


	curl_close($curl);
	//echo $response;
	
	$doc = new simple_html_dom();
	
	// get DOM from URL or file
	$html = $doc->load($response);

	$form = $html->find('#joodbForm', 0);

	$inputs = $form->find('input[@type=hidden]');

	$array = array();

	foreach($inputs as $e) {
		
		$array[$e->name] = $e->value;

	}

	$array['my_name'] =  '';
	$array['searchfield'] =  'CognomeNome';
	$array['limit'] =  '0';	
	
	return $array;
}


function doSearchVicenza2($array, $cognomeNome) {

	$array['search'] =  $cognomeNome;

	$curl = curl_init();
		
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://www.arsas.org/ruoli99",
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

	return $response;

}

/*
function uppercaseText($text) {
	
	$text = strtoupper($text);
	
return $text;
}
*/


function finalResultVicenza2($cognomeNome) {
	
	$get_firsts_params = getParamstVicenza2();
	
	//print_r($get_firsts_params);
	
	$response = doSearchVicenza2($get_firsts_params, $cognomeNome);
	
	//print_r($response);
	
	$doc = new simple_html_dom();
	
	// get DOM from URL or file
	$html = $doc->load($response);

	//pega a tabela inteira
	$tables = $html->find('table');
	
	$rowData = array();
	
	foreach($html->find('table') as $table) {
	
		foreach($table->find('tr') as $row) {
			
			$flight = array();

			$limit = count($row->find('td'));
			
			
			if ($limit == 11){

				for($i=0; $i<=10; $i++){
					
					$row->find('td', $i)->plaintext = strtoupper($row->find('td', $i)->plaintext);
							
					if (empty(uppercaseText($row->find('td', $i)->plaintext))) {
						$row->find('td', $i)->plaintext = 'null';
					}
					
				}
				
				
				$titles = array(
				"nome_completo" => $row->find('td', 0)->plaintext,
				"nome_pai" => $row->find('td', 1)->plaintext,
				"nome_mae" => $row->find('td', 2)->plaintext,
				"data_nascimento" => $row->find('td', 4)->plaintext,
				"comune_nascimento" => $row->find('td', 3)->plaintext,
				"provincia" => $row->find('td', 3)->plaintext,
				//"foto" => $row->find('td', 5)->plaintext,
				//"arquivo" => $row->find('td', 6)->plaintext,
				//"profissao" => $row->find('td', 9)->plaintext,
				);


				$rowData[] = $titles;
				
			}
			
			

		}
		
		
		
		
	}


	$final_result = array();
	
	
	if(!empty($rowData)) {
		
		//$final_result['treviso']['status'] = true;
		$final_result['vicenza2']['msg'] = 'OK!';
		$final_result['vicenza2']['dados'] = $rowData;
		
	} else {
		
		//$final_result['treviso']['status'] = false;
		$final_result['vicenza2']['msg'] = 'Nenhum Registro Encontrado!';
		$final_result['vicenza2']['dados'] = null;

		
	}
	
	$final_result['vicenza2']['total_registro'] = count($rowData);
	

	return $final_result;	
	

}