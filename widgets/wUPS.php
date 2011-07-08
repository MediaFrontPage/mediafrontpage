<?php
/*##############################################################################
#                          wUPS - UPS Status Monitor                           #
# Description: Using either Apcupsd or NUT you can retrieve and display        #
#              important information regarding your UPS charge, load and       #
#              estimated runtime on battery. All information is updated        #
#              every 15 seconds.                                               #
# Example Config:                                                              #
#     $ups;                                                                    #
#     $ups['UPS1'] = array("type" => "APC", "url" => "localhost:3551");        #
#     $ups['UPS2'] = array("type" => "NUT", "url" => "upsname@localhost");     #
##############################################################################*/
$wdgtUPS = array("name" => "UPS Monitor", "type" => "ajax", "block" => "UPSwrapper", "call" => "widgets/wUPS.php?style=w", "interval" => 15000);
$wIndex["wUPS"] = $wdgtUPS;

// Execute UPS Program
function execProgram ($prog, $arg){
	// Descriptors for proc_open
	$descriptorspec = array(
  		0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   		1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   		2 => array("pipe", "w") // stderr
	);

	$pipes = Array();
	// Run command with arguments
	$process = proc_open($prog." ".trim($arg), $descriptorspec, $pipes);
	// Process the raw information
	if (is_resource($process)) {
    		$output = stream_get_contents($pipes[1]);
    		fclose($pipes[1]);
	}
	// Return output
	return $output;
}
// Retrieve Generic UPS info via NUT
function getNUTInfo($upsurl) {
	// Execute upsc with url as argument
	$ups = execProgram("upsc", $upsurl);

	// Array to hold filtered device details
	$dev = Array();

	$processline = explode("\n", $ups);
	foreach ($processline as $line) {
		$data = explode(":", $line);
		$dev[$data[0]] = trim($data[1]);
	}
	// Most commonly referenced fields from apcaccess status,
	// It will only add to the array if found.
	// Type of cable used
		$dev['cable'] = trim($data['driver.name']);
	// UPS Model Name
		$dev['model']=trim($data['device.model']);
	// UPS Mode from config
		$dev['upsmode'] = trim($data['device.type']);
	// Minimum Battery Charge from config
		$dev['mbattchg'] = trim($data['battery.charge.low']);
	// Current Status of the ups
		$dev['status'] = trim($data['ups.status']);
	// Line Voltage
		$dev['linev'] = trim($data['output.voltage']);
	// Current Load on unit
		$dev['loadpct'] = trim($data['ups.load']);
	// Maximum watts unit supports
		$dev['nompower'] = (trim($data['ups.power.nominal'])/0.576)." Watts";
	// Current Battery Charge
		$dev['bcharge'] = trim($data['battery.charge']);
	// Estimated Time Left if running on batteries.
		$dev['timeleft'] = trim($data['battery.runtime']);
	// Return resutls
	return $dev;
}
// Retrieve APC UPS info via APCUPSD
function getAPCInfo($upsurl) {
	// Execute apcaccess with status and url arguments
	$ups = execProgram("apcaccess", "status ".$upsurl);
	// Array to hold filtered device details
	$dev = Array();
	// Most commonly referenced fields from apcaccess status,
	// It will only add to the array if found.
	// APC Name from config
	if (preg_match('/^UPSNAME\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['name'] = trim($data[1]);
	}
	// Hostname of Computer unit is connected to
	if (preg_match('/^HOSTNAME\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['hostname'] = trim($data[1]);
	}
	// Type of cable used
	if (preg_match('/^CABLE\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['cable'] = trim($data[1]);
	}
	// Apcupsd Version
	if (preg_match('/^VERSION\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['version'] = trim($data[1]);
	}
	// UPS Model Name
	if (preg_match('/^MODEL\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['model']=trim($data[1]);
	}
	// Old APC Model ID code
	if (preg_match('/^APCMODEL\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['apcmodel'] = trim($data[1]);
	}
	// UPS Mode from config
	if (preg_match('/^UPSMODE\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['upsmode'] = trim($data[1]);
	}
	// Minimum Battery Charge from config
	if (preg_match('/^MBATTCHG\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['mbattchg'] = trim($data[1]);
	}
	// Minimum Time Left from config
	if (preg_match('/^MTIMEL\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['mtimel'] = trim($data[1]);
	}
	// Maximum Run Time from config
		if (preg_match('/^MAXTIME\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['maxtime'] = trim($data[1]);
	}
	// Time and Date apcupsd was started
	if (preg_match('/^STARTTIME\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['starttime'] = trim($data[1]);
	}
	// Current Status of the ups
	if (preg_match('/^STATUS\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['status'] = trim($data[1]);
	}
	// Internal Tempature (if available)
	if (preg_match('/^ITEMP\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['temp'] = trim($data[1]);
	}
	// Number of Outages
	if (preg_match('/^NUMXFERS\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['numxfers'] = trim($data[1]);
	}
	// Last Time and Date of Outage
	if (preg_match('/^LASTXFER\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['lastxfer'] = trim($data[1]);
	}
	// Time and Date of last transfer off batteries.
	if (preg_match('/^XOFFBATT\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['xoffbatt'] = trim($data[1]);
	}
	// Line Voltage
	if (preg_match('/^LINEV\s*:\s*(\d*\.\d*)(.*)$/m', $ups, $data)) {
		$dev['linev'] = trim($data[1]);
	}
	// Current Load on unit
	if (preg_match('/^LOADPCT\s*:\s*(\d*\.\d*)(.*)$/m', $ups, $data)) {
		$dev['loadpct'] = trim($data[1]);
	}
	// Battery Voltage
	if (preg_match('/^BATTV\s*:\s*(\d*\.\d*)(.*)$/m', $ups, $data)) {
		$dev['battv'] = trim($data[1]);
	}
	// Maximum watts unit supports
	if (preg_match('/^NOMPOWER\s*:\s*(.*)$/m', $ups, $data)) {
		$dev['nompower'] = trim($data[1]);
	}
	// Current Battery Charge
	if (preg_match('/^BCHARGE\s*:\s*(\d*\.\d*)(.*)$/m', $ups, $data)) {
		$dev['bcharge'] = trim($data[1]);
	}
	// Estimated Time Left if running on batteries.
	if (preg_match('/^TIMELEFT\s*:\s*(\d*\.\d*)(.*)$/m', $ups, $data)) {
		$dev['timeleft'] = trim($data[1]);
	}
	return $dev;
}
// Main widget function
function widgetUPS() {
	global $ups;
	// if battery charge below value warning
	$warningthreshold = 10;
	// No config set skip this
	if (!empty($ups)) {
		echo "<table border=\"0\" id=\"harddrives\">\n";
		echo "\t<col id=\"col-disk\" />\n";
		echo "\t<col id=\"col-capacity\" />\n";
		echo "\t<col id=\"col-remaining\" />\n";
		echo "\t<col id=\"col-progress\" />\n";
		echo "\t<tr>\n";
		echo "\t\t<th>UPS</th>\n";
		echo "\t\t<th>ERT</th>\n";
		echo "\t\t<th>Load</th>\n";
		echo "\t\t<th>Charge</th>\n";
		echo "\t</tr>\n";
		foreach ( $ups as $upssettings => $upsurl) {
			// Using the config properties to determine which program to use
			if ($upsurl['type'] == 'APC') {
				$dev = getAPCInfo($upsurl['url']);
			} elseif ($upsurl['type'] == 'NUT') {
				$dev = getNUTInfo($upsurl['url']);
				$upsname = explode("@", $upsurl);
				$dev['name'] = $upsname[0];
			} else {
				$dev['name'] = "Error";
			}
			// Error check
			if (empty($dev['name'])) {
				$dev['name'] = "Offline";
				$popup = "Offline: Unable to communicate with UPS at ".$upsurl['url'];
			} elseif ($dev['name'] == "Error") {
				$popup = "Error: Please recheck your config as the ups type wasn't found.";
			} else {
				// Popup Information
				if ($dev['hostname']) {
					$popup = "<p>UPS: ".$dev['name']." (".$dev['hostname'].")</p>";
				} else {
					$popup = "<p>UPS: ".$dev['name']."</p>";
				}
				$popup .= "<p>Model: ".$dev['model']." (".$dev['apcmodel'].")</p>";
				$popup .= "<p>UPS Mode: ".$dev['upsmode']."</p>";
				$popup .= "<p>Maximum Watts: ".$dev['nompower']."</p>";
				if ($dev['starttime']) {
					$popup .= "<p>Start Time: ".$dev['starttime']."</p>";
				}
				$popup .= "<p>Status: ".$dev['status']."</p>";
				if ($dev['numxfers']) {
					$popup .= "<p>Outages: ".$dev['numxfers']."</p>";
				}
				if ($dev['lastxfer']) {
					$popup .= "<p>Last Transfer: ".$dev['lastxfer']."</p>";
				}
				if ($dev['xoffbatt']) {
					$popup .= "<p>Last Outage Timestamp: ".$dev['xoffbatt']."</p>";
				}
				$popup .= "<p>Line Voltage: ".$dev['linev']." V</p>";
				$popup .= "<p>Load Percent: ".$dev['loadpct']."%</p>";
				if ($dev['battv']) {
					$popup .= "<p>Battery Volts: ".$dev['battv']." V</p>";
				}
				$popup .= "<p>Battery Charge: ".$dev['bcharge']."%</p>";
				$popup .= "<p>Battery Runtime: ".$dev['timeleft']." mins</p>";
			}
			echo "\t<tr>\n";
			echo "\t\t<td onMouseOver=\"ShowPopupBox('".$popup."');\" onMouseOut=\"HidePopupBox();\">".$dev['name']."</td>\n";
			echo "\t\t<td>".($dev['timeleft'] ? $dev['timeleft']." mins" : "N/A")."</td>\n";
			echo "\t\t<td>".($dev['loadpct'] ? $dev['loadpct']."%" : "N/A")."</td>\n";
			echo "\t\t<td><div class=\"progressbar\"><div class=\"progress".(($dev['bcharge'] < $warningthreshold) ? " warning" : "")."\" style=\"width:".($dev['bcharge'])."%\"></div><div class=\"progresslabel\">".sprintf("%u", $dev['bcharge'])."%</div></div></td>\n";
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	}
}
// On refresh call main function
if (!empty($_GET['style']) && ($_GET['style'] == "w")) {
	require_once "../config.php";
	if ($_GET['style'] == "w") {
?>
<html>
	<head>
		<title>Media Front Page - UPS</title>
		<link rel='stylesheet' type='text/css' href='css/front.css'>
	</head>
	<body>
<?php
		widgetUPS();
?>
	</body>
</html>
<?php
	} else {
		widgetUPS();
	}
}
?>
