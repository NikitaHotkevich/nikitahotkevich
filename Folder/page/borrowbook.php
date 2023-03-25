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

$borrowBookId  = '';
$visitorId = '';
$Name = '';
$librarianId = '';
$Name1 = '';
$bookId = '';
$bookName = '';
$dateGiven = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = trim($_POST['borrowBookId']);
    $posts[1] = trim($_POST['visitorId']);
    $posts[2] = trim($_POST['librarianId']);
    $posts[3] = trim($_POST['bookId']);
    $posts[4] = trim($_POST['dateGiven']);
    $posts[5] = trim($_POST['Name']);
    $posts[6] = trim($_POST['Name']);    
    $posts[7] = trim($_POST['bookName']);
    
    return $posts;
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $message = 'Enter The User Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT bb.*, v.Name, l.Name, b.bookName FROM borrowbook bb,librarian l,visitor v,book b WHERE bb.borrowBookId = :borrowBookId AND l.librarianId = bb.librarianId AND v.visitorId = bb.visitorId AND b.bookId = bb.bookId;');
        $searchStmt->execute(array(
            ':borrowBookId'=> htmlspecialchars($data[0]),
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $borrowBookId = $user[0];
                $visitorId = $user[1];
                $librarianId = $user[2];                
                $bookId = $user[3];
                $dateGiven = $user[4];
                $Name = $user[5];
                $Name1 = $user[6];
                $bookName = $user[7];
            }
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2])|| empty($data[3])|| empty($data[4]))
    {
        $message = 'Enter The User Data To Insert';
    }  else if(!validateDate($data[4], 'Y-m-d')===TRUE)
    {
        $message = 'Enter correct dateGiven';
    }  else  {

        $insertStmt = $con->prepare('INSERT INTO borrowbook (visitorId,librarianId,bookId,dateGiven) VALUES(:visitorId,:librarianId,:bookId,:dateGiven)');
        $insertStmt->execute(array(
            ':visitorId'=> htmlspecialchars($data[1]),
            ':librarianId'=> htmlspecialchars($data[2]),
            ':bookId'=> htmlspecialchars($data[3]),
            ':dateGiven'=> htmlspecialchars($data[4])
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
    if(empty($data[0]) || empty($data[1]) || empty($data[2])|| empty($data[3])|| empty($data[4]))
    {
        $message = 'Enter The User Data To Update';
    }  else if(!validateDate($data[4], 'Y-m-d')===TRUE)
    {
        $message = 'Enter correct dateGiven';
    }  else  {

        $updateStmt = $con->prepare('UPDATE borrowbook SET visitorId = :visitorId, librarianId = :librarianId, bookId = :bookId, dateGiven = :dateGiven WHERE borrowBookId = :borrowBookId');
        $updateStmt->execute(array(
            ':borrowBookId'=> htmlspecialchars($data[0]),
            ':visitorId'=> htmlspecialchars($data[1]),
            ':librarianId'=> htmlspecialchars($data[2]),
            ':bookId'=> htmlspecialchars($data[3]),
            ':dateGiven'=> htmlspecialchars($data[4])

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

        $deleteStmt = $con->prepare('DELETE FROM borrowbook WHERE borrowBookId = :borrowBookId');
        $deleteStmt->execute(array(
            ':borrowBookId'=> htmlspecialchars($data[0])
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
    if(empty($data[1]) || empty($data[2])|| empty($data[3]))
    {
        $message = 'Enter The User Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT v.visitorId, v.Name, l.librarianId, l.Name, b.bookId, b.bookName FROM librarian l,visitor v,book b WHERE l.librarianId = :librarianId AND v.visitorId = :visitorId AND b.bookId = :bookId;');
        $searchStmt->execute(array(
            ':visitorId'=> htmlspecialchars($data[1]),
            ':librarianId'=> htmlspecialchars($data[2]),
            ':bookId'=> htmlspecialchars($data[3])
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $borrowBookId = $data[0];
                $visitorId = $user[0];
                $Name = $user[1];
                $librarianId = $user[2];
                $Name1 = $user[3];
                $bookId = $user[4];
                $bookName = $user[5];
                $dateGiven = $data[4];
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
            <form action="borrowbook.php" method="POST">

                <input type="number" min="1" name="borrowBookId" placeholder="ID borrowBook" value="<?php echo $borrowBookId;?>"><br><br>
                <input type="number" min="1" style="width: 71%" name="visitorId" placeholder="id supplier" value="<?php echo $visitorId;?>"><input class="input__button" type="submit" id="buttonmain1" name="reload" value="Reload"><br><br>
                <input type="text" name="Name" placeholder="Name" value="<?php echo $Name;?>"><br><br>
                <input type="number" min="1" style="width: 71%" name="librarianId" placeholder="id worker" value="<?php echo $librarianId;?>"><input class="input__button" type="submit" id="buttonmain1" name="reload" value="Reload"><br><br>
                <input type="text" name="Name" placeholder="Name" value="<?php echo $Name1;?>"><br><br>
                <input type="number" min="1" style="width: 71%" name="bookId" placeholder="id worker" value="<?php echo $bookId;?>"><input class="input__button" type="submit" id="buttonmain1" name="reload" value="Reload"><br><br>
                <input type="text" name="bookName" placeholder="bookName" value="<?php echo $bookName;?>"><br><br>
                <input type="text" name="dateGiven" placeholder="dateGiven(YYYY-MM-DD)" value="<?php echo $dateGiven;?>"><br><br>

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