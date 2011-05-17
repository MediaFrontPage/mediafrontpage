<?php

$widget_init = array(	'Id' 			=> "wExample",
			'Child'			=> "false",
			'Type' 			=> "inline", 
			'Title' 		=> "Example Widget", 
			'Function' 		=> "widgetExample();",
			'HeaderFunction'=> "", 
			'Stylesheet' 	=> "",
			'Section' 		=> 1, 
			'Position' 		=> 3,
			'Parts'			=> "",
			'Block' 		=> "",  
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		    );
function widgetExample() {
	echo "<p>Hello World</p>";
}

?>
