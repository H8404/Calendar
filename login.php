<!DOCTYPE html>
<?php
session_start();
require_once('db-init.php');
 
if (isset($_GET['username']) AND isset($_GET['password'])) {
 
   $user = $_GET['username'];
   $password = $_GET['password'];
   
   $sql = "SELECT ID,username,password,firstname
            FROM users
            WHERE username = :user AND password = md5(:password)";
       
    $stmt = $db->prepare($sql);
    $stmt->execute(array($user, $password));
       
    if ($stmt->rowCount() == 1) {
		$result = $stmt -> fetch();
		$_SESSION['islogged'] = true;
        $_SESSION['name'] = $result ["firstname"];
		$_SESSION['userid'] = $result ["ID"];
        header("Location: http://" . $_SERVER['HTTP_HOST']
                                    . dirname($_SERVER['PHP_SELF']) . '/'
                                    . "index.php");
        exit;
    } else {
        $errmsg = '<div class="errmsg">Username or password is wrong!</div>';
    }
}
?>
<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Poiret+One|Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style2.css">
	</head>
	<body>
		<div id="container">
			<div id="main">
				<div id="login">
					<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
						<?php
						if ($errmsg != '')echo $errmsg;
						?>
						<div id="text">
							<p>Username: </p>
							<p>Password: </p>
						</div>
						<div id="textfield">
							<input type="text" name="username"/><br>
							<input type="password" name="password"/><br>
						</div>
						<div id="button">
							<input type="submit" name="login" value="OK"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>