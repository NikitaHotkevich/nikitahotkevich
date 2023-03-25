<?php

$dsn = 'mysql:host=localhost;dbname=library';
$username = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {

    $message = 'Not Connected '.$ex->getMessage();
    
}

$bookId  = '';
$bookName = '';
$numberOfPages = '';
$author = '';
$categoryId = '';
$categoryName = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = trim($_POST['bookId']);
    $posts[1] = trim($_POST['bookName']);
    $posts[2] = trim($_POST['numberOfPages']);
    $posts[3] = trim($_POST['author']);
    $posts[4] = trim($_POST['categoryId']);
    $posts[5] = trim($_POST['categoryName']);
    
    return $posts;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $message = 'Enter The User Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT b.*, c.categoryName FROM book b,category c WHERE b.bookId = :bookId AND c.categoryId = b.categoryId;');
        $searchStmt->execute(array(
            ':bookId'=> htmlspecialchars($data[0]),
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $bookId = $user[0];
                $bookName = $user[1];         
                $numberOfPages = $user[2];                 
                $author = $user[3];              
                $categoryId = $user[4];
                $categoryName = $user[5];
            }
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3])|| empty($data[4]))
    {
        $message = 'Enter The User Data To Insert';
    }  else {

        $insertStmt = $con->prepare('INSERT INTO book (categoryId,bookName,author,numberOfPages) VALUES(:categoryId,:bookName,:author,:numberOfPages)');
        $insertStmt->execute(array(
            ':bookName'=> htmlspecialchars($data[1]),
            ':numberOfPages'  => htmlspecialchars($data[2]),            
            ':author'  => htmlspecialchars($data[3]),            
            ':categoryId'=> htmlspecialchars($data[4])
        ));
        
        if($insertStmt)
        {
            $message = 'Data Inserted';
        }
        
    }
}

//Update Data

if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3])|| empty($data[4]))
    {
        $message = 'Enter The User Data To Update';
    }  else {

        $updateStmt = $con->prepare('UPDATE book SET categoryId = :categoryId, bookName = :bookName, author = :author, numberOfPages = :numberOfPages WHERE bookId = :bookId');
        $updateStmt->execute(array(
            ':bookId'=> htmlspecialchars($data[0]),
            ':bookName'=> htmlspecialchars($data[1]),
            ':numberOfPages'  => htmlspecialchars($data[2]),            
            ':author'  => htmlspecialchars($data[3]),            
            ':categoryId'=> htmlspecialchars($data[4])

        ));
        
        if($updateStmt)
        {
            $message = 'Data Updated';
        }
        
    }
}

// Delete Data

if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $message = 'Enter The User ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM book WHERE bookId = :bookId');
        $deleteStmt->execute(array(
            ':bookId'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $message = 'User Deleted';
        }
        
    }
}

// Reload Data

if(isset($_POST['reload']))
{
    $data = getPosts();
    if(empty($data[1]))
    {
        $message = 'Enter The User Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT categoryId, categoryName FROM category WHERE categoryId = :categoryId;');
        $searchStmt->execute(array(
            ':categoryId'=> htmlspecialchars($data[4]),
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $bookId = $data[0];
                $bookName = $data[1];
                $numberOfPages = $data[2]; 
                $author = $data[3];               
                $categoryId = $user[0];
                $categoryName = $user[1];
            }
        }
        
    }
}
?>


<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>

<?php

session_start();

if(!isset($_SESSION["session_Email"])):
    header("location:login.php");
else:
    ?>

    <?php include("../includes/header.php"); ?>
    <div class="container mlogin">
        <div id="login">
            <form action="book.php" method="POST">

                <input type="number" name="bookId" min="1" placeholder="ID book" value="<?php echo $bookId;?>"><br><br>
                <input type="text" name="bookName" placeholder="bookName" value="<?php echo $bookName;?>"><br><br>
                <input type="text" name="author" placeholder="author" value="<?php echo $author;?>"><br><br>
                <input type="number"  min="1" name="numberOfPages" placeholder="numberOfPages" value="<?php echo $numberOfPages;?>"><br><br>
                <input type="number" min="1" style="width: 71%" name="categoryId" placeholder="id category" value="<?php echo $categoryId;?>"><input class="input__button" type="submit" id="buttonmain1" name="reload" value="Reload"><br><br>
                <input type="text" name="categoryName" placeholder="categoryName" value="<?php echo $categoryName;?>"><br><br>

                <input class="input__button" type="submit" id="buttonmain1" name="insert" value="Insert">
                <input class="input__button" type="submit" id="buttonmain1" name="update" value="Update">
                <input class="input__button" type="submit" id="buttonmain1" name="delete" value="Delete">
                <input class="input__button" type="submit" id="buttonmain1" name="search" value="Search">
                <br><br>
                <p><a href="main.php" class="button"><span>Повернутися</span></a></p>

            </form>
        </div>
    </div>
    <?php include("../includes/footer.php"); ?>    

    <?php endif; ?> 