<!-- displaying the details of friends -->
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
		if (mysqli_query($link, $sql)) {
		} 
		else {
		    die('Error creating table: ' . mysqli_error($link));
		}

		$username = test_input($_POST['username']);
		$phone = test_input($_POST['username']);

		function test_input($data) {
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}

		$sqlu = "SELECT * FROM details WHERE username = '".$username."'";
		$resultsu = mysqli_query($link, $sqlu);

		$sqlp = "SELECT * FROM details WHERE phone = '".$phone."'";
		$resultsp = mysqli_query($link, $sqlp);

		if(mysqli_num_rows($resultsu) === 0 && mysqli_num_rows($resultsp) === 0) {
			echo "<script>
					window.location.href='findfriend.html';
					alert('Username or Phone Number does not exist...');
				  </script>";
			exit;
		}

		$flagu = 0;
		$flagp = 0;

		while($result = mysqli_fetch_array($resultsu)) {
			if($result['username'] == $username) {
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
			while($result = mysqli_fetch_array($resultsp)) {
				if($result['phone'] == $phone) {
					$GLOBALS['flagp'] = 1;
					?>
					<table border="2px solid black">
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

	?>
	<a href="startpage.html"><button class="choose">Homepage</button></a>
	<a href="findfriend.html"><button class="choose">Find Friend</button></a>
	<a href="updateform.html"><button class="choose">Update</button></a>
</body>