<!-- updating the database and displaying it -->
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
			$sql = 'CREATE DATABASE ' . DB_NAME;
			if (mysqli_query($link, $sql)) {
			} else {
			    die('Error creating database: ' . mysqli_error($link));
			}
		}

		$usernameold = test_input($_POST['usernameold']);
		$phoneold = test_input($_POST['usernameold']);
		$passwordold = $_POST['passwordold'];

		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);
		$password = password_hash($password,PASSWORD_BCRYPT, array( 'cost' => 12));
		$profilepic = $_FILES['profilepic'];
		$email = test_input($_POST['email']);
		$phone = test_input($_POST['phone']);

		function test_input($data) {
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}

		$sqlu = "SELECT * FROM details WHERE username = '".$usernameold."'";
		$resultsu = mysqli_query($link, $sqlu);

		$sqlp = "SELECT * FROM details WHERE phone = '".$phoneold."'";
		$resultsp = mysqli_query($link, $sqlp);

		if(mysqli_num_rows($resultsu) === 0 && mysqli_num_rows($resultsp) === 0) {
			echo "<script>
					window.location.href='updateform.html';
					alert('Username or Phone Number does not exist...');
				  </script>";
			exit;
		}

		$flagu = 0;
		$flagp = 0;

		while($result = mysqli_fetch_array($resultsu)) {
			if(password_verify($passwordold, $result['password'])) {
				$GLOBALS['flagu'] = 1;
				$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
				$resultsu = mysqli_query($link, $sqlu);

				$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
				$resultsp = mysqli_query($link, $sqlp);

				$sqle = "SELECT * FROM details WHERE email = '".$email."'";
				$resultse = mysqli_query($link, $sqle);

				if(mysqli_num_rows($resultsu) != 0 && $result['username'] != $username) {
					echo "<script>
							window.location.href='updateform.html';
							alert('Username already exists...');
						  </script>";
					exit;
				}
				else if(mysqli_num_rows($resultsp) != 0 && $result['phone'] != $phone) {
					echo "<script>
							window.location.href='updateform.html';
							alert('Phone Number already exists...');
						  </script>";
					exit;
				}
				else if(mysqli_num_rows($resultse) != 0 && $result['email'] != $email) {
					echo "<script>
							window.location.href='updateform.html';
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
					mysqli_query($link, $sql);
				}
				else {
					echo "Error uploading profile picture...";
				}
				break;
			}
		}
		if($GLOBALS['flagu'] == 0) {
			while($result = mysqli_fetch_array($resultsp)) {
				if(password_verify($passwordold, $result['password'])) {
					$GLOBALS['flagp'] = 1;
					$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
					$resultsu = mysqli_query($link, $sqlu);

					$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
					$resultsp = mysqli_query($link, $sqlp);

					$sqle = "SELECT * FROM details WHERE email = '".$email."'";
					$resultse = mysqli_query($link, $sqle);

					if(mysqli_num_rows($resultsu) != 0 && $result['username'] != $username) {
						echo "<script>
								window.location.href='updateform.html';
								alert('Username already exists...');
							  </script>";
						exit;
					}
					else if(mysqli_num_rows($resultsp) != 0 && $result['phone'] != $phone) {
						echo "<script>
								window.location.href='updateform.html';
								alert('Phone Number already exists...');
							  </script>";
						exit;
					}
					else if(mysqli_num_rows($resultse) != 0 && $result['email'] != $email) {
						echo "<script>
								window.location.href='updateform.html';
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
						mysqli_query($link, $sql);
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
	<table border="2px solid #ffffff">
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
	<a href="startpage.html"><button class="choose">Homepage</button></a>
	<a href="findfriend.html"><button class="choose">Find Friend</button></a>
	<a href="updateform.html"><button class="choose">Update</button></a>
</body>