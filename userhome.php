<?php 
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) && $role!="user"){
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
          <a class="navbar-brand">Najee University Hospital</a>
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
              <h2>This is User area.</h2>
            </div>

            <?php
            require 'database-config.php';

            echo "<table style='margin: auto; width: 60% border: solid 1px black;padding: 10px'>";
              echo "<tr><th>Firstname</th><th>Lastname</th><th>Insurance Company</th><th>Last Date Visited</th></tr>";

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
                 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $stmt = $dbh->prepare("SELECT firstname, lastname, insurance, lastCheck  FROM MyGuests"); 
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

          <div class="col-md-3"></div>
        </div>
    </div>    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
