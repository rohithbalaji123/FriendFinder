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
			if($result['username'] == $username) {
				$GLOBALS['flagu'] = 1;
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
							<td><?php echo $result['username'] ?></td>
						</tr>
						<tr>
							<td><?php echo "Profile Picture" ?></td>
							<td><img src="<?php echo $result['profilepic'] ?>" style="width: 50px; height: 50px" /></td>
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
				if($result['phone'] == $phone) {
					$GLOBALS['flagp'] = 1;
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
								<td><?php echo $result['username'] ?></td>
							</tr>
							<tr>
								<td><?php echo "Profile Picture" ?></td>
								<td><img src="<?php echo $result['profilepic'] ?>" style="width: 50px; height: 50px" /></td>
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

	?>
	<a href="startpage.php"><button>Back</button></a>