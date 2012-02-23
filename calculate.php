<!--write 'php' after the less than sign and question mark to make sure browser interprets it is really php; some users may configure not to recognize php unless the word php is actually there! (may work just fine without it) -->

<?php

//String literals below (single quotes); use double quotes for string interpolation<sp>
  $num1 = $_POST['num1'];
  $num2 = $_POST['num2'];
  $name = $_POST['myName'];

  $error = '';

  if(!is_numeric($num1)) {
     $error .= "Number 1 Should Be a Number.<br />";
  }

  if(!is_numeric($num2)) {
     $error .= "Number 2 Should Be a Number.<br />";
  }

  if($name == '' || $name == null) {
     $error .= "Name Should Not be Blank.";
  }



  function sum($number1, $number2){
  	return $number1 + $number2;
  }

if($error == ''){
    $sum = sum($num1, $num2);
   // use function above instead
   //  $sum = $num1 + $num2;
  
  //always change password not to be root!!!
  //connect to database
  $db = mysql_connect('127.0.0.1:8889', 'root', 'root');
  mysql_select_db('girlDev', $db);

//" are for sql and ' are for php
//must put quotes around string $name; not necessarily needed for $sum being an integer

mysql_query("INSERT INTO sumResults(sum, name) VALUES ($sum, \"$name\");", $db) or die(mysql_error());
//  mysql_query('INSERT INTO sumResults(sum, name) VALUES ("' . $sum . '", "' . $name . '");', $db) or die(mysql_error());
 // mysql_query('INSERT INTO sumResults(name) VALUES ("' . $name . '";', $db) or die(mysql_error());
}

?>


<html>
  <head>
  <title>My Result</title>
  </head>
  <body>
  <? 
    if($error == '') {
      echo "<h1>Your Sum is $sum</h1>";
      echo "<h2>Your Name is $name<h2>";
    }
    else {
      echo "<h1>Error: $error</h1>";
    }
  ?>
  
  <a href="index.php">Try Again</a>
  </body>
</html>







<!-- not really php below, but easiest way to comment entire block; this is a messy way of writing php with all the php starts and stops
<?/*
<html>
  <head>
	<title>My Result</title>
  </head>
	<body>
  <? if($error == '') { ?>
	<!-- semi colon below isn't necessary, just good practice -->
	<h1>Your Sum is <? echo $sum; ?></h1>
  <h2>Your Name is <? echo $name; ?><h2>
  <? }  else {?>
  <h1>Error: <? echo $error; ?></h1>
  <? } ?>
	<a href="index.php">Try Again</a>
	</body>
</html>
*/
?>