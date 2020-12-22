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

	echo "<a href='table.php?file=$filename.csv'> DOWNLOAD";

}