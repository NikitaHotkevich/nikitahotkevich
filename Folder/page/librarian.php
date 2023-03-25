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

$librarianId  = '';
$Name = '';
$DateOfBirth = '';
$PhoneNumber = '';
$Wage = '';
$Email = '';
$Password = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = trim($_POST['librarianId']);
    $posts[1] = trim($_POST['Name']);
    $posts[2] = trim($_POST['DateOfBirth']);
    $posts[3] = trim($_POST['PhoneNumber']);
    $posts[4] = trim($_POST['Wage']);
    $posts[5] = trim($_POST['Email']);
    $posts[6] = trim($_POST['Password']);
    
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

        $searchStmt = $con->prepare('SELECT * FROM librarian WHERE librarianId = :librarianId');
        $searchStmt->execute(array(
            ':librarianId'=> htmlspecialchars($data[0]),
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            } else {

                $librarianId = $user[0];
                $Name = $user[1];
                $DateOfBirth = $user[2];
                $PhoneNumber = $user[3];
                $Wage = $user[4]; 
                $Email = $user[5];           
                $Password = $user[6];
            }
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3])|| empty($data[4])|| empty($data[5])|| empty($data[6]))
    {
        $message = 'Enter The User Data To Insert';
    }  else if(!validateDate($data[2], 'Y-m-d')===TRUE)
    {
        $message = 'Enter correct DateOfBirth';
    }  else if (!filter_var($data[5], FILTER_VALIDATE_EMAIL)) {
      $message = 'Enter The correct E-mail';
  } else {

        $insertStmt = $con->prepare('INSERT INTO librarian (Name,DateOfBirth,PhoneNumber,Wage,Email,Password) VALUES(:Name,:DateOfBirth,:PhoneNumber,:Wage,:Email,:Password)');
        $insertStmt->execute(array(
            ':Name'=> htmlspecialchars($data[1]),
            ':DateOfBirth'=> htmlspecialchars($data[2]),
            ':PhoneNumber'=> htmlspecialchars($data[3]),
            ':Wage'=> htmlspecialchars($data[4]),
            ':Email'  => htmlspecialchars($data[5]),
            ':Password'  => htmlspecialchars($data[6])
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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4])|| empty($data[5])|| empty($data[6]))
    {
        $message = 'Enter The User Data To Update';
    }  else if(!validateDate($data[2], 'Y-m-d')===TRUE)
    {
        $message = 'Enter correct DateOfBirth';
    }  else if (!filter_var($data[5], FILTER_VALIDATE_EMAIL)) {
      $message = 'Enter The correct E-mail';
  } else {

        $updateStmt = $con->prepare('UPDATE librarian SET Name = :Name,DateOfBirth = :DateOfBirth, PhoneNumber = :PhoneNumber, Wage = :Wage, Email = :Email, Password = :Password WHERE librarianId = :librarianId');
        $updateStmt->execute(array(
            ':librarianId'=> htmlspecialchars($data[0]),
            ':Name'=> htmlspecialchars($data[1]),
            ':DateOfBirth'=> htmlspecialchars($data[2]),
            ':PhoneNumber'=> htmlspecialchars($data[3]),
            ':Wage'=> htmlspecialchars($data[4]),
            ':Email'  => htmlspecialchars($data[5]),
            ':Password'  => htmlspecialchars($data[6])

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

        $deleteStmt = $con->prepare('DELETE FROM librarian WHERE librarianId = :librarianId');
        $deleteStmt->execute(array(
            ':librarianId'=> htmlspecialchars($data[0])
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
            <form action="librarian.php" method="POST">

                <input type="number" name="librarianId" min="1" placeholder="ID librarian" value="<?php echo $librarianId;?>"><br><br>
                <input type="text" name="Name" placeholder="Name(Призвіще та ініціали)" value="<?php echo $Name;?>"><br><br>
                <input type="text" name="DateOfBirth" placeholder="DateOfBirth" value="<?php echo $DateOfBirth;?>"><br>
                <p id="p38">+380<input type="text" style="width: 78%" name="PhoneNumber" placeholder="PhoneNumber" value="<?php echo $PhoneNumber;?>"></p>
                <input type="text" name="Email" placeholder="E-mail" value="<?php echo $Email;?>"><br><br>
                <input type="number" name="Wage" placeholder="Wage" value="<?php echo $Wage;?>"><br><br>
                <input type="text" name="Password" placeholder="Password" value="<?php echo $Password;?>"><br><br>

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