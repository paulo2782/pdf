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
			include ( 'PdfToText.phpclass' ) ;

			$filename_tmp  = $_FILES['file']['tmp_name'];
			$filename_name = $_FILES['file']['name']; 

			move_uploaded_file($_FILES['file']['tmp_name'],"pdf/".$_FILES['file']['name']);
			convertTxt("pdf/".$filename_name);


			function convertTxt($filename){

					$pdf	=  new PdfToText () ;
					// Modify any property here before loading the file ; for example :
					$pdf -> BlockSeparator = "@" ;

					$pdf -> Load ($filename) ;
					
					$conteudo = $pdf -> Text ;

				$i = strlen($filename);
				$filename = substr($filename,0,$i-4);
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/".$filename.".txt","wb");

				fwrite($fp,$conteudo);

				fclose($fp);

				viewData($filename);
			}

			function viewData($filename){

				$file = $_SERVER['DOCUMENT_ROOT'] . "/".$filename.".txt";

				$handle = fopen($file, "r");
				$lines = [];
				if (($handle = fopen($file, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
						$lines[] = $data;
					}
					fclose($handle);
				}
				$fp = fopen($filename.'.csv', 'w');

				foreach ($lines as $line ) {
					fputcsv($fp,  mb_convert_encoding($line, "iso-8859-15"));
				}
				fclose($fp);


				// echo "Segue o link para download do arquivo";
				// echo "<br>";
				// echo "<br>";
				// echo "<a href='/$filename.csv'>http://".$_SERVER['SERVER_NAME']."/".$filename.".csv</a>";
				// echo "<br>";
				// echo "<br>";
				echo "Segue o link para download";
				echo "<br>";
				echo "<br>";
				$i = strlen($filename);
				$filename = substr($filename,4,$i);

				echo "<a href='table.php?file=$filename.csv'> Download";

			}
			?>
		</div>		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>