<!-- form for registering -->
<!DOCTYPE html>
<html>
<head>
	<title>User Details</title>
	<link type="text/css" rel="stylesheet" href="regisformcss.css" />
</head>
<body background="images/background.jpg">
	<form method="post" action="regissub.php" enctype="multipart/form-data">
		<fieldset>
			<legend>Enter Details</legend>
		Username:<br>
		<input type="text" name="username" required><br>
		Password:<br>
		<input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>
		Profile Picture:<br>
		<input type="file" name="profilepic" accept="image/*" required><br>
		Email:<br>
		<input type="email" name="email" required><br>
		Phone No:<br>
		<input type="number" name="phone" min="1000000000" max="9999999999" required><br>
		<input type="submit" value="Submit" class="choose">
		</fieldset>
	</form>
	<a href="startpage.php"><button id="back">Back to Homepage</button></a>
</body>
</html>