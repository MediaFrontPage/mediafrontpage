<?PHP
/**
* @desc ConfigMagik - Ini-File Reader and Writer (ConfigKeeper)
* @author BennyZaminga <bzaminga@web.de>
* @date Sat Jul 03 19:52:46 CEST 2004
* @version 0.01 - Sat Jul 03 19:52:46 2004
*     - 1st release
* @version 0.02 - Sun Jul 18 16:04:51 2004
*     - Added listKeys()
*     - Added listSections()
*     - Added toString() [TEXT and HTML -View]
*     - Added Editor to package
*     - Changed PROCESS_SECTIONS to enabled by default
*     - Lacks of SECTIONS_AUTORECOGNITION (comming soon)
* @version 0.03 - Wed Aug 11 01:31:52 2004
*     - Fixed a bug in get()
*     - Added additional code handling PROCESS_SECTIONS more gracefully
*/
class ConfigMagik{
	var $PATH             = null;
	var $VARS             = array();
	var $SYNCHRONIZE      = true;
	var $PROCESS_SECTIONS = true;
	var $PROTECTED_MODE   = true;
	var $ERRORS           = array();

	/**
	* @desc   Constructor of this class.
	* @param  string $path Path to ini-file to load at startup.
	* NOTE:   If the ini-file can not be found, it will try to generate a 
	*         new empty one at the location indicated by path passed to 
	*         constructor-method of this class.
	* @param  bool $synchronize TRUE for constant synchronisation of memory and file (disabled by default).
	* @param  bool $process_sections TRUE or FALSE to enable or disable sections in your ini-file (enabled by default).
	* @return void Returns nothing, like any other constructor-method ¦¬] .
	*/
	function ConfigMagik( $path=null, $synchronize=true, $process_sections=true){
		// check whether to enable processing-sections or not
		if ( isset( $process_sections)) $this->PROCESS_SECTIONS = $process_sections;
		// check whether to enable synchronisation or not
		if ( isset( $synchronize)) $this->SYNCHRONIZE = $synchronize;
		// if a path was passed and file exists, try to load it
		if ( $path!=null) {
			// set passed path as class-var
			$this->PATH = $path;
			if ( !is_file( $path)) {
				// conf-file seems not to exist, try to create an empty new one
				$fp_new = @fopen( $path, 'w', false);
				if ( !$fp_new) {
					$err = "ConfigMagik::ConfigMagik() - Could not create new config-file('$path'), error.";
					array_push( $this->ERRORS, $err);
					die( $err);
				}else{
					fclose( $fp_new);
				}
			}else{
				// try to load and parse ini-file at specified path
				$loaded = $this->load( $path);
				if ( !$loaded) exit();
			}
		}
	}

	/**
	* @desc					  Retrieves the value for a given key.
	* @param  string $key     Key or name of directive to set in current config.
	* @param  string $section Name of section to set key/value-pair therein.
	* NOTE:                   Section must only be specified when sections are used in your ini-file.
	* @return mixed           Returns the value or NULL on failure.
	* NOTE:                   An empty directive will always return an empty string.
	*                         Only when directive can not be found, NULL is returned.
	*/
	function get( $key=null, $section=null){
		// if section was passed, change the PROCESS_SECTION-switch (FIX: 11/08/2004 BennyZaminga)
		if ( $section) $this->PROCESS_SECTIONS = true;
		else           $this->PROCESS_SECTIONS = false;
		// get requested value
		if ( $this->PROCESS_SECTIONS) {
			$value = $this->VARS[$section][$key];
		}else{
			$value = $this->VARS[$key];
		}
		// if value was not found (false), return NULL (FIX: 11/08/2004 BennyZaminga)
		if ( $value===false) {
			return null;
		}
		// return found value 
		return $value;
	}

	/**
	* @desc   Sets the value for a given key (in given section, if any specified).
	* @param  string $key     Key or name of directive to set in current config.
	* @param  mixed  $value   Value of directive to set in current config.
	* @param  string $section Name of section to set key/value-pair therein.
	* NOTE:   Section must only be specified when sections are enabled in your ini-file.
	* @return bool            Returns TRUE on success, FALSE on failure.
	*/
	function set( $key, $value, $section=null){
		// when sections are enabled and user tries to genarate non-sectioned vars, 
		// throw an error, this is definitely not allowed.
		if ( $this->PROCESS_SECTIONS and !$section) {
			$err = "ConfigMagik::set() - Passed no section when in section-mode, nothing was set.";
			array_push( $this->ERRORS, $err);
			return false;
		}
		// check if section was passed
		if ( $section===true) $this->PROCESS_SECTIONS = true;
		// set key with given value in given section (if enabled)
		if ( $this->PROCESS_SECTIONS) {
			$this->VARS[$section][$key] = $value;
		}else{
			$this->VARS[$key]           = $value;
		}
		// synchronize memory with file when enabled
		if ( $this->SYNCHRONIZE) {
			$this->save();
		}
		return true;
	}
	
