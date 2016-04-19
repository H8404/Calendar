<!DOCTYPE html>
<?php
require_once('db-init.php');
if(isset($_POST['signup'])){
	$msg = "";
	$password = $_POST['password'];
	$passwordagain = $_POST['passwordagain'];
	$username = $_POST['username'];
	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	if($password == "" || $passwordagain == "" || $username == "" || $fname == "" || $lname == "" || $email == ""){
		$msg = "Fields can't be empty!";
	}else{
		$sql = "SELECT * FROM users WHERE username = :user";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':user', $username);
		$stmt->execute();
		if ($stmt->rowCount() > 0){
			$msg = "Username already exsists!";
		}
		else{
			if(strlen($password) >= 6){
				if($password === $passwordagain){
					try{
						$firstname   = isset($_REQUEST['firstname'])   ? $_REQUEST['firstname']   : '';
						$lastname = isset($_REQUEST['lastname']) ? $_REQUEST['lastname'] : '';
						$username  = isset($_REQUEST['username'])  ? $_REQUEST['username']  : '';
						$correctPassword  = isset($_REQUEST['password'])  ? $_REQUEST['password']  : '';
						$email  = isset($_REQUEST['email'])  ? $_REQUEST['email']  : '';;
						$sql = "INSERT INTO users (username,password,firstname,lastname,email) VALUES(:f1,md5(:f2),:f3,:f4,:f5)";
			 
						$stmt = $db->prepare($sql);
						$stmt->execute(array(':f1' => $username, ':f2' => $correctPassword, ':f3' => $firstname, ':f4' => $lastname, ':f5' => $email));
						header("Location: http://" . $_SERVER['HTTP_HOST']
								. dirname($_SERVER['PHP_SELF']) . '/'
								. "index.php");
						exit;
					}catch(PDOException $e){
						echo $sql . "<br>" . $e->getMessage();
					}
				}else{
					$msg = "Passwords didn't match!";
				}
			}else{
				$msg = "Password must contain at least 6 characters!";
			}
		}
	}
}
?>
<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Poiret+One|Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
		<title>Sign up</title>
		<link rel="stylesheet" type="text/css" href="style2.css">
	</head>
	<body>
		<div id="container">
			<div id="main">
				<div id="signup">
					<?php
					if ($msg != '')echo $msg;
					?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
						<div id="text2">
							<p>Firstname: </p>
							<p>Lastname: </p>
							<p>Email: </p>
							<p>Username: </p>
							<p>Password: </p>
							<p>Password again: </p>
						</div>
						<div id="textfield2">
							<input type="text" name="firstname"/><br>
							<input type="text" name="lastname"/><br>
							<input type="email" name="email"/><br>
							<input type="text" name="username"/><br>
							<input type="password" name="password"/><br>
							<input type="password" name="passwordagain"/><br>
						</div>
						<div id="button">
							<input type="submit" name="signup" value="OK"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>