<?php 


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>DataTables example - Column filtering</title>

	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"/>-->
 


	<style type="text/css" class="init">

	thead input {
		width: 100%;
	}

	@media only screen and (max-width: 800px) {
	  .table-flip-scroll .flip-content:after,
	  .table-flip-scroll .flip-header:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0; }
	  .table-flip-scroll html .flip-content,
	  .table-flip-scroll html .flip-header {
		-ms-zoom: 1;
		zoom: 1; }
	  .table-flip-scroll *:first-child + html .flip-content,
	  .table-flip-scroll *:first-child + html .flip-header {
		-ms-zoom: 1;
		zoom: 1; }
	  .table-flip-scroll table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		display: block;
		position: relative; }
	  .table-flip-scroll th,
	  .table-flip-scroll td {
		margin: 0;
		vertical-align: top; }
	  .table-flip-scroll th:last-child,
	  .table-flip-scroll td:last-child {
		border-bottom: 1px solid #ddd; }
	  .table-flip-scroll th {
		border: 0 !important;
		border-right: 1px solid #ddd !important;
		width: auto !important;
		display: block;
		text-align: right; }
	  .table-flip-scroll td {
		display: block;
		text-align: left;
		border: 0 !important;
		border-bottom: 1px solid #ddd !important; }
	  .table-flip-scroll thead {
		display: block;
		float: left; }
	  .table-flip-scroll thead tr {
		display: block; }
	  .table-flip-scroll tbody {
		display: block;
		width: auto;
		position: relative;
		overflow-x: auto;
		white-space: nowrap; }
	  .table-flip-scroll tbody tr {
		display: inline-block;
		vertical-align: top;
		margin-left: -5px;
		border-left: 1px solid #ddd; } 
	}
	
	/* Icon inside input*/

	.input-group.input-group-seamless>.form-control {
		border-radius: .25rem
	}

	.input-group.input-group-seamless>.input-group-append,
	.input-group.input-group-seamless>.input-group-prepend {
		position: absolute;
		top: 0;
		bottom: 0;
		z-index: 4
	}

	.input-group.input-group-seamless>.input-group-append .input-group-text,
	.input-group.input-group-seamless>.input-group-prepend .input-group-text {
		padding: .75rem 1rem;
		background: 0 0;
		border: none
	}

	.input-group.input-group-seamless>.input-group-append {
		right: 0
	}

	.input-group.input-group-seamless>.input-group-middle {
		right: 0;
		left: 0
	}

	.input-group.input-group-seamless>.input-group-prepend {
		left: 0
	}

	.input-group.input-group-seamless>.custom-select:not(:last-child),
	.input-group.input-group-seamless>.form-control:not(:last-child) {
		padding-right: 40px
	}

	.input-group.input-group-seamless>.custom-select:not(:first-child),
	.input-group.input-group-seamless>.form-control:not(:first-child) {
		padding-left: 40px
	}	
	
	
	
	
	.input-group.input-group-seamless>.custom-select:not(:first-child),
	.input-group.input-group-seamless>.form-control:not(:first-child) {
		padding-left: 1.875rem
	}	

	.bd-example-tabs .nav-tabs {
		margin-bottom: 1rem;
	}	
	.bd-example {
		position: relative;
		padding: 1rem;
		margin: 1rem -15px 0;
		border: solid #f8f9fa;
		border-width: .2rem;		
	}
	#box {
		display: none;
	}
	
	#loading-overlay {
		position: absolute;
		width: 100%;
		height:100%;
		left: 0;
		top: 0;
		display: none;
		align-items: center;
		background-color: #ffffff30;
		z-index: 999;
	}
	.spinner-border {
		position: absolute;
		left: 50%;
		top: 50%;
	}
	#canvas-holder {
		width: 100%;
		margin-top: 50px;
		text-align: center;
	}
	#chartjs-tooltip {
		opacity: 1;
		position: absolute;
		background: rgba(0, 0, 0, .7);
		color: white;
		border-radius: 3px;
		-webkit-transition: all .1s ease;
		transition: all .1s ease;
		pointer-events: none;
		-webkit-transform: translate(-50%, 0);
		transform: translate(-50%, 0);
	}

	.chartjs-tooltip-key {
		display: inline-block;
		width: 10px;
		height: 10px;
		margin-right: 10px;
	}	
	</style>
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://www.chartjs.org/samples/latest/utils.js"></script>
	<!--<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>-->
	
	
	
	
<script type="text/javascript">
$(document).ready(function(){


	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );



	$('#searchInput').keypress(function (e) {
	  if (e.which == 13) {	
		$('searchForm').submit();
	  }
	});


	$("#searchForm").submit(function(e) {

		e.preventDefault(); // avoid to execute the actual submit of the form.

		var form = $(this);

		$.ajax({
			type: "POST",
			url: 'search.php',
			data: form.serialize(),
			beforeSend: function(){
				$('#box').hide();
				$("#loading-overlay").show();
			},
			success(data) {
				$.each(data, function(key, value) {
					createTables(key, value);
					console.log(key, value);
				});
			},
			error(e) {
				$("#loading-overlay").hide(); 
				console.log(e);
			}
		});
	});


	function createTables(key, value) {
	
		var province = key;
		var tableID = '#'+key;
		var labelID = '#'+key+'Label';
		var provinceData = value;
		var countResult = value.total_registro;
		
		$(tableID).empty();
		$(tableID).DataTable({
			"pageLength": 25,
			destroy: true,
			data: provinceData.dados,
			language: { url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json' },
			columns: [
				{ data: 'nome_completo', title: 'Nome Completo' },
				{ data: 'nome_pai', title: 'Nome do Pai' },
				{ data: 'nome_mae', title: 'Nome da Mãe' },
				{ data: 'data_nascimento', title: 'Data de Nascimento' },
				{ data: 'comune_nascimento', title: 'Comune de Nascimento' },
				{ data: 'provincia', title: 'Província' }
			],
			"initComplete": function( settings, json ) {
				$('#box').show();
				$("#loading-overlay").hide(); 
			}			
		});
		
		$(labelID).text(countResult);
	
	}
});
</script>
</head>
<body>
<div id="loading-overlay">
    <div class="spinner-border text-primary"></div>
