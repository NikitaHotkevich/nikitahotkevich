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

$categoryId  = '';
$categoryName = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = trim($_POST['categoryId']);
    $posts[1] = trim($_POST['categoryName']);
    
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

        $searchStmt = $con->prepare('SELECT * FROM category WHERE categoryId = :categoryId');
        $searchStmt->execute(array(
            ':categoryId'=> htmlspecialchars($data[0]),
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $categoryId = $user[0];
                $categoryName = $user[1];
            }
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]))
    {
        $message = 'Enter The User Data To Insert';
    }  else {

        $insertStmt = $con->prepare('INSERT INTO category (categoryName) VALUES(:categoryName)');
        $insertStmt->execute(array(
            ':categoryName'=> htmlspecialchars($data[1]),
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
    if(empty($data[0]) || empty($data[1]))
    {
        $message = 'Enter The User Data To Update';
    }  else {

        $updateStmt = $con->prepare('UPDATE category SET categoryName = :categoryName WHERE categoryId = :categoryId');
        $updateStmt->execute(array(
            ':categoryId'=> htmlspecialchars($data[0]),
            ':categoryName'=> htmlspecialchars($data[1])

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

        $deleteStmt = $con->prepare('DELETE FROM category WHERE categoryId = :categoryId');
        $deleteStmt->execute(array(
            ':categoryId'=> htmlspecialchars($data[0])
        ));
        
        if($deleteStmt)
        {
            $message = 'User Deleted';
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
            <form action="category.php" method="POST">

                <input type="number" name="categoryId" min="1" placeholder="ID category" value="<?php echo $categoryId;?>"><br><br>
                <input type="text" name="categoryName" placeholder="categoryName(Призвіще та ініціали)" value="<?php echo $categoryName;?>"><br><br>

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