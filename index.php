<?php
$inputFileName = "arguments.txt";
$positiveOutput = "positive_results.txt";
$negativeOutput = "negative_results.txt";
$errorOutput = "error_results.txt";
$operation = "/";
$floatDigits = 2;

$positiveResults;
$negativeResults;
$errorResults;

function getFile($fileName) {
	$file = fopen($fileName, "r+") or die("Unable to open such file - {$fileName}!");
	return $file;
}

function createFile($fileName) {
	$file = fopen($fileName, "w") or die("Unable to create such file - {$fileName}!");
	fclose($file);
}

function getFileContent($file) {
	global $inputFileName;
	$fileContent = fread($file, filesize($inputFileName));
	fclose($file);
	return $fileContent;
}

function getLine($file) {
	$raw = fgets($file);
	return $raw;
}

function writeIntoFile($fileName, $text) {
	$file = fopen($fileName, "w") or die("Unable to open/create such file - {$fileName}!");
	fwrite($file, $text);
	fclose($file);
}

function getResult($arguments, $operation) {
	switch ($operation) {
		case '+':
			$result = $arguments[0];
			for ($i = 1; $i < count($arguments); $i++) {
				$result += floatval($arguments[$i]);
			}
			break;

		case '-':
			$result = $arguments[0];
			for ($i = 1; $i < count($arguments); $i++) {
				$result -= floatval($arguments[$i]);
			}
			break;

		case '*':
			$result = $arguments[0];
			for ($i = 1; $i < count($arguments); $i++) {
				$result *= floatval($arguments[$i]);
			}
			break;

		case '/':
			$result = $arguments[0];
			for ($i = 1; $i < count($arguments); $i++) {
				if (floatval($arguments[$i]) == 0) {
					$result = 'error';
				} else {
					$result /= floatval($arguments[$i]);
				}
			}
			break;
		
		default:
			$result = 0;
			break;
	}
	return $result;
}

/*Creating files for outputs*/
createFile($positiveOutput);
createFile($negativeOutput);
createFile($errorOutput);

$file = getFile($inputFileName); // Getting input file
$lineCounter = 1;
while (!feof($file)) { // Until the end of the file
	global $positiveResults, $negativeResults, $errorResults;
	global $lineCounter;

	$line = getLine($file); // Getting a line
	$args = explode(' ', $line); // Spliting line into array

	$result = getResult($args, $operation); // Doing operation between arguments

	if ($result != 'error') {
		echo round($result, $floatDigits).'<br/>';
	}
	
	if ($result > 0) {
		$positiveResults .= round($result, $floatDigits).' ';
	} elseif ($result < 0) {
		$negativeResults .= round($result, $floatDigits).' ';
	} else {
		$errorResults = "Line $lineCounter \n";
	}

	$lineCounter++;
}

// echo $positiveResults.'<br/>';
// echo $negativeResults.'<br/>';
// echo $errorResults.'<br/>';

/* Saving output results to files*/
writeIntoFile($positiveOutput, $positiveResults);
writeIntoFile($negativeOutput, $negativeResults);
writeIntoFile($errorOutput, $errorResults);

?>