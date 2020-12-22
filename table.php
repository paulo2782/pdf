<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>TABELA</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	</head>

	<body>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script></body>
</html>

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
"<table class='table table-responsive' id='tab'>
	<tbody> 
";

$textoAll = [];
for($i = 0 ; $i <= $iDescricao-1 ; $i++){
	$aDescricao = explode("@",$descricao[$i].nl2br(''));
echo
	"
		<tr scope='row' class='row'.".$i.">
			<td class='col1'>$aDescricao[0]</td>
			<td class='col2'>$aDescricao[1]</td>
			<td class='col3'>$aDescricao[2]</td>
			<td class='col4'>$aDescricao[3]</td>
		</tr>"; 
	array_push($textoAll, $aDescricao[0].','.$aDescricao[1].','.$aDescricao[2].','.$aDescricao[3]);
	} 

"</tbody></table>";


?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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