	/**
	 * @desc   Remove a directive (key and it's value) from current config.
	 * @param  string $key     Name of key to remove form current config.
	 * @param  string $section Optional name of section (if used).
	 * @return bool            Returns TRUE on success, FALSE on failure.
	 */
	function removeKey( $key, $section=null){
		// check if section was passed and it's valid
		if ( $section!=null){
			if ( in_array( $section, array_keys( $this->VARS))==false){
				$err = "ConfigMagik::removeKey() - Could not find section('$section'), nothing was removed.";
				array_push( $this->ERRORS, $err);
				return false;
			}
			// look if given key exists in given section
			if ( in_array( $key, array_keys( $this->VARS[$section]))===false) {
				$err = "ConfigMagik::removeKey() - Could not find key('$key'), nothing was removed.";
				array_push( $this->ERRORS, $err);
				return false;
			}
			// remove key from section
			$pos = array_search( $key, array_keys( $this->VARS[$section]), true);
			array_splice( $this->VARS[$section], $pos, 1);
			return true;
		}else{
			// look if given key exists
			if ( in_array( $key, array_keys( $this->VARS))===false) {
				$err = "ConfigMagik::removeKey() - Could not find key('$key'), nothing was removed.";
				array_push( $this->ERRORS, $err);
				return false;
			}
			// remove key (sections disabled)
			$pos = array_search( $key, array_keys( $this->VARS), true);
			array_splice( $this->VARS, $pos, 1);
			// synchronisation-stuff
			if ( $this->SYNCHRONIZE) $this->save();
			// return
			return true;
		}
	}
	
	/**
	 * @desc   Remove entire section from current config.
	 * @param  string $section Name of section to remove.
	 * @return bool            Returns TRUE on success, FALSE on failure.
	 */
	function removeSection( $section){
		// check if section exists
		if ( in_array( $section, array_keys( $this->VARS), true)===false) {
			$err = "ConfigMagik::removeSection() - Section('$section') could not be found, nothing removed.";
			array_push( $this->ERRORS, $err);
			return false;
		}
		// find position of $section in current config
		$pos = array_search( $section, array_keys( $this->VARS), true);
		// remove section from current config
		array_splice( $this->VARS, $pos, 1);
		// synchronisation-stuff
		if ( $this->SYNCHRONIZE) $this->save();
		// return
		return true;
	}

	/**
	* @desc   Loads and parses ini-file from filesystem.
	* @param  string $path Optional path to ini-file to load.
	* NOTE:   When not provided, path passed to constructor will be used.
	* @return bool Returns TRUE on success, FALSE on failure.
	*/
	function load( $path=null){
		// if path was specified, check if valid else abort
		if ( $path!=null and !is_file( $path)) {
			$err = "ConfigMagik::load() - Path('$path') is invalid, nothing loaded.";
			array_push( $this->ERRORS, $err);
			echo $err;
			return false;
		}elseif ( $path==null){
			// no path was specified, fall back to class-var
			$path = $this->PATH;
		}
		/* 
		 * PHP's own method is used for parsing the ini-file instead of own code. 
		 * It's robust enough ;-)
		 */
		$this->VARS = parse_ini_file( $path, $this->PROCESS_SECTIONS);
		return true;
	}

	/**
	* @desc   Writes ini-file to filesystem as file.
	* @param  string $path Optional path to write ini-file to.
	* NOTE:   When not provided, path passed to constructor will be used.
	* @return bool Returns TRUE on success, FALSE on failure.
	*/
	function save( $path=null){
		// if no path was specified, fall back to class-var
		if ( $path==null) $path = $this->PATH;

		$content  = "";
		
		// PROTECTED_MODE-prefix
		if ( $this->PROTECTED_MODE) {
			$content .= "<?PHP\n; /*\n;\n";
		}
		
		// config-header
		$content .= ";MediaFrontPage Settings";
		$content .= "; Last modified: ".date('d M Y H:i s')."\n";
		
		// check if there are sections to process
		if ( $this->PROCESS_SECTIONS) {
			foreach ( $this->VARS as $key=>$elem) {
				$content .= "[".$key."]\n";
				foreach ( $elem as $key2=>$elem2) {
					$content .= $key2." = \"".$elem2."\"\n";
				}
			}
		}else{
			foreach ( $this->VARS as $key=>$elem) {
				$content .= $key." = \"".$elem."\"\n";
			}
		}
		
		// add PROTECTED_MODE-ending
		if ( $this->PROTECTED_MODE) {
			$content .= "\n;\n; */\n?>\n";	
		}

		// write to file
		if ( !$handle = @fopen( $path, 'w')) {
			$err = "ConfigMagik::save() - Could not open file('$path') for writing, error.";
			array_push( $this->ERRORS, $err);
			return false;
		}
		if ( !fwrite( $handle, $content)) {
			$err = "ConfigMagik::save() - Could not write to open file('$path'), error.";
			array_push( $this->ERRORS, $err);
			return false;
		}else{
			// push a message onto error-stack
			$err = "ConfigMagik::save() - Sucessfully saved to file('$path').";
			array_push( $this->ERRORS, $err);
		}
		fclose( $handle);
		return true;
	}
	
