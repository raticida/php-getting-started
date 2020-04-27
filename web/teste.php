<?php	

function provinceCheck($sigla) {
	
	$provincias = array(
	"Agrigento" => 'AG',
	"Alessandria" => 'AL',
	"Ancona" => 'AN',
	"Aosta" => 'AO',
	"L'Aquila" => 'AQ',
	"Arezzo" => 'AR',
	"Ascoli-Piceno" => 'AP',
	"Asti" => 'AT',
	"Avellino" => 'AV',
	"Bari" => 'BA',
	"Barletta-Andria-Trani" => 'BT',
	"Belluno" => 'BL',
	"Benevento" => 'BN',
	"Bergamo" => 'BG',
	"Biella" => 'BI',
	"Bologna" => 'BO',
	"Bolzano" => 'BZ',
	"Brescia" => 'BS',
	"Brindisi" => 'BR',
	"Cagliari" => 'CA',
	"Caltanissetta" => 'CL',
	"Campobasso" => 'CB',
	"Carbonia Iglesias" => 'CI',
	"Caserta" => 'CE',
	"Catania" => 'CT',
	"Catanzaro" => 'CZ',
	"Chieti" => 'CH',
	"Como" => 'CO',
	"Cosenza" => 'CS',
	"Cremona" => 'CR',
	"Crotone" => 'KR',
	"Cuneo" => 'CN',
	"Enna" => 'EN',
	"Fermo" => 'FM',
	"Ferrara" => 'FE',
	"Firenze" => 'FI',
	"Foggia" => 'FG',
	"Forli-Cesena" => 'FC',
	"Frosinone" => 'FR',
	"Genova" => 'GE',
	"Gorizia" => 'GO',
	"Grosseto" => 'GR',
	"Imperia" => 'IM',
	"Isernia" => 'IS',
	"La-Spezia" => 'SP',
	"Latina" => 'LT',
	"Lecce" => 'LE',
	"Lecco" => 'LC',
	"Livorno" => 'LI',
	"Lodi" => 'LO',
	"Lucca" => 'LU',
	"Macerata" => 'MC',
	"Mantova" => 'MN',
	"Massa-Carrara" => 'MS',
	"Matera" => 'MT',
	"Medio Campidano" => 'VS',
	"Messina" => 'ME',
	"Milano" => 'MI',
	"Modena" => 'MO',
	"Monza-Brianza" => 'MB',
	"Napoli" => 'NA',
	"Novara" => 'NO',
	"Nuoro" => 'NU',
	"Ogliastra" => 'OG',
	"Olbia Tempio" => 'OT',
	"Oristano" => 'OR',
	"Padova" => 'PD',
	"Palermo" => 'PA',
	"Parma" => 'PR',
	"Pavia" => 'PV',
	"Perugia" => 'PG',
	"Pesaro-Urbino" => 'PU',
	"Pescara" => 'PE',
	"Piacenza" => 'PC',
	"Pisa" => 'PI',
	"Pistoia" => 'PT',
	"Pordenone" => 'PN',
	"Potenza" => 'PZ',
	"Prato" => 'PO',
	"Ragusa" => 'RG',
	"Ravenna" => 'RA',
	"Reggio-Calabria" => 'RC',
	"Reggio-Emilia" => 'RE',
	"Rieti" => 'RI',
	"Rimini" => 'RN',
	"Roma" => 'Roma',
	"Rovigo" => 'RO',
	"Salerno" => 'SA',
	"Sassari" => 'SS',
	"Savona" => 'SV',
	"Siena" => 'SI',
	"Siracusa" => 'SR',
	"Sondrio" => 'SO',
	"Taranto" => 'TA',
	"Teramo" => 'TE',
	"Terni" => 'TR',
	"Torino" => 'TO',
	"Trapani" => 'TP',
	"Trento" => 'TN',
	"Treviso" => 'TV',
	"Trieste" => 'TS',
	"Udine" => 'UD',
	"Varese" => 'VA',
	"Venezia" => 'VE',
	"Verbania" => 'VB',
	"Vercelli" => 'VC',
	"Verona" => 'VR',
	"Vibo-Valentia" => 'VV',
	"Vicenza" => 'VI',
	"Viterbo" => 'VT',
	);

	$result = array_search($sigla, $provincias);
		
	return $result;
}
		
		
echo provinceCheck('AN');
?>