<!-- form for loging in -->
<!DOCTYPE html>
<html>
<head>
	<title>User Details</title>
	<link rel="stylesheet" type="text/css" href="loginformcss.css">
</head>
<body background="images/background.jpg">
	<form method="post" action="loginsub.php">
		<fieldset>
		<legend>Enter Details:</legend>
		Username/Phone no.:<br>
		<input type="text" name="username" required><br>
		Password:<br>
		<input type="password" name="password" required><br>
		<input type="submit" value="Login" class="choose">
		</fieldset>
	</form>
	<a href="startpage.php"><button id="back">Back to Homepage</button></a>
</body>
</html>