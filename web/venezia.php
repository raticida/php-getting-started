<?php
header('Content-Type: application/json');

//include simple_html_dom.php
include('utils/simple_html_dom.php');


function firtsParams() {
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://www.archiviodistatovenezia.it/leva/search.php?SR=1',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookies2.txt',
	));
	

	$response = curl_exec($curl);
	curl_close($curl);

	$doc = new simple_html_dom();
	
	// get DOM from URL or file
	$html = $doc->load($response);
	$form = $html->find('form', 0);
	$inputs_hidden = $form->find('input[@type=hidden]');
	
	$inputs = $form->find('input');

	//print_r($inputs);
	$array = array();
	
	foreach($inputs as $input) {	
		$array[$input->name] = $input->value;
	}
	
	
	foreach($inputs_hidden as $input_hidden) {	
		$array[$input_hidden->name] = $input_hidden->value;
	}
	

	return $array;
}


function getPaginationParams($page) {
	
	$doc = new simple_html_dom();

	$html = $doc->load($page);
	
	$pagination_params = array();

	$subgroups = $html->find('select[name=subgroup]',0);
	
	$subgroup_array = array();
	
	if (!empty($subgroups)) {
		
		foreach($subgroups->find('option') as $option) {
			$subgroup_array[] = $option->value;
		}

		$pagination_params[$html->find('input[name=group]', 0)->name] = $html->find('input[name=group]', 0)->value;
		$pagination_params[$html->find('input[name=L]', 0)->name] = $html->find('input[name=L]', 0)->value;
		$pagination_params[$html->find('select[name=subgroup]',0)->name] = end($subgroup_array);
	
	}

	return $pagination_params;
}

function uppercaseText($text) {
	
	$text = strtoupper($text);
	
return $text;
}


function getDetails($url) {
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://www.archiviodistatovenezia.it/leva/'.$url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookies2.txt',
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);

	$doc = new simple_html_dom();

	$html = $doc->load($response);

	$div_content = $html->find('div#content',0)->find('div', 0);
	
	//echo $div_content;
	//echo "\n";
	
	//$re = '/">(.*?)<\/b><br\/>\s.*?:\s(.*?)<br\/>.*?<\/b>(.*?)di\sprofessione\s\w+\s+e\s(.+?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>.*?<\/b>(.*?)<br\/>/m';
	
	//echo $div_content;
	
	preg_match_all('/125\%\">(.*?)<\/b>/', $div_content, $nome_completo);
	
	preg_match_all('/figlio\sdi\s\<\/b>(.*?)\<br\/>/', $div_content, $filiacao);
	
	preg_match_all('/Nato\sil\s\<\/b\>(.*?)\</', $div_content, $data_nascimento);
	
	preg_match_all('/Luogo\sdi\snascita:\s<\/b\>(.*?)\<br\/>/', $div_content, $comune_nascimento);
	
	//print_r($nome_completo);
	//print_r($filiacao);
	//print_r($data_nascimento);
	//print_r($comune_nascimento);

	preg_match('/\se\s/m', $filiacao[1][0], $check);
	
	if (!empty($check)) {
		
		$remove_job = preg_replace('/(di\sprofessione\s.*?\se)/m', 'e', $filiacao[1][0]);
		
		//echo $remove_job;
		//echo "\n";
		
		preg_match_all('/(.*?)\se\s(.*)/m', $remove_job, $output_array);

			$nome_do_pai = $output_array[1][0];

			$nome_da_mae = $output_array[2][0];

	} else {
		$nome_do_pai = $filiacao[1][0];
		$nome_da_mae = '';
	}

	preg_match('/.*\((.*)\)/', $comune_nascimento[1][0], $provincia);
	
	
	
	if (!empty($provincia)) {
	
		$provincia = $provincia[1];
		$comune = preg_replace('/\(.*\)/', '', $comune_nascimento[1][0]);
	
	} else {
		
		$provincia = 'VENEZIA';
		$comune = $comune_nascimento[1][0];
	}	
	
		/*
	echo $nome_completo[1][0]; echo '<br>';
	echo $nome_do_pai; echo '<br>';
	echo $nome_da_mae; echo '<br>';
	echo $data_nascimento[1][0]; echo '<br>';
	echo $comune; echo '<br>';
	echo $provincia; echo '<br>';
	echo '<br>';
	

	
	$re = '/">(.*?)<\/b>(.*?)</m';

	preg_match_all($re, $div_content, $matches);
	
	//print_r($matches);
	
	$nome_dos_pais = $matches[2][1];
	
	//echo $nome_dos_pais;
	//echo "\n";
	
	preg_match('/\se\s/m', $nome_dos_pais, $check);
	
	if (!empty($check)) {
		
		$remove_job = preg_replace('/(di\sprofessione\s.*?\se)/m', 'e', $nome_dos_pais);
		
		//echo $remove_job;
		//echo "\n";
		
		preg_match_all('/(.*?)\se(\s.*)/m', $remove_job, $output_array);
		
		//print_r($output_array);
		//if(!empty($output_array[1][0])) {
			$nome_do_pai = $output_array[1][0];
		//} else {
			//$nome_do_pai = 'null';
		//}
		//if(!empty($output_array[2][0])) {
			$nome_da_mae = $output_array[2][0];
		//}else {
			//$nome_da_mae = 'null';
		//}		
			
		
	} else {
		$nome_do_pai = $nome_dos_pais;
		$nome_da_mae = 'null';
	}
	


	//print_r($nome_do_pai);
	//print_r($nome_da_mae);
	//echo "\n";
	
	preg_match('/.*\((.*)\)/', $matches[2][3], $output_array2);
	
	
	
	if (!empty($output_array2)) {
	
		$provincia = $output_array2[1];
		$comune = preg_replace('/\(.*\)/', '', $matches[2][3]);
	
	} else {
		
		$provincia = 'VENEZIA';
		$comune = $matches[2][3];
	}
	
	
	
	*/

	// Print the entire match result
	//var_dump($matches);
	
	$result = array(
	"nome_completo" => uppercaseText($nome_completo[1][0]),
	"nome_pai" => uppercaseText($nome_do_pai),
	"nome_mae" => uppercaseText($nome_da_mae),
	"data_nascimento" => uppercaseText($data_nascimento[1][0]),
	"comune_nascimento" => uppercaseText($comune),
	"provincia" => uppercaseText($provincia),
	//"comune_residencia" => $matches[2][5],
	//"numero_extracao" => $matches[2][8],
	//"numero_registro" => $matches[2][10],
	//"numero_pedido" => $matches[2][11],

	);

	//print_r($result);
	return $result;

}


