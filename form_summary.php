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
//echo $filename."<br>";

//echo getcwd()."<br>";
//echo $_POST['PDFpassword']."<br>";
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
	//header('Location: form-summary');
if($output != ''){
?>
<div class="alert alert-warning">
  <h4><strong>Please enter the password !</strong><h4>
  <small>It might be your PAN number if individual or TAN in case of company.</small>
</div>
<div style = "padding: 0px 17px 10px;">
	<form method="post" action="/trutax_development/paytax/form-summary" class = "bs-example bs-example-form" role = "form">
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
/*
	$license_code = '55F275E4-CBDA-4106-B382-FF113FE72E9B';
        $username =  'neer1990';
*/
      
/*
           You should specify OCR settings. See full description http://www.ocrwebservice.com/service/restguide
         
           Input parameters:
         
	   [language]     - Specifies the recognition language. 
	   		    This parameter can contain several language names separated with commas. 
                            For example "language=english,german,spanish".
			    Optional parameter. By default:english
        
	   [pagerange]    - Enter page numbers and/or page ranges separated by commas. 
			    For example "pagerange=1,3,5-12" or "pagerange=allpages".
                            Optional parameter. By default:allpages
         
           [tobw]	  - Convert image to black and white (recommend for color image and photo). 
			    For example "tobw=false"
                            Optional parameter. By default:false
         
           [zone]         - Specifies the region on the image for zonal OCR. 
			    The coordinates in pixels relative to the left top corner in the following format: top:left:height:width. 
			    This parameter can contain several zones separated with commas. 
		            For example "zone=0:0:100:100,50:50:50:50"
                            Optional parameter.
          
           [outputformat] - Specifies the output file format.
                            Can be specified up to two output formats, separated with commas.
			    For example "outputformat=pdf,txt"
                            Optional parameter. By default:doc

           [gettext]	  - Specifies that extracted text will be returned.
			    For example "tobw=true"
                            Optional parameter. By default:false
        
           [description]  - Specifies your task description. Will be returned in response.
                            Optional parameter. 


	   !!!!  For getting result you must specify "gettext" or "outputformat" !!!!  

	
*/
/*

        // Build your OCR:

        // Extraction text with English language
        //$url = 'http://www.ocrwebservice.com/restservices/processDocument?gettext=true';

        // Extraction text with English and german language using zonal OCR
        // $url = 'http://www.ocrwebservice.com/restservices/processDocument?language=english,german&zone=0:0:600:400,500:1000:150:400';
/*
        // Convert first 5 pages of multipage document into doc and txt
        $url = 'http://www.ocrwebservice.com/restservices/processDocument?language=english&pagerange=1-2&outputformat=xlsx';
      

        // Full path to uploaded document
        //getcwd() - /home/usernametrutax/public_html/trutax_development/frontend/web
        $filePath = getcwd().'/uploads/'.$filename;
        //echo $filePath."<br>";
        //__DIR__ - /home/usernametrutax/public_html/trutax_development/frontend/themes/views/paytax
        //echo __DIR__;
  
        $fp = fopen($filePath, 'r');
        $session = curl_init();

        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_USERPWD, "$username:$license_code");

        curl_setopt($session, CURLOPT_UPLOAD, true);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session, CURLOPT_TIMEOUT, 200);
        curl_setopt($session, CURLOPT_HEADER, false);
*/

        // For SSL using
        //curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);

        // Specify Response format to JSON or XML (application/json or application/xml)
/*
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 
        curl_setopt($session, CURLOPT_INFILE, $fp);
        curl_setopt($session, CURLOPT_INFILESIZE, filesize($filePath));

        $result = curl_exec($session);

  	$httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
        curl_close($session);
        fclose($fp);
	
        if($httpCode == 401) 
	{
           // Please provide valid username and license code
          echo 'Unauthorized request';
        }

        // Output response
	$data = json_decode($result);

        if($httpCode != 200) 
	{
	   // OCR error
           echo $data->ErrorMessage;
        }
*/
        // Task description
	//echo 'TaskDescription:'.$data->TaskDescription."\r\n";

        // Available pages 
	//echo 'AvailablePages:'.$data->AvailablePages."\r\n";

        // Extracted text
        //echo 'OCRText='.$data->OCRText[0][0]."\r\n";
	//echo $data->OutputFileUrl;

        //$text = explode(' ', $data->OCRText[0][0]);
        //print_r($text);

        // For zonal OCR: OCRText[z][p]    z - zone, p - pages

        // Get First zone from each page 
        //echo 'OCRText[0][0]='.$data->OCRText[0][0]."\r\n";
        //echo 'OCRText[0][1]='.$data->OCRText[0][1]."\r\n";


        // Get second zone from each page
        //echo 'OCRText[1][0]='.$data->OCRText[1][0]."\r\n";
        //echo 'OCRText[1][1]='.$data->OCRText[1][1]."\r\n";


        // Download output file (if outputformat was specified)
/*
        $url = $data->OutputFileUrl;   
        $content = file_get_contents($url);
        $name = basename($url);

        file_put_contents('converted_uploads/'.$name, $content);

        // End recognition
        while (!file_exists('converted_uploads/'.$name)) sleep(1);
        //echo "file ready";
        //echo $name."<br>";
        
        */
        
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
	curl_setopt($c, CURLOPT_URL, 'https://pdftables.com/api?key=ben77ywavz0p0&format=xlsx-single');
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
	file_put_contents ('converted_uploads/'.$filenamexlsx.'.xlsx', $result);
	curl_close($c);
        
          

?>

<?php
define("ROOT",dirname(__FILE__).'/' );
//echo dirname(ROOT)."/pdftoexcel/";

// pdf parser is used JUST TO EXTRACT employee name and address and employer's as well

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

$Reader = new SpreadsheetReader('converted_uploads/VIKRAM GROVER_AYBPG4848D_AY201516_16_SIGNED.xlsx');
//$Reader = new SpreadsheetReader('converted_uploads/sample-form16.xlsx');
//$Reader = new SpreadsheetReader('http://www.ocrwebservice.com/uploads/_output/7beb_e97f97c3-b6b8-413b-8e45-c26a95331840.xlsx');



	//var_dump($Reader);
	$dataArray = array();
	$i = 0;
	$startIndex1 = 0;
        $startIndex1value=0;
	$startIndex2 = 0;
	$startIndex2value= '';
	$startIndex3 = 0;
	$startIndex3value= '';
	$employee_details['name'] = '';
	$startIndex4 = 0;
	$startIndex4value = 0;
	$startIndex5 = 0;
	$startIndex5value=0;
	$startIndex6 = 0;
	$employer_details['name'] = '';
        $startIndex7 = 0;
	$startIndex7value=0;
	$startIndex8 = 0;
	$startIndex8value=0;
	$startIndex9 = 0;
	$startIndex9value = 0;
	$startIndex10 = 0;
	$startIndex10value = 0;
	$startIndex11 = 0;
	$startIndex11value = 0;
	$startIndex12 = 0;
	$startIndex12value = 0;
        $startIndex13 = 0;
	$startIndex13value = 0;
	$startIndex14 = 0;
	$startIndex14value = 0;
	$startIndex15 = 0;
	$startIndex15value = 0;
	$startIndex16 = 0;
	$startIndex16value = 0;
	$startIndex17 = 0;
	$startIndex17value = 0;
	$startIndex18 = 0;
	$startIndex18value = 0;
        $startIndex19 = 0;
	$startIndex19value = 0;
	$startIndex20 = 0;
	$startIndex20value = 0;
	$startIndex21 = 0;
	$startIndex21value = 0;
	$startIndex22 = 0;
	$startIndex22value = 0;
	$startIndex23 = 0;
	$startIndex23value = '';
	$startIndex24 = 0;

foreach ($content as $key => $value) {
        //echo $key . ' '. $value.'<br>';
        $searchword = 'employee Name';
        if(preg_match("/\b$searchword\b/i", $value)){
            $startIndex2 = $key;
            //break;
        }
        $searchword = 'name and address of the Employee';
	if(preg_match("/\b$searchword\b/i", $value)){
		$startIndex3 = $key;
                $i = 0;
                //echo '$startindex'.$startIndex3.$content[$startIndex3 + 3];
                $searchword = 'pan of the deductor';
                //echo "match".preg_match("/\b$searchword\b/i", $content[$startIndex3 + 3]);
                
                while(!preg_match("/\b$searchword\b/i", $content[$startIndex3 + $i])&&$i<4){	
			$employee_details['name'] = $content[$startIndex3 + 1];
			$employee_details['address_line'.$i] = $content[$startIndex3 + 2 + $i];
			//break;
			$i++;
                }
                
	}

        $searchword = 'name and address of the employer';
	if(preg_match("/\b$searchword\b/i", $value)) {
	        $startIndex6 = $key;
                $i = 0;
                $searchword = 'name and address of the Employee';
                if(strlen($content[$startIndex6])-3 < strlen("name and address of the player")){
                	while(!preg_match("/\b$searchword\b/i", $content[$startIndex6 + $i])&&$i<4){                      	
                        	$employer_details['name'] = $content[$startIndex6 + 1];
                            	$employer_details['address_line'.$i] = $content[$startIndex6 + 2 + $i];
                            	$i++;
                            }
                        }
                else if(strpos($content[$startIndex6],':')!==false){
                	while(!preg_match("/\b$searchword\b/i", $content[$startIndex6 + $i])&&$i<4){                      	
                        	$employer_details['name'] = explode(':',$content[$startIndex6])[1];
                            	$employer_details['address_line'.$i] = $content[$startIndex6 + 1 + $i];
                            	$i++;
                    	    }
                        }
                else {
                       while(!preg_match("/\b$searchword\b/i", $content[$startIndex6 + $i])&&$i<4){                      	
                        	$employer_details['name'] = explode(' ',$content[$startIndex6])[1];
                            	$employer_details['address_line'.$i] = $content[$startIndex6 + 1 + $i];
                            	$i++;
                    	    }
                     }
                
    	}

}
        //echo '<br>';
 
	foreach ($Reader as $Row)
	{
		//print_r($Row);
		$dataArray[$i] = $Row;
		$i++;
		//echo "<br>";
	}
	//print_r($dataArray);
	//echo "<br><br>";
	foreach ($dataArray as $key => $value) {
		$len = count($value);
		//echo $len;
		//var_dump($value);
		//echo $key. "=>" . $value[0]."<br>";
        
	        for($i = 0; $i < $len; $i++){          
			$searchword = 'Income Chargeable Under the head';
			if(preg_match("/\b$searchword\b/i", $value[$i])){
				$startIndex1 = $key;
				for($j = 1; $j < $len; $j++){
	                        	if(is_numeric($value[$j])){
						$startIndex1value = $value[$j];                                       
						//echo "<br>".$value[$j];
	                                       	break;
	                             	}
	                        }
			}
		}
/*
        for($i = 0 ; $i < $len; $i++){
	        $searchword = 'employee Name';
			if(preg_match("/\b$searchword\b/i", $value[$i])){
				$startIndex2 = $key;
				//break;
			}
		}
        for($i = 0 ; $i < len; $i++){
	        $searchword = 'address of the Employee';
			if(preg_match("/\b$searchword\b/i", $value[$i])){
				$startIndex3 = $key;
				//break;
			}
		}
*/
		for($i = 0 ; $i < $len; $i++){
			$searchword = 'tan';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'tan of employer'\b/i", $value[$i])){
				$startIndex4 = $key;
				//break;
                                $values=explode(":",$value[$i]);
                                $startIndex4value = $values[1];
                                break;
			}
		}
		for($i = 0 ; $i < $len; $i++){
			$searchword = 'Tax payable';
			if(preg_match("/\b$searchword\b/i", $value[$i])){
				$startIndex5 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex5value = $value[$j];                                       
						//echo "<br>".$value[$j];
						break;
                                     	}
                                }
			}
		}
