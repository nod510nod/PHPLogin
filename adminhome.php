<?php 
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) && $role!="admin"){
      header('Location: index.php?err=2');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Najee University Hospital</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">Najee University Hospital</a>
        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><?php echo $_SESSION['sess_username'];?></a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container homepage">
      <div class="row">
         <div class="col-md-3"></div>
            <div class="col-md-6 welcome-page">
              <h2>This is Admin area.</h2>
              <br />
              <br />
            </div>
        </div>
    </div>   

          <div id="main" class="col-sm-2 .col-md-3">
            <h3>Add Accounts</h3>
            <form action="" method="post">
            <label>Username:</label>
            <input type="text" name="stu_name" id="name" required="required" placeholder=" "/><br /><br />
            <label>Password:</label>
            <input type="password" name="stu_password" id="email" required="required" placeholder=" "/><br/><br />
            <label>Confrim Password:</label>
            <input type="password" name="stu_password2" id="email" required="required" placeholder=" "/><br/><br />
            <label>Role :</label>
            <input type="text" name="stu_role" id="role" required="required" placeholder=" "/><br/><br />

            <input type="submit" value=" Submit " name="submit" class="btn btn-success"/><br />
            </form>
          </div>

          <div class="col-sm-5 .col-md-6" style=" padding-left: 75px;">
            <h3>Add Patience</h3>
            <form action="" method="post" >
            <label>First Name :</label>
            <input type="text" name="stu_Fname" id="name" required="required" placeholder=" "/><br /><br />
            <label>Last Name:</label>
            <input type="text" name="stu_Lname" id="email" required="required" placeholder=" "/><br/><br />
            <label>Insurence Company :</label>
            <input type="text" name="stu_Insure" id="email" required="required" placeholder=" "/><br/><br />
            <label>Date last visted :</label>
            <input type="text" name="stu_Date" id="role" required="required" placeholder=" "/><br/><br />
          
            <input type="submit" value=" Submit " name="submit2" class="btn btn-success"/><br />
</div>

</form>
</div>



</div>
<?php 

require 'database-config.php';

if(isset($_POST["submit"])){


try {

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
$sql = "INSERT INTO users (username, password, role)
VALUES ('".$_POST["stu_name"]."','".$_POST["stu_password"]."','".$_POST["stu_role"]."')";
if ($_POST['stu_password']!= $_POST['stu_password2'])
 {
     echo("Oops! Password did not match! Try again. ");
 }
else if ($dbh->query($sql)) {
echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
}
else{
echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
}

$dbh = null;
}
catch(PDOException $e)
{
echo $e->getMessage();
}
} 

require 'database-config.php';


if(isset($_POST["submit2"])){


try {

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
$sql = "INSERT INTO myguests (firstname, lastname, insurance, lastCheck)
VALUES ('".$_POST["stu_Fname"]."','".$_POST["stu_Lname"]."','".$_POST["stu_Insure"]."','".$_POST["stu_Date"]."')";
if ($dbh->query($sql)) {
echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
}
else{
echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
}

$dbh = null;
}
catch(PDOException $e)
{
echo $e->getMessage();
}

}
?>


<?php
require 'database-config.php';
echo "<h3>View Curent Patience</h3>";
echo "<table style='border: solid 1px black;'>";
  echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
} 

try {
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $dbh->prepare("SELECT id, firstname, lastname FROM MyGuests"); 
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
         echo $v;
     }
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
$dbh = null;
echo "</table>";
?>   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
