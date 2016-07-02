<!-- registering the user and displaying his details -->
<link type="text/css" rel="stylesheet" href="regissubcss.css" />
<body background="images/background.jpg">
	<?php
		define('DB_NAME', 'userdetail');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_HOST', 'localhost');

		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if($link->connect_errno) {
			die('Error connecting ...' . mysqli_error($link));
		}
		
		$db_selected = mysqli_select_db($link, DB_NAME);
		if(!$db_selected) {
			$sql = 'CREATE DATABASE ' . DB_NAME;	/* creating database if it doesn't already exists */
			if (mysqli_query($link, $sql)) {
			} else {
			    die('Error creating database: ' . mysqli_error($link));
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
		if (mysqli_query($link, $sql)) {
			} else {
			    die('Error creating table: ' . mysqli_error($link));
			}

		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);
		$password = password_hash($password,PASSWORD_BCRYPT, array( 'cost' => 12)); /*hashing password*/
		$profilepic = $_FILES['profilepic'];
		$email = test_input($_POST['email']);
		$phone = test_input($_POST['phone']);

		function test_input($data) { /*preventing sql injection*/
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}

		$sqlu = "SELECT * FROM details WHERE username = '".$username."'"; /* to check for repetition of username, phone, email */
		$resultsu = mysqli_query($link, $sqlu);

		$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
		$resultsp = mysqli_query($link, $sqlp);

		$sqle = "SELECT * FROM details WHERE email = '".$email."'";
		$resultse = mysqli_query($link, $sqle);

		if(mysqli_num_rows($resultsu) != 0) {
			echo "<script>
					window.location.href='regisform.html';
					alert('Username already exists...');
				  </script>";
			exit;
		}
		else if(mysqli_num_rows($resultsp) != 0) {
			echo "<script>
					window.location.href='regisform.html';
					alert('Phone Number already exists...');
				  </script>";
			exit;
		}
		else if(mysqli_num_rows($resultse) != 0) {
			echo "<script>
					window.location.href='regisform.html';
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
			mysqli_query($link, $sql);
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
	<a href="startpage.html"><button class="choose">Back</button></a>
	<a href="findfriend.html"><button class="choose">Find Friend</button></a>
	<a href="updateform.html"><button class="choose">Update</button></a>

	<?php
		
		mysqli_close($link);
	?>
</body>