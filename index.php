<?
 $db = mysql_connect('127.0.0.1:8889', 'root', 'root');
 mysql_select_db('girlDev', $db);

 $sums = mysql_query('SELECT * FROM sumResults WHERE name IS NOT NULL;');

?>
<html>
	<head>
		<title>My PHP Form</title>
	</head>
	<body>
	<!-- TODO: make button larger -->
	<input type="button" value="LoginPage" onclick="window.location='login.php'" style="height:50px; width:90px;"</button><br />
	=========================
	<div id="userNameWrap">
		<form id="loginFrm" name="loginFrm" action="<?=$_SERVER['PHP_SELF'];?>?cmd=lg" method="post">
			<h4><?=$errorMess;?></h4>
			<div class="userNameRow">
				<span class="userClassLeft">User Name:</span><span class="userClassRight"><input name="userName" type="text" class="<?=$aClass;?>" id="userName" value="<? if (!isset($_COOKIE['remMe'])){ echo $_POST['userName'];} else { echo $_COOKIE['remMe']; }?>" size="28" />
				</span>
			</div>
			<div class="userNameRow">
				<span class="userClassLeft">Password:</span><span class="userClassRight"><input name="passWord" type="password" class="<?=$aClass;?>" id="passWord" value="<? if (!isset($_COOKIE['remPass'])){ echo $_POST['passWord'];} else { echo $_COOKIE['remPass']; }?>" size="28" />
				</span>
			</div>
			<div class="userNameRow">
				<span class="userClassLeft">Remember Me:</span><span class="userClassRight"><input name="remMe" type="checkbox" id="remMe" value="1" <?php if(isset($_COOKIE['remMe'])){?>checked<?php } ?>/>
				</span>
				<input class="blueButtonBgClass" name="Submit" type="Submit" value="Submit" />
			</div>
			<div class="userNameRow">
			<div align="center"></div>
			</div>
		</form>
	</div>





	<h1>My Form</h1>
		<form action="calculate.php" method="POST">
			<label for="num1">Number 1:</label>
			<input type="text" name="num1" />
			<label for="num2">Number 2:</label>
			<input type="text" name="num2" />
			<br />
			<label for="name">Your Name:</label>
			<input type="text" name ="myName" />
			<input type="submit" value="Add Numbers" />
		</form>
		<table border="1">
		  <tr>
			  <th>Time</th>
			  <th>Name</th>
			  <th>Sum</th>
		  </tr>
		  <?
		    while($row = mysql_fetch_assoc($sums)){
		    	echo "<tr>
		    	  <td>". $row['time'] ."</td>
		    	  <td>". $row['name'] ."</td>
		    	  <td>". $row['sum'] ."</td>
		    	</tr>";
			}
		  ?>
		</table>
	</body>
</html>