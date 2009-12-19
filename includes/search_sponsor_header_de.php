<?
	// the $searchstring variable in the amazon.com url is replaced with what the user searched for
	// modified for Amazon.de, 11.04.2002 by Peter Schuetz, www.PSchuetz.com / www.GewusstWie.ch
	// improved 17.04.2004, thanks to Dirk Benkert, http://www.mygeo.info (who gave me some ideas here:)
	
	/**
	 * This code will display a table with links to Amazon. The search string will be broken into words, with one
	 * word displayed for each line. If the word is longer than $max_word_length it will be cut and padded with "..." at the end.
	 * No more than $max_words_display will be shown (so that the table isn't filled with 100 rows if the user searches for 100 words)
	 */
	
	$amazon_id = "mg0a-21";		// REMEMBER TO SWITCH THIS TO YOUR OWN AMAZON.DE ID ;)
	$max_chars_display = 20;	// max number of characters to display when the user searches
	$max_words_display = 4;		// max num words to display downwards
	$max_word_length = 10;		// max length of each word displayed
	
	$amazon_books = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=books-de&index=blended";
	$amazon_music = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=music";
	$amazon_dvd = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=dvd-de";
	$amazon_video = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=vhs-de";
	$amazon_games = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=video-games-de";
	$amazon_softw = "http://www.amazon.de/exec/obidos/external-search?tag=$amazon_id&keyword=$searchstring&index=ce-de";

	// searchstring replace
	$int_string_length=strlen($searchstring);
	$search_string_display=rawurldecode($searchstring);

	if($int_string_length > $max_chars_display)
	{
		$arr = explode(" ", $search_string_display);
		for($i=0; $i < $arr && $i < 5; $i++) {
			if(strlen($arr[$i]) > $max_word_length) $string .= substr($arr[$i], 0, $max_word_length-4) . "...<br>";
			else $string .= $arr[$i] . "<br>";
		}
		$search_string_display = $string;
	}


?>
<center>
  <table border="0" cellspacing="0" cellpadding="3" width="500px">
    <tr>
      <td>
        <div align="center">In Zusammenarbeit mit <b>Amazon.de</b>: Medien zum Thema</div>
      </td>
    </tr>
    <tr>
      <td>
        <table style="table-layout:fixed" width="550px" border="1" cellspacing="0" cellpadding="3" bordercolor="#000000">

          <tr bgcolor="#BB0000">
            <td style="font-color:white;" width="16%">
              <div style="color:white;" align="center"><b>B&uuml;cher</b></div>
            </td>
            <td  width="16%">
              <div style="color:white;" align="center"><b>Musik</b></div>
            </td>
            <td width="16%">
              <div style="color:white;" align="center"><b>DVD</b></div>
            </td>
            <td width="16%">
              <div style="color:white;" align="center"><b>Videos</b></div>
            </td>
            <td width="16%">
              <div  style="color:white;" align="center"><b>Games</b></div>
            </td>
            <td width="16%">
              <div  style="color:white;" align="center"><b>Software</b></div>
            </td>
          </tr>
          <tr>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_books?>">
                <?=$search_string_display?>
          </a></div>
            </td>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_music?>">
                <?=$search_string_display?>
          </a></div>
            </td>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_dvd?>">
                <?=$search_string_display?>
          </a></div>
            </td>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_video?>">
                <?=$search_string_display?>
          </a></div>
            </td>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_games?>">
                <?=$search_string_display?>
          </a></div>
            </td>
            <td width="16%">
              <div align="center"><a href="<?=$amazon_softw?>">
                <?=$search_string_display?>
          </a></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  </center>
