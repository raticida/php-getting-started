<?php


function doLogin($code, $sent, $username, $password) {
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://archiviodistato.provincia.padova.it/leva/login.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookies.txt',
		CURLOPT_POSTFIELDS => array(
									'code' => $code,
									'sent' => $sent,
									'username' => $username,
									'password' => $password
									)
	));
	
	curl_exec($curl);
	
	curl_close($curl);

}

function doSearch($cognome, $nome, $init) {
	
	if(empty($nome)){ $nome = '   '; }
	if(empty($init)){ $init = '0'; }
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://archiviodistato.provincia.padova.it/leva/consulta.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookies.txt',
		CURLOPT_POSTFIELDS => array(
								'ricerca' => 'si',
								'cognome' => $cognome,
								'nome' => $nome,
								'madre' => '',
								'localita' => '',
								'nascita' => '',
								'giorno' => '',
								'mese' => '',
								'anno' => '',
								'ord' => 'cognome',
								'init' => $init
								)
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	return $response;
}

function provinceCheck($sigla) {
	
	$provincias = array(
	"AGRIGENTO" => 'AG',
	"ALESSANDRIA" => 'AL',
	"ANCONA" => 'AN',
	"AOSTA" => 'AO',
	"L'AQUILA" => 'AQ',
	"AREZZO" => 'AR',
	"ASCOLI-PICENO" => 'AP',
	"ASTI" => 'AT',
	"AVELLINO" => 'AV',
	"BARI" => 'BA',
	"BARLETTA-ANDRIA-TRANI" => 'BT',
	"BELLUNO" => 'BL',
	"BENEVENTO" => 'BN',
	"BERGAMO" => 'BG',
	"BIELLA" => 'BI',
	"BOLOGNA" => 'BO',
	"BOLZANO" => 'BZ',
	"BRESCIA" => 'BS',
	"BRINDISI" => 'BR',
	"CAGLIARI" => 'CA',
	"CALTANISSETTA" => 'CL',
	"CAMPOBASSO" => 'CB',
	"CARBONIA IGLESIAS" => 'CI',
	"CASERTA" => 'CE',
	"CATANIA" => 'CT',
	"CATANZARO" => 'CZ',
	"CHIETI" => 'CH',
	"COMO" => 'CO',
	"COSENZA" => 'CS',
	"CREMONA" => 'CR',
	"CROTONE" => 'KR',
	"CUNEO" => 'CN',
	"ENNA" => 'EN',
	"FERMO" => 'FM',
	"FERRARA" => 'FE',
	"FIRENZE" => 'FI',
	"FOGGIA" => 'FG',
	"FORLI-CESENA" => 'FC',
	"FROSINONE" => 'FR',
	"GENOVA" => 'GE',
	"GORIZIA" => 'GO',
	"GROSSETO" => 'GR',
	"IMPERIA" => 'IM',
	"ISERNIA" => 'IS',
	"LA-SPEZIA" => 'SP',
	"LATINA" => 'LT',
	"LECCE" => 'LE',
	"LECCO" => 'LC',
	"LIVORNO" => 'LI',
	"LODI" => 'LO',
	"LUCCA" => 'LU',
	"MACERATA" => 'MC',
	"MANTOVA" => 'MN',
	"MASSA-CARRARA" => 'MS',
	"MATERA" => 'MT',
	"MEDIO CAMPIDANO" => 'VS',
	"MESSINA" => 'ME',
	"MILANO" => 'MI',
	"MODENA" => 'MO',
	"MONZA-BRIANZA" => 'MB',
	"NAPOLI" => 'NA',
	"NOVARA" => 'NO',
	"NUORO" => 'NU',
	"OGLIASTRA" => 'OG',
	"OLBIA TEMPIO" => 'OT',
	"ORISTANO" => 'OR',
	"PADOVA" => 'PD',
	"PALERMO" => 'PA',
	"PARMA" => 'PR',
	"PAVIA" => 'PV',
	"PERUGIA" => 'PG',
	"PESARO-URBINO" => 'PU',
	"PESCARA" => 'PE',
	"PIACENZA" => 'PC',
	"PISA" => 'PI',
	"PISTOIA" => 'PT',
	"PORDENONE" => 'PN',
	"POTENZA" => 'PZ',
	"PRATO" => 'PO',
	"RAGUSA" => 'RG',
	"RAVENNA" => 'RA',
	"REGGIO-CALABRIA" => 'RC',
	"REGGIO-EMILIA" => 'RE',
	"RIETI" => 'RI',
	"RIMINI" => 'RN',
	"ROMA" => 'ROMA',
	"ROVIGO" => 'RO',
	"SALERNO" => 'SA',
	"SASSARI" => 'SS',
	"SAVONA" => 'SV',
	"SIENA" => 'SI',
	"SIRACUSA" => 'SR',
	"SONDRIO" => 'SO',
	"TARANTO" => 'TA',
	"TERAMO" => 'TE',
	"TERNI" => 'TR',
	"TORINO" => 'TO',
	"TRAPANI" => 'TP',
	"TRENTO" => 'TN',
	"TREVISO" => 'TV',
	"TRIESTE" => 'TS',
	"UDINE" => 'UD',
	"VARESE" => 'VA',
	"VENEZIA" => 'VE',
	"VERBANIA" => 'VB',
	"VERCELLI" => 'VC',
	"VERONA" => 'VR',
	"VIBO-VALENTIA" => 'VV',
	"VICENZA" => 'VI',
	"VITERBO" => 'VT'
	);

	$result = array_search($sigla, $provincias);
		
	return $result;
}



