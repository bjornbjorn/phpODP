<?

	// the $searchstring variable in the amazon.com url is replaced with what the user searched for
	$amazon_id = "radikal";
	$max_chars_display = 20;	// max number of characters to display when the user searches
	$max_words_display = 4;		// max num words to display downwards
	$max_word_length = 10;		// max length of each word displayed
		
	$amazon_books = "http://www.amazon.com/exec/obidos/external-search/?mode=books&keyword=$searchstring&tag=$amazon_id";
	$amazon_music = "http://www.amazon.com/exec/obidos/external-search/?mode=music&keyword=$searchstring&tag=$amazon_id";
	$amazon_video = "http://www.amazon.com/exec/obidos/external-search/?mode=vhs&keyword=$searchstring&tag=$amazon_id";

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
<table border="0" width="600"  bgcolor="#000080">
  <tr>
    <td width="100%" bgcolor="#0000FF">
      <p align="center"><font color="#FFFFFF"><b>In Association with Amazon.com</b></font></td>
  </tr>
  <tr>
    <td width="100%">
      <table border="0" width="100%"  bgcolor="#FFFFFF">
        <tr>
          <td width="33%" valign="top">
                <div align="center"><b>Books</b><br>
                Books on <a href="<?=$amazon_books?>"><?=$search_string_display?></a></div>
          </td>
          <td width="33%" valign="top">
                <div align="center"><b>Music</b><br>
                Music on <a href="<?=$amazon_music?>"><?=$search_string_display?></a></div>
          </td>
          <td width="34%" valign="top">
                <div align="center"><b>Videos</b><br>
                Videos on <a href="<?=$amazon_video?>"><?=$search_string_display?></a></div>          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
<br>