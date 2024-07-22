<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
$CurrentTime = time();
$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
if(isset($_POST["Submit"])){
$UserName = $_POST["Username"];
$Name = $_POST["Name"];
$Password = $_POST["Password"];
$ConfirmPassword = $_POST["ConfirmPassword"];
$Admin = $_SESSION["UserName"];
if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){ 
$_SESSION["ErrorMessage"]= "All fields must be filled out"; 
Redirect_to("Admins.php");
}elseif (strlen($Password)<4){
$_SESSION["ErrorMessage"]="Password should be greater than 3 characters";    
Redirect_to("Admins.php");    
}elseif ($Password !== $ConfirmPassword){    
$_SESSION["ErrorMessage"]= "Password and confirm password should match";
Redirect_to("Admins.php");
}elseif (CheckUserNameExistsOrNot($UserName)){    
    $_SESSION["ErrorMessage"]= "UserName Exists,Try Another One!";
    Redirect_to("Admins.php");
    }else{
    // Query to insert category in DB when everything is fine
    // Query to insert new admin in DB when everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO admins(datetime, username, password, aname, addedby)";
    $sql .= "VALUES(:dateTime, :userName, :password, :aName, :adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':userName', $UserName);
    $stmt->bindValue(':password', $Password);
    $stmt->bindValue(':aName', $Name);
    $stmt->bindValue(':adminName', $Admin);
    $Execute = $stmt->execute();

    
    if ($Execute) {
        $_SESSION["SuccessMessage"] =  "New admin added with the name of ".$Name." Successfully";
        Redirect_to("Admins.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
        Redirect_to("Admins.php");
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style.css">
    <title>Admin page</title>
    <script src="https://kit.fontawesome.com/6592553267.js" crossorigin="anonymous"></script>
</head>
<body>
    <div style="height: 10px; background: #27aae2;"></div>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-secondary">
        <div class="container" >
            <a href="#" class="navbar-brand">Jazebarkara.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="My profile.php" class="nav-link"><i class="fa-solid fa-user text-success"></i> My profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times "></i> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user" style="color:#27aae2;"></i> Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>
    <section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php echo ErrorMessage();
                  echo SuccessMessage(); 
            ?>
            <form class="" action="Admins.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header">
                        <h1>Add New Admin</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span></label>
                            <input class="form-control" type="text" name="Username" id="username" placeholder="Type title here" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name"><span class="FieldInfo">Name:</span></label>
                            <input class="form-control" type="text" name="Name" id="Name" value="">
                            <small class="text-danger text-muted">Optional</small>
                        </div>
                        <div class="form-group">
                            <label for="Password"><span class="FieldInfo">Password:</span></label>
                            <input class="form-control" type="password" name="Password" id="Password" placeholder="Type title here" value="">
                        </div>
                        <div class="form-group">
                            <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password</span></label>
                            <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Type title here" value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>UserName</th>
                            <th>Admin Name</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM admins  ORDER BY id DESC";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $AdminId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $AdminUsername = $DataRows["username"];
                        $AdminName = $DataRows["aname"];
                        $AddedBy = $DataRows["addedby"];
                        $SrNo++;
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($SrNo); ?></td>
                            <td><?php echo htmlentities($DateTime); ?></td>
                            <td><?php echo htmlentities($AdminUsername); ?></td>
                            <td><?php echo htmlentities($AdminName); ?></td>
                            <td><?php echo htmlentities($AddedBy); ?></td>
                            <td><a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
        </div>
    </div>
</section>






        <div style="height: 10px; background: #27aae2;"></div>
        <h1>Basic</h1>
        <footer class="bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="lead text-center">Theme By | Jazeb Aram |<span id="year"></span> &copy; ----All right reserved.</p>
                </div>
                </div>
            </div>
        </footer>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>