<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_login();?>
<?php
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName    = $DataRows['aname'];
    $ExistingUserName    = $DataRows['username'];
$ExistingHeadline = $DataRows['aheadline'];
$ExistingBio    = $DataRows['abio'];
$ExistingImage  = $DataRows['aimage'];
}
if(isset($_POST["Submit"])){
    $AName = !empty($_POST["Name"]) ? $_POST["Name"] : $ExistingName;
    $AHeadline = !empty($_POST["Headline"]) ? $_POST["Headline"] : $ExistingHeadline;
    $ABio = !empty($_POST["Bio"]) ? $_POST["Bio"] : $ExistingBio;
    $Image = !empty($_FILES["Image"]["name"]) ? $_FILES["Image"]["name"] : $ExistingImage;
    $Target= "Images/".basename($_FILES["Image"]["name"]);
if (strlen($AHeadline) > 30) {
    $_SESSION["ErrorMessage"] = "Headline should be less than 30 characters";
    Redirect_to("MyProfile.php");
} elseif (strlen($ABio) > 500) {
    $_SESSION["ErrorMessage"] = "Bio should be less than 500 characters";
    Redirect_to("MyProfile.php");
}else{
    global $ConnectingDB;
    if (!empty($_FILES["Image"]["name"])) {
        $sql = "UPDATE admins
                SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                WHERE id='$AdminId'";
    } else {
        $sql = "UPDATE admins
                SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
                WHERE id='$AdminId'";
    }
    $Execute = $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
if ($Execute) {
    $_SESSION["SuccessMessage"] = "Details updated Successfully";
    Redirect_to("MyProfile.php");
} else {
    $_SESSION["ErrorMessage"] = "Something went wrong. Try Again";
    Redirect_to("MyProfile.php");
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
    <title>MyProfile</title>
    <script src="https://kit.fontawesome.com/6592553267.js" crossorigin="anonymous"></script>
</head>
<body>
    <div style="height: 10px; background: #27aae2;"></div>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class="container" >
            <a href="#" class="navbar-brand">Jazebarkara.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="My profile.php" class="nav-link"><i class="fas fa-user text-success"></i> My profile</a>
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
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger">
                    <i class="fas fa-user-times "></i> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px;background:#27aael;"></div>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user mr-2" style="color:#27aae2;"></i><?php echo $ExistingUserName ?></h1>
                    <small><?php echo $ExistingHeadline ?></small>

                </div>
            </div>
        </div>
    </header>
    <section class="container py-2 mb-4">
    <div class="row">
    <div class="col-md-3">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h3><?php echo $ExistingName?></h3>
        </div>
        <div class="card-body">
    <img src="images/<?php echo $ExistingImage?>" class="block img-fluid mb-3" alt="">
    <div class="">
        <?php echo $ExistingBio?>
    </div>
</div>
    </div>
</div>
        <div class="col-md-9" style="min-height: 400px;">
            <?php echo ErrorMessage();
                  echo SuccessMessage(); 
            ?>
            <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
<div class="card bg-dark text-light">
    <div class="card-header bg-secondary text-light">
        <h4>Edit Profile</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <input class="form-control" type="text"  id="title"  placeholder="Headline" name="Headline">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="Name" id="title" placeholder="Your name" value="">
            <small class="text-muted"> Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
            <span class="text-danger"> Not more than 30 characters </span>
        </div>
                        <div class="form-group">
                            
                            <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
                        </div>
                        <div class="form-group mb-1">
                            <div class="custom-file">
                            <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                            <label for="imageSelect" class="custom-file-label">Select Image </label>
                            </div>
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