function uppercaseText($text) {
	
	$text = strtoupper($text);
	
return $text;
}

function buildTableResult($tables) {
	
	$doc = new simple_html_dom();
	$html = $doc->load($tables);
	$table = $html->find('#leva_risultati', 1);
	
	//pega a primeira linha da tabela (onde contém os títulos das colunas)
	$th = $table->find('tr',0);
	
	$th_array = array();
	foreach($th->find('td') as $th_item) {
		$th_array[] = $th_item->plaintext;
	}
	
	
	//monta o array com a tabela toda
	$table_array = array();
	foreach($table->find('tr') as $row) {
		
	

		$row->find('td', 5)->plaintext = provinceCheck($row->find('td', 5)->plaintext);

		
		for($i=0; $i<=10; $i++){
			
			$row->find('td', $i)->plaintext = strtoupper($row->find('td', $i)->plaintext);
					
			if (empty(uppercaseText($row->find('td', $i)->plaintext))) { 
				$row->find('td', $i)->plaintext = '';
			}
			
		}		
		

		$titles = array(
		"nome_completo" => $row->find('td', 0)->plaintext.' '.$row->find('td', 1)->plaintext,
		//"nome" => $row->find('td', 1)->plaintext,
		//"numero_lista" => $row->find('td', 2)->plaintext,
		"nome_pai" => $row->find('td', 9)->plaintext,
		"nome_mae" => $row->find('td', 10)->plaintext,
		"data_nascimento" => $row->find('td', 3)->plaintext,
		"comune_nascimento" => $row->find('td', 4)->plaintext,
		"provincia" => $row->find('td', 5)->plaintext,
		//"ano" => $row->find('td', 6)->plaintext,
		//"comune_inscricao" => $row->find('td', 7)->plaintext,
		//"comune_mandamento" => $row->find('td', 8)->plaintext,
		//"nome_pai" => $row->find('td', 9)->plaintext,
		
		);
	
		$table_array[] = $titles;
	}
	
	//remove a primeira linha (os titulos da tabela) da tabela completa
	array_shift($table_array);

	
		
	return $table_array;
	
}

/*
function checkPagination($cognome, $nome) {
	
	$doc = new simple_html_dom();
	$response = doSearch($cognome, $nome, '0');
	$table = $doc->load($response)->find('#leva_risultati', 0);
	$number_of_pages = $table->find('b');
	$result = substr($number_of_pages[0]->innertext, -1);
	
	return $result;
}
*/

function checkPagination($page) {
	
	$doc = new simple_html_dom();
	$table = $doc->load($page)->find('#leva_risultati', 0);
	$number_of_pages = $table->find('b');
	$result = substr($number_of_pages[0]->innertext, -1);
	
	return $result;
}

function finalResult($cognome_param, $nome_param) {
	
	doLogin('log', 'sent', 'raticida@gmail.com', '0b6ccdde8a');
	
	$response = array();
	
	$init = 0;
	
	$search_result = doSearch($cognome_param, $nome_param, $init);
	
	$pages = checkPagination($search_result);
	
	$table_result = buildTableResult($search_result);
	
	$response = $table_result;
	
	$count = 1;

	while ($count <= $pages):

		$init = $count * 50;
		
		$search_result = doSearch($cognome_param, $nome_param, $init);
		
		$table_result = buildTableResult($search_result);

		$response = array_merge($response, $table_result);

		$count++;
		
		
	endwhile;
	
	$final_result = array();

	
	if(!empty($response)) {
		
		//$final_result['padova_rovigo']['status'] = true;
		$final_result['padova_rovigo']['msg'] = 'OK!';
		$final_result['padova_rovigo']['dados'] = $response;
	
	} else {
		
		//$final_result['padova_rovigo']['status'] = false;
		$final_result['padova_rovigo']['msg'] = 'Nenhum Registro Encontrado!';
		$final_result['padova_rovigo']['dados'] = null;
	
	}
	
	$final_result['padova_rovigo']['total_registro'] = count($response);
		

	return $final_result;

}