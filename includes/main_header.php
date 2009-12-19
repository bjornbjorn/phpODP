<?

// this is the header include for the main page, you can put whatever you want here. 

// Typically a logo and a search box

?>

<title>Open Directory Project</title>
<body onLoad="document.forms[0].search.focus()">
<center>

<h2>Open Directory Project</h2>

<form method=POST action="odp.php">

Search: <input type="text" name="search">

<input type="submit" name="submit" value="Search">

</form>

<hr width=600 size=1>