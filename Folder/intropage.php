<?php

session_start();

if(!isset($_SESSION["session_Email"])):
	header("location:login.php");
else:
	?>
	<?php
	include("includes/connection.php");
	$em = $_SESSION["session_Email"];
	$query =mysqli_query($con,"SELECT * FROM visitor WHERE Email='".$em."'");
	$numrows=mysqli_num_rows($query);
	if($numrows==0) {
		$query =mysqli_query($con,"SELECT * FROM librarian WHERE Email='".$em."'");
		$numrows=mysqli_num_rows($query);
	}

	if($numrows!=0)
	{
		while($row=mysqli_fetch_assoc($query))
		{
			$dbEmail=$row['Name'];
		}
	}
	?>

	
	<?php include("includes/header.php"); ?>
	<div id="welcome">
		<h2>Ласкаво просимо, <span><?php echo $dbEmail;?> </span>!</h2>
		<p>Перейти на <a href="page/main.php">Головну</a>.</p>
		<p><a href="logout.php">Вийти</a> із системи</p>
	</div>
	
	<?php include("includes/footer.php"); ?>
	
<?php endif; ?>
