<?php
require('php-excel-reader/excel_reader2.php');
require('SpreadsheetReader.php');

	//$Reader = new SpreadsheetReader('VIKRAM_GROVER_AYBPG4848D_AY201516_16_SIGNED.xlsx');
	//$Reader = new SpreadsheetReader('Form16_2015-2016.xlsx');
	//$Reader = new SpreadsheetReader('sample-form16.xlsx');
	//$Reader = new SpreadsheetReader('sample-form16_5.xlsx');
	$Reader = new SpreadsheetReader('sample-form16_6.xlsx');



	//var_dump($Reader);
	$dataArray = array();
	$i = 0;
	$startIndex = 0;
	foreach ($Reader as $Row)
	{
		print_r($Row);
		$dataArray[$i] = $Row;
		$i++;
		echo "<br>";
	}
	//print_r($dataArray);
	echo "<br><br>";
	foreach ($dataArray as $key => $value) {
		echo $key. "=>" . $value[0];
		if(strcasecmp($value[0], '(a) Salary as Per Provisions contained in Section 17(1)') == 0){
			$startIndex = $key;
			break;
		}
	}

	echo "<br><br>";
	echo $startIndex;
	echo "<br>";
	echo "Employee Ref No. => " . $dataArray[$startIndex + 1][0] ;
	
	?>