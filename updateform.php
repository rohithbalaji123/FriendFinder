<!-- Form for updating the details -->
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		form{
			color: #ffffff;
			font-weight: bold;
			font-size: 20px;
			font-family: cursive;
			position: relative;
			margin: 20px;
			width: 20%;
			left: 35%;
			top: 50px;
		}
		.choose{
			display: inline-block;
			height: 40px;
			width: 100px;
			top: 10px;
			margin: 20px 0px 20px 20px;
			text-align: center;
			position: relative;
			border-radius: 5px;
			background-color: #FFFF00;
			color: black;
			font-weight: bold;
			font-size: 20px;
			border: 0;
			box-shadow: 3px 3px 3px #607D8B;
		}

		.choose:hover {
			background-color: #3F51B5;
		}

		#back{
			display: inline-block;
			height: 60px;
			width: 150px;
			text-align: center;
			margin: 5px 3px;
			position: relative;
			top: 150px;
			left: 40%;
			margin: 0px 50px 0px 20px;
			border-radius: 5px;
			background-color: #FFFF00;
			border: 0;
			color: white;
			box-shadow: 3px 3px 3px #607D8B;
			font-weight: bold;
			font-size: 20px;
			color: #000000;
		}
		#back:hover {
			background-color: #3F51B5;
		}

		input {
			margin: 10px 5px;
		}
	</style>
	<title>User Details</title>
</head>
<body background="images/background.jpg">
	<form method="post" action="updatesub.php" enctype="multipart/form-data">
		<fieldset>
			<legend>Enter Old Details</legend>
		Old Username/Phone no.:<br>
		<input type="text" name="usernameold" required><br>
		Old Password:<br>
		<input type="password" name="passwordold" required><br>
		</fieldset>
		<fieldset>
		Username:<br>
		<legend>Enter New Details</legend>
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
	<a href="startpage.php"><button id="back">Back</button></a>
</body>
</html>