<?php
//echo "hello";
if(isset($_FILES['upload'])){
    //echo "file uploaded";
    $fileName = $_FILES['upload']['name'];
    $fileType = $_FILES['upload']['type'];
    $fileSize = $_FILES['upload']['size'];
    //$fileContent = file_get_contents($_FILES['upload']['tmp_name']);
    //echo 'hello'.$fileName;
    $targetDir = "uploads/";
    $targetFilePath = $targetDir . $fileName;
    if(move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFilePath)){
            //insert file data into the database if needed
            //........
            $response['status'] = 'ok';
            // Include Composer autoloader if not already done.
            include 'vendor/autoload.php';
             
            // Parse pdf file and build necessary objects.
            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile('uploads/'.$fileName);
             
            //print_r($pdf->getText());
            /*
             $details  = $pdf->getDetails();
             
            // Loop over each property to extract values (string or array).
            foreach ($details as $property => $value) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                echo $property . ' => ' . $value . "\n";
            }

            */
            // Retrieve all pages from the pdf file.
            $content = explode("\n", $pdf->getText());

            foreach ($content as $key => $value) {
                echo $key . ' '. $value.'<br>';
            }
            echo '<br>';

            //echo $content[5]. ' : ' .$content[12];
            }
        }else{
            $response['status'] = 'err';
        }


 
?>