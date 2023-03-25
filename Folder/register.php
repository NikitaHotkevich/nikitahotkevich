<?php
$per = '';
include("includes/connection.php");
if(isset($_POST["register"])){
	$per = $_POST['per'];
		if(!empty($_POST['Name']) && !empty($_POST['DateOfBirth']) && !empty($_POST['Email']) && !empty($_POST['PhoneNumber']) && !empty($_POST['Password'])) {
			$Name= htmlspecialchars($_POST['Name']);
			$Email=htmlspecialchars($_POST['Email']);
			$PhoneNumber=htmlspecialchars($_POST['PhoneNumber']);
			$DateOfBirth= htmlspecialchars($_POST['DateOfBirth']);
			$Password=htmlspecialchars($_POST['Password']);
			$Wage=8000;
			if($per == 1) $query=mysqli_query($con,"SELECT * FROM visitor WHERE Email='".$Email."'");
			else if($per == 2) $query=mysqli_query($con,"SELECT * FROM librarian WHERE Email='".$Email."'");
			$numrows=mysqli_num_rows($query);
			if($numrows==0)
			{
				if($per == 1) $sql="INSERT INTO visitor
				(Name, Email, PhoneNumber,DateOfBirth,Password)
				VALUES('$Name','$Email', '$PhoneNumber','$DateOfBirth', '$Password')";
				else if($per == 2) $sql="INSERT INTO librarian
				(Name, Email, PhoneNumber,DateOfBirth,Password,Wage)
				VALUES('$Name','$Email', '$PhoneNumber','$DateOfBirth', '$Password', '$Wage')";
				$result=mysqli_query($con,$sql);
				if($result){
					$message = "Account Successfully Created";
				} else {
					$message = "Failed to insert data information!";
				}
			} else {
				$message = "That Email already exists! Please try another one!";
			}
		} else {
			$message = "All fields are required!";
		}
	}
?>

	<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>


<?php include("includes/header.php"); ?>
<div class="container mregister">
	<div id="login">
		<h1>Реєстрація</h1>
		<form action="register.php" id="registerform" method="post"name="registerform">
			<p><label for="user_login">Призвіще, ініціали *<br>
				<input class="input" id="Name" name="Name"size="32"  type="text" value=""></label></p>
				<p><label for="user_pass">E-mail *<br>
					<input class="input" id="Email" name="Email" size="32"type="email" value=""></label></p>					
					<p><label for="user_pass">Номер телефону +38 0ХХ ХХХХХХХ *<br>
						<input class="input" id="PhoneNumber" name="PhoneNumber"size="9" type="text" value=""></label></p>
						<p ><label for="user_pass">Дата Народження(Формат YYYY-MM-DD)<br>
							<input class="input" id="DateOfBirth" name="DateOfBirth"size="20" type="text" value=""></label></p>
							<p><label for="user_pass">Пароль *<br>
								<input class="input" id="Password" name="Password"size="32"   type="password" value=""></label></p>
								<p id="radio"><label for="user_pass">
									<input type="radio" name="review_type" value="1"  checked> Відвідувач<br>
								<input type="radio" name="review_type" value="2"> Бібліотекар<br>
								</label></p>
								 <input id="per" name="per" type="hidden" value="1">
								<script>
									document.querySelector('#radio').onclick = function(e) {				
										
										console.log(e.target.value);
										$("#per").val(e.target.value);

									}
								</script>

								<p class="regtext" style="color: black; text-align: right;">(* обов'язкові поля)</p>
								<p class="submit"><input class="input__button" id="register" name= "register" type="submit" value="Зареєструватись"></p>
								<p class="regtext">Вже зареєстровані? <a href= "login.php">Введіть ім'я користувача</a>!</p>
							</form>
						</div>
					</div>
					<?php include("includes/footer.php"); ?>