<?php
require_once "config.php";
require_once "xbmcjsonlib.php";

function to_readable_size($size) {
	switch (true) {
		case ($size > 1000000000000):
			$size /= 1000000000000;
			$suffix = 'Tb';
		break;
		case ($size > 1000000000):  
			$size /= 1000000000;
			$suffix = 'Gb';
		break;
		case ($size > 1000000):
			$size /= 1000000;
			$suffix = 'Mb';   
		break;
		case ($size > 1000):
			$size /= 1000;
			$suffix = 'Kb';
		break;
		default:
		$suffix = 'b';
	}
	return round($size, 0)." ".$suffix;
}
  
function disk_used_space($value) {
	return disk_total_space("$value") - disk_free_space("$value");
}

function disk_used_percentage($value) {
	return round(disk_used_space("$value") / disk_total_space("$value") * 100, 2);
}

function formattimes($input1, $input2) {
	$seconds1 = $input1 % 60;
	$input1 = floor($input1 / 60);
	$minutes1 = $input1 % 60;
	$hours1 = floor($input1 / 60); 

	$seconds2 = $input2 % 60;
	$input2 = floor($input2 / 60);

	$minutes2 = $input2 % 60;
	$hours2 = floor($input2 / 60); 
	
	if($hours1 > 0 || $hours2 > 0) {
		$output1 = str_pad($hours1,2,'0',STR_PAD_LEFT).":";
		$output2 = str_pad($hours2,2,'0',STR_PAD_LEFT).":";
	} else {
		$output1 = "";
		$output2 = "";
	}
	$output1 = $output1.str_pad($minutes1, 2, '0', STR_PAD_LEFT).":".str_pad($seconds1, 2, '0', STR_PAD_LEFT);
	$output2 = $output2.str_pad($minutes2, 2, '0', STR_PAD_LEFT).":".str_pad($seconds2, 2, '0', STR_PAD_LEFT);

	return $output1." - ".$output2;
}

function return_array_code($array, $indent = 1, $quote = "\"") {
	//Example call:
	//$layout_code_string = '$arrLayout = '.return_array_code($arrLayout).";\n";

	$first = true;
	$indentstr = str_repeat("\t", $indent);

	$output = "array(\n\t".$indentstr;

	foreach($array as $key => $value) {
		if($first) {
			$first = false;
		} else {
			$output .= ",\n\t".$indentstr;
		}
		
		if(is_array($value)) {
			$value = return_array_code($value, $indent + 1, $quote);
			$output .= $quote.$key.$quote.' => '.$value;
		} else {
			$output .= $quote.$key.$quote.' => '.$quote.$value.$quote;
		}
	}
	$output .= "\n".$indentstr.")";

	return $output;
}
?>
