<?php
$wdgtHardDrives = array("name" => "Hard Drives", "type" => "inline", "function" => "widgetHardDrives();");
$wIndex["wHardDrives"] = $wdgtHardDrives;


function widgetHardDrives() {
	global $drive;
	
	$warningthreshold = 90;
	
	if(!empty($drive)) {
		echo "<table border=\"0\" id=\"harddrives\">\n";
		echo "\t<col id=\"col-disk\" />\n";
		echo "\t<col id=\"col-capacity\" />\n";
		echo "\t<col id=\"col-remaining\" />\n";
		echo "\t<col id=\"col-progress\" />\n";
		echo "\t<tr>\n";
		echo "\t\t<th>Disk</th>\n";
		echo "\t\t<th>Size</th>\n";
		echo "\t\t<th>Free</th>\n";
		echo "\t\t<th>Usage</th>\n";
		echo "\t</tr>\n";
		foreach( $drive as $drivelabel => $drivepath) {
			echo "\t<tr>\n";
			echo "\t\t<td>".$drivelabel."</td>\n";
			echo "\t\t<td>".ByteSize(disk_total_space($drivepath))."</td>\n";
			echo "\t\t<td>".ByteSize(disk_free_space($drivepath))."</td>\n";
			echo "\t\t<td><div class=\"progressbar\"><div class=\"progress".((disk_used_percentage($drivepath) > $warningthreshold) ? " warning" : "")."\" style=\"width:".(disk_used_percentage($drivepath))."%\"></div><div class=\"progresslabel\">".sprintf("%u", disk_used_percentage($drivepath))."%</div></div></td>\n";
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	}
}
?>

<?php

function ByteSize($bytes) 
    {
    $size = $bytes / 1024;
    if($size < 1024)
        {
        $size = number_format($size, 1);
        $size .= ' KB';
        } 
    else 
        {
        if($size / 1024 < 1024) 
            {
            $size = number_format($size / 1024, 0);
            $size .= ' MB';
            } 
        else if ($size / 1024 / 1024 < 1024)  
            {
            $size = number_format($size / 1024 / 1024, 0);
            $size .= ' GB';
            } 
        
            else if ($size / 1024 / 1024 / 1024 < 1024)  
            {
            $size = number_format($size / 1024 / 1024/ 1024, 1);
            $size .= ' TB';
            } 
        }
    return $size;
    }

// Returns '19.28mb'
//print ByteSize('20211982');

?>