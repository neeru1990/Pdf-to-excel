<!-- Password Modal -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;

// getting the name of the file just uploaded from database
$filename = $formsixteendata['uploadfile'];

//waiting for the file to be uploaded in /uploads directory and entered into database
while (!file_exists('uploads/'.$filename)) sleep(1);

//setting the path of input and output file(converted file) 
$inputPath = getcwd().'/uploads/'.$filename;
$outputPath = getcwd().'/uploads/unlocked_'.$filename;

//echo $inputPath."<br>";
//echo $outputPath."<br>";

if($_POST['PDFpassword'] == ''){
	$output = shell_exec('gs -q -P -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile='.$outputPath.' -c .setpdfwrite -f '.$inputPath);
	}
else {
	$output = shell_exec('gs -sPDFPassword='.$_POST['PDFpassword'].' -q -P -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile='.$outputPath.' -c .setpdfwrite -f '.$inputPath);
	}
	
if($output != ''){
?>
<div class="alert alert-warning">
  <h4><strong>Please enter the password !</strong><h4>
  
</div>
<div style = "padding: 0px 17px 10px;">
	<form method="post" action="#" class = "bs-example bs-example-form" role = "form">
		<div class="input-group">
			<label for="pdfPass">Password:</label>
			<input type=text class="form-control" name="PDFpassword" id="pdfPass" aria-describedby="passInput" placeholder="*******"><br>
			<small id="passInput" class="form-text text-muted">We'll never share your password with anyone else.</small>
			<br>
			<button type="submit" style = "margin-top:10px; background: #f58220;" class="btn"><i class="fa fa-unlock-alt" aria-hidden="true"></i></button>
		</div>
	</form>
</div>

<?php
	if($_POST['PDFpassword']!=''){
		?>
		<div class="alert alert-danger">
  			<strong>Incorrect password !</strong>
		</div>
		<?php
		}
}

else {
?>
	<div class="alert alert-success">
  		<strong>All Done !</strong>
	</div>
<?php
}


//echo $output;


//ghostscript is installed but neither java nor python 
//shell_exec('java -jar '.__DIR__.'/pdfbox-app-2.0.5.jar Decrypt -password=BTJPG20021993 '.__DIR__.'/Form16_2015-2016.pdf unencrypted.pdf' , $output);
//$version = shell_exec("gs --version");
//echo $version."<br>";

?>

<?php   
	  
	//PDFTables REST api using curl library.
	  
        //A work around when there is no curl_file_create() defined
        if (!function_exists('curl_file_create'))
	{
		function curl_file_create($filename, $mimetype = '', $postname = '')
		{
			return "@$filename;filename="
				. ($postname ?: basename($filename))
				. ($mimetype ? ";type=$mimetype" : '');
		}
	}

        $filePath = getcwd().'/uploads/'.$filename;
        
        //PDFTables curl code 
        
        $c = curl_init();
        //$fp = fopen($filePath, 'r');
	$cfile = curl_file_create($filePath, 'application/pdf');
	curl_setopt($c, CURLOPT_URL, 'https://pdftables.com/api?key=xxxxxxxxxx&format=xlsx-single');
	curl_setopt($c, CURLOPT_POSTFIELDS, array('file' => $cfile));
	//curl_setopt($c, CURLOPT_UPLOAD, true);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_ENCODING, "gzip,deflate");
	//curl_setopt($c, CURLOPT_INFILE, $fp);
	$result = curl_exec($c);
	if (curl_errno($c)) {
	    print('Error calling PDFTables: ' . curl_error($c));
	}
	// save the XLSX we got from PDFTables to a file
	$filenamexlsx = basename($filename , '.pdf');
	file_put_contents ('uploads/'.$filenamexlsx.'.xlsx', $result);
	curl_close($c);
        
          

?>

<?php
define("ROOT",dirname(__FILE__).'/' );

// pdf parser is used JUST TO EXTRACT extra information.

include dirname(ROOT).'/pdftoexcel/pdfparser-master/vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('uploads/unlocked_'.$filename);
//$pdf    = $parser->parseFile('uploads/Form16_2015-2017.pdf');
             
//print_r($pdf->getText());

// Retrieve all pages from the pdf file.
$content = explode("\n", $pdf->getText());

            
 
require(ROOT.'../pdftoexcel/php-excel-reader/excel_reader2.php');
require(ROOT.'../pdftoexcel/SpreadsheetReader.php');

//$Reader = new SpreadsheetReader('converted_uploads/'.$filenamexlsx.'.xlsx');

$Reader = new SpreadsheetReader('converted_uploads/example.xlsx');
//$Reader = new SpreadsheetReader('converted_uploads/sample-form16.xlsx');

	foreach ($Reader as $Row)
	{
		print_r($Row);
		echo "<br>";
	}
	
	
