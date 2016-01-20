<html>
<head>
<title>insert data in database using PDO(php data object)</title>

</head>
<body>

<div id="main">

<h1>Insert data into database using PDO</h1>
<div id="login">
<h2>Student's Form</h2>
<hr/>
<form action="" method="post">
<label>Username:</label>
<input type="text" name="stu_name" id="name" required="required" placeholder=" "/><br /><br />
<label>Password:</label>
<input type="password" name="stu_password" id="email" required="required" placeholder=" "/><br/><br />
<label>Confrim Password:</label>
<input type="password" name="stu_password2" id="email" required="required" placeholder=" "/><br/><br />
<label>Role :</label>
<input type="text" name="stu_role" id="role" required="required" placeholder=" "/><br/><br />

<input type="submit" value=" Submit " name="submit"/><br />
</form>
</div>

<hr/>
<form action="" method="post">
<label>First Name :</label>
<input type="text" name="stu_Fname" id="name" required="required" placeholder=" "/><br /><br />
<label>Last Name:</label>
<input type="text" name="stu_Lname" id="email" required="required" placeholder=" "/><br/><br />
<label>Insurence Company :</label>
<input type="text" name="stu_Insure" id="email" required="required" placeholder=" "/><br/><br />
<label>Date last visted :</label>
<input type="text" name="stu_Date" id="role" required="required" placeholder=" "/><br/><br />

<input type="submit" value=" Submit " name="submit2"/><br />
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


</body>
</html>