

<?php include("../includes/header.php"); ?>
<div class="container mlogin">
	<div id="login">
		<h1>Бібліотека</h1>
		<form action="" id="main" method="post"> 
			<p><a href="visitor.php" class="button"id="buttonmain"><span>Читач</span></a></p>
			<p><a href="book.php" class="button" id="buttonmain"><span>Книжки</span></a></p>
			<p><a href="borrowbook.php" class="button" id="buttonmain"><span>Книжки у використанні</span></a></p>
			<p><a href="category.php" class="button" id="buttonmain"><span>Жанри</span></a></p> 
			<p><a href="librarian.php" class="button" id="buttonmain"><span>Бібліотекарі</span></a></p>
		</form>
		<p><a class="logout" href="../logout.php">Вийти із системи</a></p>
	</div>
</div>

<?php include("../includes/footer.php"); ?>	
	