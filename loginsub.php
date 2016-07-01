<!-- Displaying the details of the logged in person -->
<link type="text/css" rel="stylesheet" href="loginsubcss.css" />
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
			$sql = 'CREATE DATABASE ' . DB_NAME;
			$db_selected = mysql_select_db(DB_NAME, $link);
			if (mysql_query($sql, $link)) {
			} else {
			    die('Error creating database: ' . mysql_error());
			}
		}

		$sql = "CREATE TABLE IF NOT EXISTS `details` (
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
		$phone = test_input($_POST['username']);
		$password = $_POST['password'];

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

		if(mysql_num_rows($resultsu) === 0 && mysql_num_rows($resultsp) === 0) {
			echo "<script>
					window.location.href='loginform.php';
					alert('Username or Phone Number does not exist...');
				  </script>";
			exit;
		}

		$flagu = 0;
		$flagp = 0;

		while($result = mysql_fetch_array($resultsu)) {
			if(password_verify($password, $result['password'])) {
				$GLOBALS['flagu'] = 1;
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
							<td><?php echo $result['username'] ?></td>
						</tr>
						<tr>
							<td><?php echo "Profile Picture" ?></td>
							<td><img src="<?php echo $result['profilepic'] ?>" style="width: 100px; height: 100px" /></td>
						</tr>
						<tr>
							<td><?php echo "Email" ?></td>
							<td><?php echo $result['email'] ?></td>
						</tr>
						<tr>
							<td><?php echo "Phone Number" ?></td>
							<td><?php echo $result['phone'] ?></td>
						</tr>
					</tbody>
				</table>
				<?php break;
			}
		}
		if($GLOBALS['flagu'] == 0) {
			while($result = mysql_fetch_array($resultsp)) {
				if(password_verify($password, $result['password'])) {
					$GLOBALS['flagp'] = 1;
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
								<td><?php echo $result['username'] ?></td>
							</tr>
							<tr>
								<td><?php echo "Profile Picture" ?></td>
								<td><img src="<?php echo $result['profilepic'] ?>" style="width: 100px; height: 100px" /></td>
							</tr>
							<tr>
								<td><?php echo "Email" ?></td>
								<td><?php echo $result['email'] ?></td>
							</tr>
							<tr>
								<td><?php echo "Phone Number" ?></td>
								<td><?php echo $result['phone'] ?></td>
							</tr>
						</tbody>
					</table>
					<?php break;
				}
			}
		}

		if($flagu === 0 && $flagp === 0) {
			echo "<script>
					window.location.href='loginform.php';
					alert('Username/Phone No. and Password do not match...');
				  </script>";
			exit;
		}

	?>
	<a href="findfriend.php"><button class="choose">Find Friend</button></a>
	<a href="startpage.php"><button class="choose">Back</button></a>
	<a href="updateform.php"><button class="choose">Update</button></a>
</body>