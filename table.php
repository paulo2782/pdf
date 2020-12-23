<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<title>Converter PDF/CSV</title>
	</head>
	<body>
		<div class="container">
			<?php
	
				$filename = $_GET['file'];

				$csvFile = file('pdf/'.$filename);
				$data = [];

				foreach ($csvFile as $line) {
					$data[] = str_getcsv(utf8_encode($line));

				}

				$iTotal =  count($data);

				$texto = [];
				$aux   = [];

				$descricao = [];
				for($i = 0 ; $i <= $iTotal-1 ; $i++){
							
					$str = explode("@",$data[$i][0]);
					array_push($texto, $data[$i][0]);

					$iVetor = count($str);
					
					// COMPLETO
					if($iVetor == 4){
						$str = explode("@", $data[$i][0]);
						$str = $str[3]."@".$str[2]."@".$str[1]."@".$str[0];
						array_push($descricao, $str);
					}

					// FALTA CODIGO
					// if($iVetor == 3){
						// $str = explode("***", $data[$i][0]);
						// var_dump($str);
						// echo "[".$i.'-'.$iVetor."] - ".$texto[$i]."<br>";			
					// }

					// LINHA 2
					if($iVetor == 2){
						$ii     = $i-1;
						$str    = explode("@", $texto[$i]);
						$strAux = $texto[$ii].$texto[$i];
						$x      = array_push($aux, $strAux);
						$str    = explode("@", $aux[$x-1]);
						$str    = $str[3]."@".$str[2]."@".$str[1]."@".$str[0];

						array_push($descricao, $str);
					}


					// PAGINAS
					if($iVetor == 1){
					}

					// NADA 
					if($iVetor == 0){
					}

				}

				$iDescricao = count($descricao);

				echo
				"<table class='table table-responsive' id='tab' width='70%'>
				<tbody> 
				<th>Código</th>
				<th>Descrição do Serviço</th>
				<th>Unidade</th>
				<th>R$</th>

				";

				$textoAll = [];
				for($i = 0 ; $i <= $iDescricao-1 ; $i++){
				$aDescricao = explode("@",$descricao[$i].nl2br(''));

				if($aDescricao[0]  <> 'Código' && 
					$aDescricao[1] <> 'Descrição do Serviço' &&
					$aDescricao[2] <> 'Unidade' &&
					$aDescricao[3] <> '(R$)')
				{

				echo
				"
					<tr scope='row' class='$i'>
						<td class=''>$aDescricao[0]</td>
						<td class=''>$aDescricao[1]</td>
						<td class=''>$aDescricao[2]</td>
						<td class=''>$aDescricao[3]</td>
					</tr>"; 
				array_push($textoAll, $aDescricao[0].','.$aDescricao[1].','.$aDescricao[2].','.$aDescricao[3]);
				} 

				"</tbody></table>";
				}

			?>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="dist/table2csv.min.js"></script>
		<script>
			let options = {
			"separator": ",",
			"newline": "\n",
			"quoteFields": true,
			"excludeColumns": "",
			"excludeRows": "",
			"trimContent": true,
			"filename": "table.csv",
			"appendTo": "#output"
			}

			$('#tab').table2csv('download', options)
		</script>		
	</body>
</html>

