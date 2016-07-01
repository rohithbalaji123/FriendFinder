	<?php
		error_reporting(0);
		define('DB_NAME', 'userdetails');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_HOST', 'localhost');

		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$link) {
			die("Connection failed ". mysql_error());
		}

		$db_selected = mysql_select_db(DB_NAME, $link);
		if(!$db_selected) {
			die("Database error:". mysql_error());
		}

		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);
		$password = password_hash($password,PASSWORD_BCRYPT, array( 'cost' => 12));
		$profilepic = $_POST['profilepic'];
		$email = test_input($_POST['email']);
		$phone = test_input($_POST['phone']);

		function test_input($data) {
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}

		$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
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

		$temp_name = $_FILES["profilepic"]["tmp_name"];
		$image_name = $_FILES["profilepic"]["name"];
		$target_path = "images/".$image_name;
		if(move_uploaded_file($temp_name, $target_path)) {
			$sql = "INSERT INTO details (username, password, profilepic, email, phone) 
					VALUES ('$username', '$password', '$target_path', '$email', '$phone')";

			if(!mysql_query($sql)) {
				die("Error". mysql_error());
			}
		}
		else {
			echo "Error uploading profile picture...";
		}

	?>
	<table>
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
				<td><img src="<?php echo $target_path ?>" style="width: 50px; height: 50px" /></td>
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
	<a href="startpage.php"><button>Back</button></a>
	<a href="findfriend.php"><button>Find Friend</button></a>

	<?php
		
		mysql_close();
	?>