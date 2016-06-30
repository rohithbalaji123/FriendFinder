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

		$usernameold = test_input($_POST['usernameold']);
		$phoneold = test_input($_POST['usernameold']);
		$passwordold = $_POST['passwordold'];

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

		$sqlu = "SELECT * FROM details WHERE username = '".$usernameold."'";
		$resultsu = mysql_query($sqlu);

		$sqlp = "SELECT * FROM details WHERE phone = '".$phoneold."'";
		$resultsp = mysql_query($sqlp);

		if(mysql_num_rows($resultsu) === 0 && mysql_num_rows($resultsp) === 0) {
			echo "<script>
					window.location.href='updateform.php';
					alert('Username or Phone Number does not exist...');
				  </script>";
			exit;
		}

		$flagu = 0;
		$flagp = 0;

		while($result = mysql_fetch_array($resultsu)) {
			if(password_verify($passwordold, $result['password'])) {
				$GLOBALS['flagu'] = 1;
				$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
				$resultsu = mysql_query($sqlu);

				$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
				$resultsp = mysql_query($sqlp);

				$sqle = "SELECT * FROM details WHERE email = '".$email."'";
				$resultse = mysql_query($sqle);

				if(mysql_num_rows($resultsu) != 0 && $result['username'] != $username) {
					echo "<script>
							window.location.href='updateform.php';
							alert('Username already exists...');
						  </script>";
					exit;
				}
				else if(mysql_num_rows($resultsp) != 0 && $result['phone'] != $phone) {
					echo "<script>
							window.location.href='updateform.php';
							alert('Phone Number already exists...');
						  </script>";
					exit;
				}
				else if(mysql_num_rows($resultse) != 0 && $result['email'] != $email) {
					echo "<script>
							window.location.href='updateform.php';
							alert('Email already exists...');
						  </script>";
					exit;
				}

				$temp_name = $_FILES["profilepic"]["tmp_name"];
				$image_name = $_FILES["profilepic"]["name"];
				$target_path = "images/".$image_name;
				if(move_uploaded_file($temp_name, $target_path)) {
					$sql = "UPDATE details SET username='$username', password='$password', profilepic='$target_path', email='$email',
							 phone='$phone'";

					if(!mysql_query($sql)) {
						die("Error". mysql_error());
					}
				}
				else {
					echo "Error uploading profile picture...";
				}
				break;
			}
		}
		if($GLOBALS['flagu'] == 0) {
			while($result = mysql_fetch_array($resultsp)) {
				if(password_verify($passwordold, $result['password'])) {
					$GLOBALS['flagp'] = 1;
					$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
					$resultsu = mysql_query($sqlu);

					$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
					$resultsp = mysql_query($sqlp);

					$sqle = "SELECT * FROM details WHERE email = '".$email."'";
					$resultse = mysql_query($sqle);

					if(mysql_num_rows($resultsu) != 0 && $result['username'] != $username) {
						echo "<script>
								window.location.href='updateform.php';
								alert('Username already exists...');
							  </script>";
						exit;
					}
					else if(mysql_num_rows($resultsp) != 0 && $result['phone'] != $phone) {
						echo "<script>
								window.location.href='updateform.php';
								alert('Phone Number already exists...');
							  </script>";
						exit;
					}
					else if(mysql_num_rows($resultse) != 0 && $result['email'] != $email) {
						echo "<script>
								window.location.href='updateform.php';
								alert('Email already exists...');
							  </script>";
						exit;
					}

					$temp_name = $_FILES["profilepic"]["tmp_name"];
					$image_name = $_FILES["profilepic"]["name"];
					$target_path = "images/".$image_name;
					if(move_uploaded_file($temp_name, $target_path)) {
						$sql = "UPDATE details SET username='$username', password='$password', profilepic='$target_path', email='$email',
								 phone='$phone'";

						if(!mysql_query($sql)) {
							die("Error". mysql_error());
						}
					}
					else {
						echo "Error uploading profile picture...";
					}
					break;
				}
			}
		}

		if($flagu === 0 && $flagp === 0) {
			echo "<script>
					window.location.href='updateform.php';
					alert('Username/Phone No. and Password do not match...');
				  </script>";
			exit;
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