/*
		for($i = 0 ; $i < $len; $i++){
			$searchword = 'address of the employer';
			if(preg_match("/\b$searchword\b/i", $value[$i])) {
	        	        $startIndex6 = $key;
	    	}
	    }
*/
	    	for($i = 0; $i < $len; $i++){
			$searchword = 'self occupied house';
			if(preg_match("/\b$searchword\b/i", $value[$i])) {
				$startIndex7 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex7value = $value[$j];                                       
						//echo "<br>".$value[$j];
                                       		break;
                                     	}
                                }
                                break;
			}
		}
		for($i = 0 ; $i < $len; $i++){
			$searchword = 'let out house';
			if(preg_match("/\b$searchword\b/i", $value[$i])) {
				$startIndex8 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex8value = $value[$j];                                       
						//echo "<br>".$value[$j];
                                       		break;
                                     	}
                                }
                                break;
			}
		}
		for($i = 0 ; $i < $len; $i++){
	        $searchword = '80e';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 e'\b/i", $value[$i])){
				$startIndex9 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex9value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
		for($i = 0 ; $i < $len; $i++){
	        $searchword = '80g';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 g'\b/i", $value[$i])){
				$startIndex10 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                               		if(is_numeric($value[$j])){
						$startIndex10value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80d';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 d'\b/i", $value[$i])){
				$startIndex11 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex11value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80ccg';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 ccg'\b/i", $value[$i])) {
				$startIndex12 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex12value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80gga';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 gga'\b/i", $value[$i])) {
				$startIndex13 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex13value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80tta';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 tta'\b/i", $value[$i])) {
				$startIndex14 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex14value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80rrb';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 rrb'\b/i", $value[$i])) {
				$startIndex15 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex15value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                      	 	break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80qqb';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 qqb'\b/i", $value[$i])) {
				$startIndex16 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex16value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80ggc';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 ggc'\b/i", $value[$i])) {
				$startIndex17 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex17value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80gg';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 gg'\b/i", $value[$i])){
				$startIndex18 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex18value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80ee';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 ee'\b/i", $value[$i])){
				$startIndex19 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex19value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = '80ddb';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 ddb'\b/i", $value[$i])) {
				$startIndex20 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex20value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
                for($i = 0 ; $i < $len; $i++){
	        $searchword = 'pan';
			if(preg_match("/\b$searchword\b/i", $value[$i])) {
				$startIndex21 = $key;
				//break;
                                $values=explode(":",$value[$i]);
                                $startIndex21value = $values[1];
                                break;
			}
		}
		for($i = 0 ; $i < $len; $i++){
	        $searchword = '80c';
			if(preg_match("/\b$searchword\b/i", $value[$i])||preg_match("/\b'80 c'\b/i", $value[$i])) {
				$startIndex22 = $key;
				//break;
                                for($j = 0; $j < $len; $j++){
                                	if(is_numeric($value[$j])){
						$startIndex22value = $value[$j];                                       
						//echo "<br>".$value[$j]."<br>";
                                       		break;
                                     	}
                                }
                                break;
			}
		}
	}
	
	
	//print_r($employee_details);
	//echo "<br>";
	//print_r($employer_details);
	$startIndex2value = $employee_details['name'];
	$startIndex23value = $employer_details['name'];
	for($i = 0;$i<count($employee_details);$i++){
		if(preg_match("/\b\d{6}\b/", $employee_details['address_line'.$i])){
			$startIndex3value = $startIndex3value . $employee_details['address_line'.$i];
			break;
			//echo 'zip'.preg_match("/\b\d{6}\b/", $employee_details['address_line'.$i]);
		}
		else
			$startIndex3value = $startIndex3value . $employee_details['address_line'.$i];	
	}
	
	for($i = 0;$i<count($employer_details);$i++){
		if(preg_match("/\b\d{6}\b/", $employer_details['address_line'.$i])){
			$startIndex6value = $startIndex6value . $employer_details['address_line'.$i];
			break;
			//echo 'zip'.preg_match("/\b\d{6}\b/", $employee_details['address_line'.$i]);
		}
		else
			$startIndex6value = $startIndex6value . $employer_details['address_line'.$i];	
	}
	//echo "<br><br>";
	/*
	echo $startIndex1." Income Chargeable Under the head ".$startIndex1value;
	echo "<br>";
	echo $startIndex2." employee Name ".$startIndex2value;
	echo "<br>";
	echo $startIndex3." address of the Employee ".$startIndex3value;
	echo "<br>";
	echo $startIndex4." TAN ".$startIndex4value;
	echo "<br>";
	echo $startIndex5." Tax payable ".$startIndex5value;
	echo "<br>";
	echo $startIndex6." address of the employer ".$startIndex6value;
        echo"<br>";
        echo $startIndex7." self occupied house ".$startIndex7value;
	echo "<br>";
        echo $startIndex8." let out house ".$startIndex8value;
	echo "<br>";
        echo $startIndex9." 80e ".$startIndex9value;
	echo "<br>";
        echo $startIndex10." 80g ".$startIndex10value;
	echo "<br>";
        echo $startIndex11." 80d ".$startIndex11value;
	echo "<br>";
        echo $startIndex12." ccg ".$startIndex12value;
	echo "<br>";
        echo $startIndex13." gga ".$startIndex13value;
	echo "<br>";
	echo $startIndex14." tta ".$startIndex14value;
	echo "<br>";
	echo $startIndex15." rrb".$startIndex15value;
	echo "<br>";
	echo $startIndex16." qqb".$startIndex16value;
	echo "<br>";
	echo $startIndex17." ggc ".$startIndex17value;
	echo "<br>";
	echo $startIndex18." gg ".$startIndex18value;
	echo "<br>";
	echo $startIndex19." ee ".$startIndex19value;
	echo "<br>";
	echo $startIndex20." ddb ".$startIndex20value;
	echo "<br>";
	echo $startIndex21." PAN ".$startIndex21value;
	echo "<br>";
	echo $startIndex22." 80c ".$startIndex22value;
	echo "<br>";
	echo $startIndex23." employer Name ".$startIndex23value;
	*/
	//echo "Employee Ref No. => " . $dataArray[$startIndex + 1][0] ;
$formSixteenData = (new \yii\db\Query())->createCommand()->insert('form_sixteen_data',['employee_name'=>$startIndex2value,'employer_name'=>$startIndex23value,'email'=>'neerruuu@gmail.com','income_chargeable'=>$startIndex1value,'tan'=>$startIndex4value,'tds'=>$startIndex5value,'employer_address'=>$startIndex6value,'employee_address'=>$startIndex3value,'house_self_occupied'=>$startIndex7value,'house_let_out'=>$startIndex8value,'deduction_80c'=>$startIndex22value,'deduction_80ccd_b'=>$startIndex12value,'deduction_80d'=>$startIndex11value,'deduction_80ddb'=>$startIndex20value,'deduction_80e'=>$startIndex9value,'deduction_80ee'=>$startIndex19value,'deduction_80gg'=>$startIndex18value,'deduction_80g'=>$startIndex10value,'deduction_80gga'=>$startIndex13value,'deduction_80ggc'=>$startIndex17value,'deduction_80qqb'=>$startIndex16value,'deduction_80rrb'=>$startIndex15value,'deduction_80tta'=>$startIndex14value])->execute();
	
	//echo "<br>";
	?>
<?php echo Html::a('<span style="background:#f58220;">Proceed to e-filing</span>',['/users/personalinfonew/'.$logData],['class' => 'borderred_link','style' => 'margin-left:20px;']);?>
<?php echo "<br><br>" ?>