<?php


function finalResultUdine($sobrenome, $nome) {


$curl = curl_init();



curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://www.friulinprin.beniculturali.it/ita/WebAsud/template/RicercaPersona.asp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'Cognome='.urlencode($sobrenome).'&trCognome=I&Nome=&trNome=C&Luogo=&trLuogo=I&Anno=&trAnno=1&Sesso=T&Ricerca=P&TipoRicerca=N&submit=CERCA&Lingua=I',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
  ),
));

$response = curl_exec($curl);

$doc = new simple_html_dom();
	
$html = $doc->load($response);

$spans = $html->find('span.TITOLO2');

	$rowData = array();

	foreach($spans as $span) {
		
		$full_name = preg_replace('/\s+/', ' ', $span->find('a.TITOLO2', 0)->plaintext);
		$others_infos = preg_replace('/\s+/', ' ', $span->find('span.testobase', 0)->plaintext);
		
		$re_date = "/nat.\s\w+\s(\d{4}|\d+\/\d+\/\d+)/";
		$re_comune = "/\sa\s(.*?)(?:$|\sda)/";
		$re_father = "/da\s(.*?)($|e)/";
		$re_mother = "/e\s(.*)/";
		
		preg_match($re_date, $others_infos, $date);
		preg_match($re_comune, $others_infos, $comune);
		preg_match($re_father, $others_infos, $father);
		preg_match($re_mother, $others_infos, $mother);
		
		//echo "<pre>";
		//echo $others_infos."\n";
		
		$full_name = $full_name ?? '-';
		$date = $date[1] ?? '-';
		$comune = $comune[1] ?? '-';
		if (isset($father[1])) { $father = $father[1].' '.uppercaseText($sobrenome); } else { $father = '-'; }
		//$father = $father[1] ?? '-';
		$mother = $mother[1] ?? '-';
		
		/*
		echo $full_name."\n";
		echo $date."\n";
		echo $comune."\n";
		echo $father."\n";
		echo $mother."\n\n";
		*/
		
		$flight = array(
		"nome_completo" => $full_name,
		"nome_pai" => $father,
		"nome_mae" => $mother,
		"data_nascimento" => $date,
		"comune_nascimento" => $comune,
		"provincia" => 'UDINE',
		);
		
		$rowData[] = $flight;	

	}


	$final_result = array();
	
	
	if(!empty($rowData)) {
		
		//$final_result['treviso']['status'] = true;
		$final_result['udine']['msg'] = 'OK!';
		$final_result['udine']['dados'] = $rowData;
		
	} else {
		
		//$final_result['treviso']['status'] = false;
		$final_result['udine']['msg'] = 'Nenhum Registro Encontrado!';
		$final_result['udine']['dados'] = null;

		
	}
	
	$final_result['udine']['total_registro'] = count($rowData);
	
	
	return $final_result;

}
/*

$teste = finalResultUdine('del bel','');


	$post_data = json_encode($teste);
	


	echo $post_data;
*/	

//echo "<pre>";
//var_dump($final_result);

/*
//Funcionando
curl_close($curl);
//echo $response;

$re = "/ID=\d+'>(\w+)\s+(\w+)\s.+?<\/A><\/SPAN><SPAN\s.+?>(.*?)</m";

preg_match_all($re, $response, $matches, PREG_SET_ORDER, 0);

// Print the entire match result
echo "<pre>";
//var_dump($matches);

foreach($matches as $match) {
	echo $match[1].' '.$match[2];
	echo "<br>";
	$re_date = "/\snat.\s\w+\s(\d{4}|\d+\/\d+\/\d+)/";
	$re_comune = "/[\d|\*]\s\w+\s(.*?)(?:$|\s{2})/";
	$re_parents = "/da\s(.*?)e\s(.*?)\s{2}(.*)/";
	
	preg_match($re_date, $match[3], $date);
	preg_match($re_comune, $match[3], $comune);
	preg_match($re_parents, $match[3], $parents);
	
	//var_dump($date);
	echo $date[1];
	echo "<br>";
	if (isset($comune[1])) { echo $comune[1]; }
	echo "<br>";
	if (isset($parents[1])) { echo $parents[1]; }
	echo "<br>";
	if (isset($parents[2])) { echo $parents[2].' '.preg_replace('/\s{2}+/', '', $parents[3]); }
	echo "<br>";
	echo "<br>";
}
*/