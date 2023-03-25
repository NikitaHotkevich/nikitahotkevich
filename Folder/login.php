<?php
session_start();
?> 
<?php
if(isset($_SESSION["session_Email"])){
	// вывод "Session is set"; // в целях проверки
	header("Location: intropage.php");
}

include("includes/connection.php");
if(isset($_POST["login"])){

	if(!empty($_POST['Email']) && !empty($_POST['Password'])) {
		$Email=htmlspecialchars($_POST['Email']);
		$Password=htmlspecialchars($_POST['Password']);
		$query =mysqli_query($con,"SELECT * FROM visitor WHERE Email='".$Email."' AND Password='".$Password."'");
		$numrows=mysqli_num_rows($query);
		if($numrows==0) {
			$query =mysqli_query($con,"SELECT * FROM librarian WHERE Email='".$Email."' AND Password='".$Password."'");
			$numrows=mysqli_num_rows($query);
		}
		$numrows=mysqli_num_rows($query);

		if($numrows!=0)
		{
			while($row=mysqli_fetch_assoc($query))
			{
				$dbEmail=$row['Email'];
				$dbPassword=$row['Password'];
			}
			if($Email == $dbEmail && $Password == $dbPassword)
			{
	// старое место расположения
	//  session_start();
				$_SESSION['session_Email']=$Email;	 
				/* Перенаправление браузера */
				header("Location: intropage.php");
			}
		} else {
	   $message = "Invalid Email or Password!";
		}
	} else {
		$message = "All fields are required!";
	}
}
?>
<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>

<?php include("includes/header.php"); ?>
<div class="container mlogin">
	<div id="login">
		<h1>Вхід</h1>
		<form action="" id="loginform" method="post"name="loginform">
			<p><label for="user_login">Пошта користувача<br>
				<input class="input" id="Email" name="Email"size="20"
				type="text" value=""></label></p>
				<p><label for="user_pass">Пароль<br>
					<input class="input" id="Password" name="Password"size="20"
					type="password" value=""></label></p> 
					<p class="submit"><input class="input__button" name="login" type= "submit" value="Log In"></p>
					<p class="regtext">Ще не зареєстровані?  <a href= "register.php">Реєстрація</a>!</p>
				</form>
			</div>
		</div>
		<?php include("includes/footer.php"); ?>
