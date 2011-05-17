<?php

$widget_init = array(	
			'Id' 			=> "wHardDrives", 
			'Child'			=> "false",	
			'Type' 			=> "inline", 
			'Title' 		=> "Hard Drives", 
			'Function' 		=> "widgetHardDrives();",
			'Stylesheet' 	=> "harddrives.css",
			'Section' 		=> 1, 
			'Position' 		=> 1,
			'HeaderFunction'=> "", 
			'Parts'			=> "",
			'Block' 		=> "",  
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		    );

$settings_init['wHardDrives'] =	array(  'drives' =>	array(	
												'label'	=>	'Drives',
												'value' =>	array(	
														'drivepath1' =>	array(	
																'label' 	=> '/',
																'location'	=> '/')
																)
														)
											);

function widgetHardDrives() {
	global $settings;
	
	$warningthreshold = 90;
	
	if(!empty($settings['drives'])) {
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
		$drives = $settings['drives'];
		foreach( $drives as $drive) {
			echo "\t<tr>\n";
			echo "\t\t<td>".$drive['label']."</td>\n";
			echo "\t\t<td>".to_readable_size(disk_total_space($drive['location']))."</td>\n";
			echo "\t\t<td>".to_readable_size(disk_free_space($drive['location']))."</td>\n";
			echo "\t\t<td><div class=\"progressbar\"><div class=\"progress".((disk_used_percentage($drive['location']) > $warningthreshold) ? " warning" : "")."\" style=\"width:".(disk_used_percentage($drive['location']))."%\"></div><div class=\"progresslabel\">".sprintf("%u", disk_used_percentage($drive['location']))."%</div></div></td>\n";
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	}
}
?>