function printDetails($page) {

	$doc = new simple_html_dom();

	$html = $doc->load($page);
	
	$div_content = $html->find('div#content',0)->find('div', 1);

	$details = array();
	
	foreach($div_content->find('a') as $link) {
		
		$details[] = getDetails($link->href);
		
	}

	return $details;
}




function doSearch($array, $cognomeName, $has_pagination) {

		
	if (!empty($has_pagination)) {
			
		$group = $has_pagination['group'];
		$L = $has_pagination['L'];
		$subgroup = $has_pagination['subgroup'];
		
		$url = 'http://www.archiviodistatovenezia.it/leva/searchResults.php?group='.$group.'&L='.$L.'&subgroup='.$subgroup;
		
	} else{
		
		$url = 'http://www.archiviodistatovenezia.it/leva/searchResults.php';
	}

	$array['name'] = $cognomeName;

	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookies2.txt',
		CURLOPT_POSTFIELDS => $array
	));
	

	$page = curl_exec($curl);
	
	curl_close($curl);

	//print_r (getPaginationParams($page));
	
	
	//$details = printDetails($page);
	
	//echo $div_content;
	
	//return $details;
	return $page;
}


function finalResult($nomeSobrenome) {
	
	$first = firtsParams();
	
	$first_search = doSearch($first, $nomeSobrenome, '');
	
	$details = printDetails($first_search);
	
	$has_pagination = getPaginationParams($first_search);
	
	if (!empty($has_pagination)) { 
		
		$count = 1;
		
		$num_pages = $has_pagination['subgroup'];
		
		$has_pagination['subgroup'] = $count;

		while ($count <= $num_pages): //1 diferente de 2 ?
			
			$others_searchs = doSearch($first, $nomeSobrenome, $has_pagination);
			
			$others_details = printDetails($others_searchs);
			
			$details = array_merge($details, $others_details);	
			
			$count++;
			
		endwhile;
	
	}
	
	return $details;	
}



$final_result = finalResult('zanetti');


if (empty($final_result)) {
	 
	$final_result[] = array('');
}

//print_r($final_result);

$post_data = json_encode($final_result);

//$post_data = json_encode(array('result' => $final_result));
//$post_data = json_encode(array('item' => $final_result), JSON_FORCE_OBJECT);
//$post_data = json_encode($final_result, JSON_FORCE_OBJECT);

echo $post_data;