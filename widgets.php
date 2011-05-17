<?php
require_once "functions.php";

class widget {
	function __construct($widget_init, $widgetfile) {
			$this->Id 		= $widget_init['Id'];
			$this->Child 	= $widget_init['Child'];
			$this->File 	= $widgetfile;
			$this->Type 	= $widget_init['Type'];
			$this->Block 	= $widget_init['Block'];
			$this->Title 	= $widget_init['Title'];
			$this->Parts 	= $widget_init['Parts'];
			$this->HeaderFunction = $widget_init['HeaderFunction'];
			$this->Function = $widget_init['Function'];
			$this->Call 	= $widget_init['Call'];
			$this->Loader 	= $widget_init['Loader'];
			$this->Interval = $widget_init['Interval'];
			$this->Stylesheet = $widget_init['Stylesheet'];
			$this->Script 	= $widget_init['Script'];
			$this->Section 	= $widget_init['Section'];
			$this->Position = $widget_init['Position'];
	}
	public $Id;
	public $Child;
	public $File;
	public $Type;
	public $Block;
	public $Title;
	public $Parts;
	public $HeaderFunction;
	public $Function;
	public $Call;
	public $Loader;
	public $Interval;
	public $Stylesheet;
	public $Script;
	public $Section;
	public $Position;
	public $Class;
	public $MobileTitle;
	public $MobileHeader;
	public $MobileFunction;
	public $MobileSection;
	public $MovilePosition;
	public $MobileClass;

	public function addWidget() {
			// Open the database
		try {   $db = new PDO('sqlite:settings.db');

			// Create the database if it doesn't exist
			$db->exec("CREATE TABLE Widgets (Id TEXT PRIMARY KEY, Child BOOLEAN, File TEXT, Type TEXT, Parts TEXT, Block TEXT, Title TEXT, Function TEXT, Call TEXT, Loader TEXT, Interval INTEGER, HeaderFunction TEXT, Stylesheet TEXT, Script TEXT, Section INTEGER, Position INTEGER, Display TEXT)");

			// Prepare the SQL Statement
			$sql = "INSERT INTO Widgets (Id, Child, File, Type, Block, Title, Parts, HeaderFunction, Function, Call, Loader, Interval, Stylesheet, Script, Section, Position) VALUES (:Id, :Child, :File, :Type, :Block, :Title, :Parts, :HeaderFunction, :Function, :Call, :Loader, :Interval, :Stylesheet, :Script, :Section, :Position);";
			$q = $db->prepare($sql);

			// Add widget to database
			$q->execute(array(	':Id'=>$this->Id, 
						':Child'=>$this->Child,
						':File'=>$this->File,
						':Type'=>$this->Type, 
						':Block'=>$this->Block, 
						':Title'=>$this->Title, 
						':Parts'=>serialize($this->Parts), 
						':HeaderFunction'=>$this->HeaderFunction, 
						':Function'=>$this->Function, 
						':Call'=>$this->Call, 
						':Loader'=>$this->Loader, 
						':Interval'=>$this->Interval, 
						':Stylesheet'=>$this->Stylesheet, 
						':Script'=>$this->Script, 
						':Section'=>$this->Section, 
						':Position'=>$this->Position));
			
		} catch(PDOException $e) {
			print 'Exception : '.$e->getMessage();	
		}

		// Close the database connection
		$db = NULL;
	}		
	public function getWidget() {

			// Open the database
		try {	$db = new PDO('sqlite:settings.db');

			//Fetch into an PDOStatement object			
			$request = $db->prepare("SELECT * FROM Widgets WHERE Id='".$this->Id."'");
			$request->execute();

			// Into array
			$widget = $request->fetch(PDO::FETCH_ASSOC);

			// Close the database connection 
   			$db = null;

		} catch(PDOException $e) {
			print 'Exception : '.$e->getMessage();	
		}
		return $widget;
	}
	public function updateWidget($column, $value) {

			// Open the database
		try {	$db = new PDO('sqlite:settings.db');

			// Replace value in specified column for this widget
			$request = $db->prepare("UPDATE Widgets SET $column='$value' WHERE Id='".$this->Id."'");
			$request->execute();

   			// Close the database connection 
    			$db = null;

		} catch(PDOException $e) {
			print 'Exception : '.$e->getMessage();	
		}
	}
	public function renderWidgetHeaders($directory) {
		global $DEBUG;
		//Support the Widget "stylesheet", "headerfunction", "headerinclude", "script" properties
		if (!empty($this->Type)) {
			switch ($this->Type) {
				case "ajax":
					echo "\t\t<script type=\"text/javascript\" language=\"javascript\">\n";
					
					$loader = (!empty($this->Loader)) ? $this->Loader : "ajaxPageLoad('".$this->Call."', '".$this->Block."');"; 
					if($this->Interval > 0) {
						echo "\t\t\tvar ".$this->Block."_interval = setInterval(\"".$loader."\", ".$this->Interval.");\n";
					}
					echo "\t\t\t".$loader."\n";
					echo "\t\t</script>\n";
					break;
				case "mixed":
					//echo $this->Parts;
					break;
			}
		}
		if(!empty($this->Stylesheet) && (strlen($this->Stylesheet) > 0)) {
			echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$directory."/".$this->Stylesheet."\" />\n";
		}
		if(!empty($this->Script) && (strlen($this->script) > 0)) {
			echo "\t\t<link type=\"text/javascript\" language=\"javascript\ src=\"".$directory."/".$this->Script."\" />\n";
		}
		if(!empty($this->HeaderInclude) && (strlen($this->HeaderInclude) > 0)) {
			echo "\t\t".$this->HeaderInclude."\n";
		}
		if(!empty($this->HeaderFunction) && (strlen($this->HeaderFunction) > 0)) {
			if($DEBUG) { echo "\n<!-- Calling Function:".$this->HeaderFunction." -->\n"; }
			eval($this->HeaderFunction);
		}
	}
	function renderWidget() {
		global $DEBUG;
	
		switch ($this->Type) {
			case "inline":
				if($DEBUG) { echo "\n<!-- Calling Function:".$this->Function." -->\n"; }
				eval($this->Function);
				echo "\n";
				break;
			case "ajax":
				echo "\n\t\t\t<div id=\"".$this->Block."\"></div>\n";
				break;
			case "header":
				//Support header only widgets.
				break;
			case "mixed":
				//mixed widget
				break;
			default:	
				if(!empty($this)) {
					echo "\n\n<strong>INVALID WIDGET SPECIFIED (".$this->Block.")</strong>\n<pre>".print_r($this)."</pre>\n";
				}
				break;
		}
	}						
}
function getAllWidgets() {
		// Open the database
	try {	$db = new PDO('sqlite:settings.db');

		// Fetch into an PDOStatement object			
		$request = $db->prepare("SELECT * FROM Widgets ORDER BY Section ASC, Position ASC");
		$request->execute();

		// Into array
		$widgets = $request->fetchAll();

  		// Close the database connection 
    		$db = null;

	} catch(PDOException $e) {
		print 'Exception : '.$e->getMessage();	
	}
	return $widgets;
}
?>
