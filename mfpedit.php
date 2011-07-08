<html>
  <head>
    <title>Media Front Page</title>
	  <link rel="shortcut icon" href="favicon.ico" />
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	  <link rel="stylesheet" type="text/css" href="css/widget.css" />
	  <link rel="stylesheet" type="text/css" href="css/front.css" />
    <link rel="stylesheet" type="text/css" href="css/static_widget.css" />
    <link rel="stylesheet" type="text/css" href="css/footer.css" />
<?php 
  include "nav.php"; 
	require_once "config.php";
?>
    <script language="javascript" type="text/javascript" src="js/editArea/edit_area_compressor.php?plugins"></script>
    <script language="javascript" type="text/javascript">
	    editAreaLoader.init({
		    id : "textarea_1",		  // textarea id
		    syntax: "php",		     	// syntax to be used for highgliting
		    start_highlight: true		// to display with highlight mode on start-up
	    });
	  </script>
  </head>
  <body>
    <center>
      <div style="width:90%; height:95%;" align="center" class="widget">
        <div class="widget-head"><h3>MediaFrontPage File Editor</h3></div>
	      <div id="footer">
	        <ul>
          <?php
          if(isset($_GET['p'])){
            echo '<li><a href="#" onclick="document.getElementById(\'save_file\').click();">Save</a></li>
                  <li><a href="#" onclick="window.location.reload();">Cancel</a></li>';
          } else {
            echo '<li>NO FILE SELECTED. PLEASE SELECT A FILE TO EDIT.</li>'; 
          }
          ?>
          </ul>
          <ul style="float: left;">
            <li><a href="mfpedit.php?p=config.php">Configuration</a></li>
            <li><a href="mfpedit.php?p=layout.php">Layout</a></li>
          </ul>
        </div>
<?php
// set file to read
$filename='';
if(isset($_GET['p'])){
	$filename = $_GET['p'];
}
// open file
if($fh = @fopen($filename, "r")){
  // read file contents
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  // close file
  fclose($fh);
  // print file contents
  if(isset($_POST['save_file']) && $_POST['save_file']) {
    $savecontent = stripslashes($_POST['savecontent']);
	  $fp = @fopen($filename, "w");
	  if ($fp) {
		  fwrite($fp, $savecontent);
		  fclose($fp);
		  echo '<script>
		          alert("Successfully saved '.$filename.'");
		          window.location.reload();
		        </script>';
	  }
  }
  $fp = @fopen($filename, "r");
  $loadcontent = fread($fp, filesize($filename));
  $lines = explode("\n", $loadcontent);
  $count = count($lines);
  $filename = htmlspecialchars($loadcontent);
  fclose($fp);
  $line = '';
  for ($a = 1; $a < $count+1; $a++) {
	  $line .= "$a\n";
  }
?>
        <form method=post action="<?php echo $_SERVER['REQUEST_URI'] ?>" >
          <textarea id="textarea_1" name="savecontent" style="padding:0; margin:0; width:100%; height:85%;"><?php echo $loadcontent ?></textarea>
          <input type="submit" id="save_file" name="save_file" value="Save" style="display: none;">
        </form>
<?php
}
?>
      </div>
    </center>
    <?php include "footer.php"; ?>
  </body>
</html>