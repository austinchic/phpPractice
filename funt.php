<?php
function logOn(){
//remove this after maintenance
//$errorMess = 'Performing Maintenance, Try again later!';
//include $_SERVER['DOCUMENT_ROOT'] . '/form/loginFrm.php';
//return;
if(!isset($_POST['Submit'])){
	if(!isset($_COOKIE['remMe']) && !isset($_COOKIE['remPass'])){
	$errorMess = 'Please Log in your Account!';
	}
	else{
	$errorMess = 'Welcome Back: ' . $_COOKIE['remUser'] . '!';
	}
	$aClass = 'normFormClass';
	include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
}
elseif(isset($_POST['Submit'])){
//clean the strings for injection
$userName = mysql_real_escape_string($_POST['userName']);
$passWord = mysql_real_escape_string($_POST['passWord']);
//empty vars
#################################
### Error Checking ##############
if(empty($userName) && empty($passWord)){
$errorMess = 'Put in Username and Password!';
$aClass = 'errorFormClass' ;
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
}elseif(empty($userName)){
$errorMess = 'Put in Username';
$aClass = 'errorFormClass'; 
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
}elseif(empty($passWord)){
$errorMess = 'Put in Password';
$aClass = 'errorFormClass'; 
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
}else{
//logon part of the function
$matchSql ="select * from regUserTbl";
$matchSql.=" where regUserName = '" . $userName . "'";
$matchSql.=" and regPassWord = '" . $passWord . "'";
$matchSql.=" and regVerified = '0'";
$matchResult = mysql_query($matchSql);
$matchNumRows = mysql_num_rows($matchResult);
if($matchNumRows == 1){
$errorMess = 'Check Email For Instructions on Verification!';
$aClass = 'errorFormClass'; 
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
}else{
//select statement
$sql ="select * from regUserTbl";
$sql.=" where regUserName = '" . $userName . "'";
$sql.=" and regPassWord = '" . $passWord . "'";
$sql.=" and regVerified = '1'";
$totalLogins = 3;
//run the results
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
//if no match put out and error
if($userName != $row['regUserName'] && $passWord != $row['regPassWord']){
if(!isset($_SESSION['attempLog'])){
$_SESSION['attempLog'] = 1;
//echo 'empty';
}elseif(isset($_SESSION['attempLog'])){
//$_SESSION['attempLog'] = $_POST['att']++;
$_SESSION['attempLog']++;
if($_SESSION['attempLog'] == 3){
//echo 'really full';
unset($_SESSION['attempLog']);
$errorMess = 'Recover Lost Password!';
$aClass = 'errorFormClass' ;
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/lostPass.php';
return;
} 
}
//count the login attempts
$remainLogins = $totalLogins - $_SESSION['attempLog']; 
$errorMess = 'No Matches';
//$errorMess.='<span>Attempts Left[' . $remainLogins . ']</span>';
$aClass = 'errorFormClass' ;
include $_SERVER['DOCUMENT_ROOT'] . '/gfl/form/loginFrm.php';
//echo $_SESSION['attempLog'];
#######################################
### end of Error Checking
#######################################
}else{
//create cookie for future logins
if($_POST['remMe'] == 1){
setcookie('remMe' , $_POST['userName'], time()+604800);
setcookie('remPass' , $_POST['passWord'], time()+604800);
setcookie('remUser' , $row['regFirstName'], time()+604800);
//echo 'setcookie';
//return;
}elseif(empty($_POST['remMe'])){
setcookie('remMe' , $_POST['userName'], time()-604800);
setcookie('remPass' , $_POST['passWord'], time()-604800);
setcookie('remUser' , $row['regFirstName'], time()-604800);
}
$_SESSION['userId'] = $row['regUserID'];
$_SESSION['userName'] = $row['regUserName'];
$_SESSION['passWord'] = $row['regPassWord'];
$_SESSION['firstName'] = $row['regFirstName'];
$_SESSION['lastName'] = $row['regLastName'];
//show all the account info
header('location: main.php?cmd=ac');
}//end else
}//end elseif
}
}
}//end function

?>