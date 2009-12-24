<?
	/*
	 * Version 1.5j - Copyright Bjørn  Børresen (c) BIE.no 2001-2006
	 * This work is licensed under a Creative Commons License, read more about it here:
	 * http://creativecommons.org/licenses/by/1.0/
	 *
	 * Please do not modify outside config section in this script (unless you know what you're doing)
	 * and do not remove the phpODP button (even if you do know what you're doing)
	 *
	 * If you would like to show your support please PayPal money to bjorn|root.no (where you replace the | with an @) :)
	 *
	 * If you want to remove the button link-back to bie.no you need to pay $20 for the
	 * script -- thanks! See more info here: http://www.bie.no/products/phpodp/index.php?i=payment	 
	 *
	 * If you show thumbnails then you need to keep the HTML attribution to Thumbshots,
	 * read more info here: http://www.thumbshots.org/attribution.pxf
	 *
	 * Thanks to the crew at Thumbshots for the great service they provide!
	 *
	 * Please post questions & comments in the phpODP support forum here:
	 * http://www.bie.no/forum/
	 * (please remember to search the forum first to see if the question has been posted before!)
	 *
	 * I'd like the forum to be a community, so if someone answers YOUR question, try to answer the question of someone who
	 * understands less than you! .. If someone like that exists of course :)
	 *
	 */
	

	/*
	 *    CONFIG SECTION ----> EDIT THIS + edit the files in /includes/ to change its look!
	 *    If you have questions visit http://www.bie.no/forum and post them in the phpODP support forum!
	 *
	 */

	$show_thumbnails = true;			// set this to true if you want to show thumbnails
	$browse_cache = true;				// cache user browsing? (will speed up your directory much) - keep this enabled, as it will take a huge load off dmoz's servers.
	$search_cache = false;				// cache user searches as well? - disk space usage will increase
	$cache_timeout = 0;					// seconds passed before updating cache .. 60*60*24*7 = 604800 = 7 days before cache is updated ..
										// set cache_timeout to 0 if you do not want the cache to be updated ever (or when you delete the files manually)
										
	$cache_folder = "cache";			// if you don't want users to be able to browse your cache, change this to something .. strange :)	
	$use_portal_page = true; 			// set this to true if you want to make all links in your directory to go through go.php
	$adult_filter = false;				// block the /Adult/ category and searches listed below? (remember, the open directory contains lots of adult material!)
	$illegalwords = array("xxx",		// if adult_filter (above) is true, then the search words in this array will be blocked 
		"porn", 
		"pussy",
		"tgp");
	
	// English users set this to "en" to show amazon.com link
	// German users set it to "de" to show amazon.de link
	// If you do not want to show the amazon table just leave them blank ("")
	$show_search_sponsor = "";						
	$show_browse_sponsor = "";						

	/**
	 * ODP root URL - this is the url the data will be retreived from.
	 *
	 * Note; some people say they need to change this do http://www.dmoz.org/ to make it work on their php config
	 */
	$rooturl = "http://www.dmoz.org";

	// If you want so use a certain category at the root ..
	// eg. $rootcategory = "/World/Deutsch/"; to show German pages, or "/World/Franais/" to start in the French category
	$rootcategory = "";

	/*
	 *    STOP --- > EDITING BELOW SHOULD NOT BE NECESSARY (but could be if externals are changed)
	 */
	 
	 // This is the string that shows when dmoz is under heavy load. The script will know not to cache this since the original page should be retrieved later on.
	$donotcache = "The Open Directory search is currently under a heavy load. Please try back later.";

	global $myrooturl,$searchstring,$filename,$donotcache;
	$filename = $HTTP_SERVER_VARS['PHP_SELF'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?
	 $sponsor_file_search = "search_sponsor_header.php";	// default
	 if($show_search_sponsor == "de") $sponsor_file_search = "search_sponsor_header_de.php";
	 $sponsor_file_browse = "search_sponsor_header.php";	// default
	 if($show_browse_sponsor == "de") $sponsor_file_browse = "search_sponsor_header_de.php";

	// replacement variables
	$replace = $filename . "?browse=";
	$linkstr = '<a href="';
	$odp_image_path = '/img/';
	$your_image_path = '';
	$search_next = '<a href="search';
	$search_next_replace = '<a href="' . $filename;
	$searchurl = "http://search.dmoz.org/cgi-bin/search?search=";
		
	$startstr = "<table cellspacing";				 // start str to search for on the main page
	$endstr = "</td></tr></table>";					 // end str to search for on the main page
	$startbrws = "<hr>"; // start str to search for when browsing
	$endbrws = '<table width="95%" cellpadding=0';   // end str to search for when browsing
	//	$startsrch = '<font size="+1"><b>Open Directory Sites';					 // will remove categories from search result
	$startsrch = '<CENTER>Search:';					 // start str to search for when searching
	$endsrch = '<TABLE cellpadding=0';				 // end str to search for when searching
	$noresult = 'No sites matching your query were'; // feedback from dmoz.org when no sites are found

	/****************************************************************************
	 * Some useful functions
	 ****************************************************************************/	 
	
	function error_handler($severity, $msg, $filename, $linenum) {

	  switch($severity) {
		  case 8:		// notice
			  break;
		  case 2:
			errorMsg($msg);
		   break;
		  default:
			errorMsg($msg);
			break;
	  }
	}

	/**
	* takes a string of unicode entities and converts it to a utf-8 encoded string
	* each unicode entitiy has the form &#nnn(nn); n={0..9} and can be displayed by utf-8 supporting
	* browsers.  Ascii will not be modified.
	* @param $source string of unicode entities [STRING]
	* @return a utf-8 encoded string [STRING]
	* @access public
	*/
	function utf8Encode ($source) {
	   $utf8Str = '';
	   $entityArray = explode ("&#", $source);
	   $size = count ($entityArray);
	   for ($i = 0; $i < $size; $i++) {
		   $subStr = $entityArray[$i];
		   $nonEntity = strstr ($subStr, ';');
		   if ($nonEntity !== false) {
			   $unicode = intval (substr ($subStr, 0, (strpos ($subStr, ';') + 1)));
			   // determine how many chars are needed to reprsent this unicode char
			   if ($unicode < 128) {
				   $utf8Substring = chr ($unicode);
			   }
			   else if ($unicode >= 128 && $unicode < 2048) {
				   $binVal = str_pad (decbin ($unicode), 11, "0", STR_PAD_LEFT);
				   $binPart1 = substr ($binVal, 0, 5);
				   $binPart2 = substr ($binVal, 5);
			  
				   $char1 = chr (192 + bindec ($binPart1));
				   $char2 = chr (128 + bindec ($binPart2));
				   $utf8Substring = $char1 . $char2;
			   }
			   else if ($unicode >= 2048 && $unicode < 65536) {
				   $binVal = str_pad (decbin ($unicode), 16, "0", STR_PAD_LEFT);
				   $binPart1 = substr ($binVal, 0, 4);
				   $binPart2 = substr ($binVal, 4, 6);
				   $binPart3 = substr ($binVal, 10);
			  
				   $char1 = chr (224 + bindec ($binPart1));
				   $char2 = chr (128 + bindec ($binPart2));
				   $char3 = chr (128 + bindec ($binPart3));
				   $utf8Substring = $char1 . $char2 . $char3;
			   }
			   else {
				   $binVal = str_pad (decbin ($unicode), 21, "0", STR_PAD_LEFT);
				   $binPart1 = substr ($binVal, 0, 3);
				   $binPart2 = substr ($binVal, 3, 6);
				   $binPart3 = substr ($binVal, 9, 6);
				   $binPart4 = substr ($binVal, 15);
		  
				   $char1 = chr (240 + bindec ($binPart1));
				   $char2 = chr (128 + bindec ($binPart2));
				   $char3 = chr (128 + bindec ($binPart3));
				   $char4 = chr (128 + bindec ($binPart4));
				   $utf8Substring = $char1 . $char2 . $char3 . $char4;
			   }
			  
			   if (strlen ($nonEntity) > 1)
				   $nonEntity = substr ($nonEntity, 1); // chop the first char (';')
			   else
				   $nonEntity = '';
	
			   $utf8Str .= $utf8Substring . $nonEntity;
		   }
		   else {
			   $utf8Str .= $subStr;
		   }
	   }
	
	   return $utf8Str;
	}

	/**
	 * urlencode the link
	 */	
	function linkencode($url) {
		$odpurl = urlencode($url);
				
		return str_replace (
			array("%2F", "%26","%3A", "%3F", "%3D", "%2C"),
			array("/","&",":","?","=",",")
			, $odpurl);
	}

	
	/**
	 * Make sure incomming $browse variable is 'clean'
	 */
	function cleanBrowse($browse) {
		if($browse == "/") return "";
		else if($browse[0] != "/") return "";		// browse variable should always start with a slash
		else {
			if(get_magic_quotes_gpc()) {
				return htmlspecialchars(stripslashes($browse));
			} else {
				return htmlspecialchars($browse);
			}
		}
	}	

	/**
	 * Make sure incomming search variable is 'clean'
	 */
	function cleanSearch($search) {
		return strip_tags($search);

	}
	
	/**
	 * Will display an error message to the webmaster
	 */
	function errorMsg( $msg ) {
		echo "<center><table width='300' border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr><td><table width='100%' bgcolor='#CC0033' border='0' cellspacing='4' cellpadding='0'>";
		echo "<tr><td align='center'><font face='Arial' size=3 color='#FFFF00'><b>Attention webmaster:</b></font><br><br>";
		echo "<font face='Arial' size=2 color='#ffffff'>$msg</font>";
		echo "</td></tr></table></td></tr></table></center>";
	}

	/**
	 * Will read data from dmoz, or the local cache (if enabled)
	 */
	function readData( $odpurl, $enable_cache ) {
		global $cache_folder, $cache_timeout;
		
		if($enable_cache) {
			$filename = md5($odpurl);
			$fullpath = $cache_folder."/".$filename;
			
			if(file_exists($fullpath)) { // already cached
				if($cache_timeout == 0) {
					$odpurl = $fullpath;				
				} else {
					$diff = time()-filemtime($fullpath);
					if($diff > $cache_timeout) {
						$savecache = true;
					} else {
						$odpurl = $fullpath;
					}
				}
			} else {
				$savecache = true;
			}
		}
		
		if((@$fp = fopen( $odpurl, "r" )) != false) { 
			$html = join( "", file( $odpurl ) ); 
			fclose ( $fp ); 
			
			if($html != "" && $savecache) {
				if(strpos($html, $donotcache) === false) {			// don't cache if this is the 'ODP under heavy load' message
					if((@$cf = fopen( $fullpath, "w" )) != false) { 
						fwrite($cf, $html);
						fclose( $cf );
					} else {
						errorMsg("Error writing to cache!<br>Make sure the cache folder exists and is writeable by this script (you may also disable the cache)");
					}
				}
			}
					
		} else {
			errorMsg("Error reading data from dmoz. This may be caused by the fact that you do not have access to use fopen() in this way.<br>Or it may be because the dmoz url is incorrect.<br><br>See <a href='http://www.bie.no/forum/index.php?act=ST&f=2&t=53'>discussion here</a> for more info!");
		}
		
		return $html;
	}

	/****************************************************************************
	 * Main script start
	 ****************************************************************************/
	set_error_handler("error_handler");

	$browse = cleanBrowse($HTTP_GET_VARS["browse"]);
    if($rootcategory != "" && $browse == "" && $search == "") $browse = $rootcategory;

    $ver = $HTTP_GET_VARS["ver"];

	$searchstring = $HTTP_POST_VARS["search"];
	if($searchstring == "") $searchstring = $HTTP_GET_VARS["search"];
	$searchstring = cleanSearch($searchstring);
    
	$start = intval($HTTP_GET_VARS["start"]);
	$morecat = htmlspecialchars($HTTP_GET_VARS["morecat"]);


/**
 * Check for adult content ??
 */

if($adult_filter) {
	if( $browse != "") {
		$catarr = explode("/", $browse);
		$i=0;
		while($catarr[$i] == "") $i++;		
		if(strtolower($catarr[$i]) == "adult") {
			include("includes/blocked.php");
			die();
		}
	} else if($searchstring != "") {
		
		if(in_array(strtolower($searchstring), $illegalwords)) {
			include("includes/blocked.php");
			die();
		}
	}
}

if( $browse != "" ) {							// the user is browsing the categories
		include("includes/browse_header.php");

        if($show_browse_sponsor != "") include("includes/" . $sponsor_file_browse);
		
		$browselink = linkencode($rooturl.$browse);
		$html = readData($browselink, $browse_cache);		
		if($html != "") {

			$startpos = strpos( $html, "[ <a" );
			if($startpos != FALSE) $abc = TRUE;
	
			if($abc == FALSE) $startpos = strpos( $html, $startbrws );
			$html = substr( $html, $startpos, strlen($html));
			if($abc == TRUE) $html = "<br><center>" . $html;
		
			$endpos = strpos( $html, $endbrws );
			$html = substr( $html, 0, $endpos );
	
			$html = str_replace( $linkstr . "/", $linkstr . $replace . "/", $html );


/* bug fix by Mark Dickenson 6-12-09
*  removed carriage return - fixed description displayed outside table
*/

			$html = str_replace( '<img src="/img/star.gif" width=15 height=16 alt=""> &nbsp; ' . "\n", '<img src="/img/star.gif" width=15 height=16 alt=""> &nbsp; ' , $html ); 

			$html = str_replace( '<img src="' . $odp_image_path, '<img src="' . $your_image_path, $html );		


			if($show_thumbnails) {
			
				$lines = explode("\n", $html);				
				
				for($i=0; $i<count($lines); $i++) {
					$curline = $lines[$i] ;
		
					if(eregi("<li><a href=\"(.*)\">(.*)</a>(.*).$", $curline, $info)) {
						$url = $info[1];
						$title = $info[2];
						$desc = $info[3];

						if(eregi("(.*)<a", $desc, $descarr)) {
							$senddesc = $descarr[1];
						} else {
							$senddesc =	$desc;
						}
						
						if($use_portal_page) {
							$gourl = "go.php?url=". ($url) ."&title=".  urlencode( strip_tags($title)) ."&desc=". urlencode(strip_tags($senddesc));
						} else {
							$gourl = $url;
						}
											
						if(strpos($url, $HTTP_SERVER_VARS["PHP_SELF"]) === false) {
							echo "<table border='0'><tr><td><img src='http://open.thumbshots.org/image.pxf?url=$url' border='0' onload='if (this.width>50) this.border=1'></td><td>"
							."<li><a href=\"$gourl\">$title</a> - $desc."
							."</td></tr></table>";
						} else {
							echo $curline;
						}						
						
					} else {
						echo $curline;
					}
				}
			} else {
				echo $html;
			}
		} else { // open failed
			include("includes/404.php");
		}

		include("includes/browse_footer.php");
		
	}
	else if( $searchstring != "" ) {					// the user is searching
		$all = $HTTP_POST_VARS["all"];
		$cat = $HTTP_POST_VARS["cat"];
		include("includes/search_header.php");
		if($show_search_sponsor != "" ) include("includes/" . $sponsor_file_search);
		$searchurl = linkencode($searchurl . $searchstring . "&all=$all&cat=$cat" . ($start == "" ? "" : "&start=" . $start ) . ($morecat == "" ? "" : "&morecat=" . $morecat));
			
		$html = readData( $searchurl, $search_cache );
		
		if( strpos( $html, $noresult) != FALSE ) {			// no results found
			include("includes/search_no_result.php");
		} else {

			$startpos = strpos( $html, $startsrch );
			$html = substr( $html, $startpos, strlen($html));
			$endpos = strpos( $html, $endsrch );
			$html = substr( $html, 0, $endpos );

			$html = str_replace( $linkstr . "/", $linkstr . $replace . "/", $html );
			$html = str_replace( "http://dmoz.org", "$filename?browse=", $html );
			$html = str_replace( $search_next, $search_next_replace, $html );
			$html = str_replace(  $filename . '?browse=search?', $filename . '?', $html );
			// remove star.gif completely from search results to fix thumbnails not being displayed
			$html = str_replace( '<img src="/img/star.gif" width=15 height=16 alt="Editor\'s Choice"> &nbsp; ' , '' , $html );
	
			$html = str_replace( '</a>' . "\n", '</a>' , $html ); 
			
			if($show_thumbnails) {
			
				$lines = explode("\n", $html);			
			
				for($i=0; $i<count($lines); $i++) {
					$curline = $lines[$i] ;
						
					if(eregi("<li><a href=\"(.*)\">(.*)</a> - (.*)", $curline, $info)) {
						$url = $info[1];
						$title = $info[2];
						$desc = $info[3];

						if(eregi("(.*)<a", $desc, $descarr)) {
							$senddesc = $descarr[1];
						} else {
							$senddesc = $desc;
						}

						
						if($use_portal_page) {
							$gourl = "go.php?url=". ($url) ."&title=".  urlencode( strip_tags($title)) ."&desc=". urlencode(strip_tags($senddesc));
						} else {
							$gourl = $url;
						}
											
						if(strpos($url, $HTTP_SERVER_VARS["PHP_SELF"]) === false) {
							echo "<table border='0'><tr><td><img src='http://open.thumbshots.org/image.pxf?url=$url' border='0' onload='if (this.width>50) this.border=1'></td><td>"
							."<li><a href=\"$gourl\">$title</a> - $desc."
							."</td></tr></table>";
						} else {
							echo $curline;
						}						
						
					} else {
						echo $curline;
					}
				}
			} else {
				echo $html;
			}

		}
		include("includes/search_footer.php");
	}
	else {		// show main page
		include("includes/main_header.php");

		$html = readData($rooturl, $browse_cache);
		$startpos = strpos( $html, $startstr );
		$html = substr( $html, $startpos, strlen($html));
		$endpos = strpos( $html, $endstr );
		$html = substr( $html, 0, $endpos );


		$html = str_replace( $linkstr , $linkstr . $replace, $html );
		$html = str_replace( '<img src="' . $odp_image_path, '<img src="' . $your_image_path, $html );

		echo $html;

		include("includes/main_footer.php");
	}
?>