	/**
	 * @desc   Renders this Object as formatted string (TEXT or HTML).
	 * @param  string $output_type Type of desired output. Can be 'TEXT' or 'HTML'.
	 * @return string Returns a formatted string according to chosen output-type.
	 */
	function toString( $output_type='TEXT'){
		// check requested output-type
		if ( strtoupper( $output_type)!=='TEXT' and strtoupper( $output_type)!=='HTML') {
			$err = "ConfigMagik::toString() - Unknown OutputType('$output_type') was requested, falling back to TEXT.";
			array_push( $this->ERRORS, $err);
			$output_type = 'TEXT';
		}
		if ( strtoupper( $output_type) === 'TEXT') {
			// render object as TEXT
			$out  = "";
			ob_start();
			print_r( $this->VARS);
			$out .= ob_get_clean();
			return $out;
		}elseif ( strtoupper( $output_type) === 'HTML'){
			// render object as HTML
			$out  = "<table style='background:#FFEECC;border:1px solid black;' width=60%>\n";
			if ( $this->PROCESS_SECTIONS){
				// render with sections
				$out .= "\t<tr><th style='border:1px solid white;'>Section</th><th style='border:1px solid white;'>Key</th><th style='border:1px solid white;'>Value</th></tr>\n";
				$sections = $this->listSections();
				$num_sections = 0;
				$num_keys     = 0;
				foreach ( $sections as $section){
					$out .= "\t<tr><td style='border:1px solid white;' colspan=3>$section</td></tr>\n";
					$keys = $this->listKeys( $section);
					foreach ( $keys as $key){
						$val  = $this->get( $key, $section);
						$out .= "\t<tr><td>&nbsp;</td><td style='border:1px solid maroon;'>$key</td><td style='border:1px solid brown;'>$val</td></tr>\n";
						$num_keys++;
					}
					$num_sections++;
				}
				// summary of table (with sections)
				$out .= "\t<tr><td style='border:1px solid white;' colspan=3 align=right><code>There are <b>$num_keys keys</b> in <b>$num_sections sections</b>.</code></td></tr>\n";
			}else{
				// render without sections
				$keys     = $this->listKeys();
				$num_keys = 0;
				$out .= "\t<tr><th style='border:1px solid white;'>Key</th><th style='border:1px solid white;'>Value</th></tr>\n";
				foreach ( $keys as $key){
					$val  = $this->get( $key);
					$out .= "\t<tr><td style='border:1px solid maroon;'>$key</td><td style='border:1px solid brown;'>$val</td></tr>\n";
					$num_keys++;
				}
				// summary of table (without sections)
				$out .= "\t<tr><td style='border:1px solid white;' colspan=2 align=right><code>There are <b>$num_keys keys</b>.</code></td></tr>\n";
			}
			
			// close table
			$out .= "</table>";
			return $out;
		}
	}
	
	/**
	 * @desc                   Lists all keys.
	 * @param  string $section Optional section (needed only when using sections).
	 * @return array           Returns a numeric array containing the keys as string.
	 */
	function listKeys( $section=null){
		// check if section was passed
		if ( $section!==null){
			// check if passed section exists
			$sections = $this->listSections();
			if ( in_array( $section, $sections)===false) {
				$err = "ConfigMagik::listKeys() - Section('$section') could not be found.";
				array_push( $this->ERRORS, $err);
				return false;
			}
			// list all keys in given section
			$list = array();
			$all  = array_keys( $this->VARS[$section]);
			foreach ( $all as $possible_key){
				if ( !is_array( $this->VARS[$possible_key])) {
					array_push( $list, $possible_key);
				}
			}
			return $list;
		}else{
			// list all keys (section-less)
			return array_keys( $this->VARS);
		}
	}
	
	/**
	 * @desc   List all sections (if any).
	 * @param  void
	 * @return array Returns a numeric array with all section-names as stings therein.
	 */
	function listSections(){
		$list = array();
		// separate sections from normal keys
		$all  = array_keys( $this->VARS);
		foreach ( $all as $possible_section){
			if ( is_array( $this->VARS[$possible_section])) {
				array_push( $list, $possible_section);
			}
		}
		return $list;
	}
}
?>