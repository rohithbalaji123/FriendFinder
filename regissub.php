<link type="text/css" rel="stylesheet" href="regissubcss.css" />
<body background="images/background.jpg">
	<?php
		error_reporting(0);
		define('DB_NAME', 'userdetail');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_HOST', 'localhost');

		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$link) {
			die("Connection failed ". mysql_error());
		}

		$db_selected = mysql_select_db(DB_NAME, $link);
		if(!$db_selected) {
			$sql = 'CREATE DATABASE ' . DB_NAME;		/* creating database if it doesn't already exists */
			if (mysql_query($sql, $link)) {
			} else {
			    die('Error creating database: ' . mysql_error());
			}
		}

		$sql = "CREATE TABLE IF NOT EXISTS `details` ( /* creating table if it doesn't already exists */
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `username` varchar(255) DEFAULT NULL,
				 `password` varchar(255) DEFAULT NULL,
				 `profilepic` varchar(225) DEFAULT NULL,
				 `email` varchar(255) DEFAULT NULL,
				 `phone` varchar(10) DEFAULT NULL,
				 PRIMARY KEY (`id`),
				 UNIQUE KEY `username` (`username`)
				) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1";
		if (mysql_query($sql, $link)) {
			} else {
			    die('Error creating table: ' . mysql_error());
			}

		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);
		$password = password_hash($password,PASSWORD_BCRYPT, array( 'cost' => 12)); /*hashing password*/
		$profilepic = $_POST['profilepic'];
		$email = test_input($_POST['email']);
		$phone = test_input($_POST['phone']);

		function test_input($data) { /*preventing sql injection*/
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}

		$sqlu = "SELECT * FROM details WHERE username = '".$username."'"; /* to check for repetition of username, phone, email */
		$resultsu = mysql_query($sqlu);

		$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
		$resultsp = mysql_query($sqlp);

		$sqle = "SELECT * FROM details WHERE email = '".$email."'";
		$resultse = mysql_query($sqle);

		if(mysql_num_rows($resultsu) != 0) {
			echo "<script>
					window.location.href='regisform.php';
					alert('Username already exists...');
				  </script>";
			exit;
		}
		else if(mysql_num_rows($resultsp) != 0) {
			echo "<script>
					window.location.href='regisform.php';
					alert('Phone Number already exists...');
				  </script>";
			exit;
		}
		else if(mysql_num_rows($resultse) != 0) {
			echo "<script>
					window.location.href='regisform.php';
					alert('Email already exists...');
				  </script>";
			exit;
		}

		$temp_name = $_FILES["profilepic"]["tmp_name"]; /* uploading image in images folder */
		$image_name = $_FILES["profilepic"]["name"];
		$target_path = "images/".$image_name;
		if(move_uploaded_file($temp_name, $target_path)) { /* inserting values in database */
			$sql = "INSERT INTO details (username, password, profilepic, email, phone) 
					VALUES ('$username', '$password', '$target_path', '$email', '$phone')";
		}
		else {
			echo "Error uploading profile picture...";
		}

	?>
	<table border="1px solid #ffffff"> <!-- table to output data from database -->
		<thead>
			<tr>
				<th>Detail</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo "Username" ?></td>
				<td><?php echo $username ?></td>
			</tr>
			<tr>
				<td><?php echo "Profile Picture" ?></td>
				<td><img src="<?php echo $target_path ?>" style="width: 100px; height: 100px" /></td>
			</tr>
			<tr>
				<td><?php echo "Email" ?></td>
				<td><?php echo $email ?></td>
			</tr>
			<tr>
				<td><?php echo "Phone Number" ?></td>
				<td><?php echo $phone ?></td>
			</tr>
		</tbody>
	</table>
	<a href="startpage.php"><button class="choose">Back</button></a>
	<a href="findfriend.php"><button class="choose">Find Friend</button></a>
	<a href="updateform.php"><button class="choose">Update</button></a>

	<?php
		
		mysql_close();
	?>
</body>