</div>  
<div class="container">
					<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
					  <h1 class="display-4">Pesquisar</h1>
					  <p class="lead">Digite um Sobrenome para a pesquisa.</p>
					</div>
					<div class="row">
						<div class="col-lg-3">					
						</div>
						<div class="col-lg-6">
							<form id="searchForm">
								<div class="input-group mb-5">
								  <div class="input-group input-group-seamless">
									<input type="text" class="form-control" name="search" id="searchInput" value="" placeholder="Pesquisar um Sobrenome" required minlength="5">
									<span class="input-group-append">
									  <span class="input-group-text">
										<span class="fa fa-search"></span>
									  </span>
									</span>
								  </div>
								</div>
							</form>
						</div>
						<div class="col-lg-3">
						
						</div>
					</div>
		<div class="bd-example bd-example-tabs">
			<div id="box">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Treviso I <span class="badge badge-primary" id="trevisoLabel"></span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Treviso II <span class="badge badge-primary" id="treviso2Label"></span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Padova e Rovigo <span class="badge badge-primary" id="padova_rovigoLabel"></span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">Venezia <span class="badge badge-primary" id="veneziaLabel"></span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab" aria-controls="fifth" aria-selected="false">Vicenza I <span class="badge badge-primary" id="vicenzaLabel"></span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="sixth-tab" data-toggle="tab" href="#sixth" role="tab" aria-controls="sixth" aria-selected="false">Vicenza II <span class="badge badge-primary" id="vicenza2Label"></span></a>
				  </li>				  
				</ul>
				<div class="tab-content">
				  <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
					<table id="treviso" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>
				  <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
					<table id="treviso2" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>
				  <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
					<table id="padova_rovigo" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>
				  <div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
					<table id="venezia" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>
				  <div class="tab-pane fade" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
					<table id="vicenza" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>
				  <div class="tab-pane fade" id="sixth" role="tabpanel" aria-labelledby="sixth-tab">
					<table id="vicenza2" class="table table-striped table-bordered" cellspacing="0" width="100%">

					</table>			  
				  </div>				  
				</div>
			</div>
		</div>
	<div id="canvas-holder">
		<canvas id="chart-area"></canvas>
			<div id="chartjs-tooltip">
			<table id="tooltip"></table>
		</div>
	</div>


</div>
	<script>
		Chart.defaults.global.tooltips.custom = function(tooltip) {
			// Tooltip Element
			var tooltipEl = document.getElementById('chartjs-tooltip');

			// Hide if no tooltip
			if (tooltip.opacity === 0) {
				tooltipEl.style.opacity = 0;
				return;
			}

			// Set caret Position
			tooltipEl.classList.remove('above', 'below', 'no-transform');
			if (tooltip.yAlign) {
				tooltipEl.classList.add(tooltip.yAlign);
			} else {
				tooltipEl.classList.add('no-transform');
			}

			function getBody(bodyItem) {
				return bodyItem.lines;
			}

			// Set Text
			if (tooltip.body) {
				var titleLines = tooltip.title || [];
				var bodyLines = tooltip.body.map(getBody);

				var innerHtml = '<thead>';

				titleLines.forEach(function(title) {
					innerHtml += '<tr><th>' + title + '</th></tr>';
				});
				innerHtml += '</thead><tbody>';

				bodyLines.forEach(function(body, i) {
					var colors = tooltip.labelColors[i];
					var style = 'background:' + colors.backgroundColor;
					style += '; border-color:' + colors.borderColor;
					style += '; border-width: 2px';
					var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
					innerHtml += '<tr><td>' + span + body + '%</td></tr>';
				});
				innerHtml += '</tbody>';

				var tableRoot = tooltipEl.querySelector('#tooltip');
				tableRoot.innerHTML = innerHtml;
			}

			var positionY = this._chart.canvas.offsetTop;
			var positionX = this._chart.canvas.offsetLeft;

			// Display, position, and set styles for font
			tooltipEl.style.opacity = 1;
			tooltipEl.style.left = positionX + tooltip.caretX + 'px';
			tooltipEl.style.top = positionY + tooltip.caretY + 'px';
			tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
			tooltipEl.style.fontSize = tooltip.bodyFontSize;
			tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
			tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
		};	
	
	
		var treviso = 30;
		var padova_rovigo = 300;
		
		var total = treviso + padova_rovigo;
		
		console.log(total);
		
		var porcent_treviso = Math.round((treviso * 100) / total);
		
		var porcent_padova_rovigo = Math.round((padova_rovigo * 100) / total);
		
		console.log('Treviso ' + porcent_treviso);
		console.log('Padova e Rovigo ' + porcent_padova_rovigo);
		console.log('Total ' + (porcent_padova_rovigo + porcent_treviso));
		
		
	
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						porcent_treviso,
						porcent_padova_rovigo,
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Treviso',
					'Padova e Rovigo',
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					labels: {
						padding: 20,
						fontSize: 20,
						boxWidth: 80
					}
				},
				tooltips: {
					enabled: false,
				}
			}	
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
	</script>

</body>
</html>