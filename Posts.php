<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; 
Confirm_Login()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style.css">
    <title>Posts</title>
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
                    <h1><i class="fas fa-blog" style="color:#27aae2;"></i> Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block"> 
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block"> 
                        <i class="fas fa user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block"> 
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts";
                    $stmt = $ConnectingDB->query($sql);
                    $sr=0;
                    while ($DataRows=$stmt->fetch()) {
                        $Id = $DataRows["id"];
                        $DateTime=$DataRows["datetime"];
                        $PostTitle = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $PostText = $DataRows["post"];
                        $sr++;
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>                            
                                <?php
                                if (strlen($PostTitle) > 20){$PostTitle = substr($PostTitle, 0,18) . '..';}
                                echo $PostTitle;
                                ?>
                            </td>
                            <td>                            
                                <?php
                                if (strlen($Category) > 8){$Category = substr($Category, 0, 8) . '..';}
                                echo $Category;
                                ?>
                            </td>
                            <td>                            
                                <?php
                                if (strlen($DateTime) > 11){$DateTime = substr($DateTime, 0,11) . '..';}
                                echo $DateTime;
                                ?>
                            </td>
                            <td>
                            <?php
                            if(strlen($Admin) > 6){$Admin = substr($Admin, 0, 6) . '..';}
                            echo $Admin;
                            ?>
                            </td>
                            <td><img src="Uploads/<?php echo $Image; ?>"width="170px;" height="50px"></td>
                            <td>
<?php
$Total=ApproveCommentsAccordingtoPost($Id);
if ($Total>0) {
?>
<span class="badge badge-success">
<?php
echo $Total; ?>
</span>
<?php } ?>
</span>
<?php
$Total=DisApproveCommentsAccordingtoPost($Id);
if ($Total>0) {
?>
<span class="badge badge-danger">
<?php
echo $Total; ?>
</span>
<?php } ?>
</span>
</td>
                            <td>Action</td>
                            <td>
                                <a href="EditPost.php?id=<?php echo $Id ;?>"><span class="btn btn-warning">Edit</span></a>
                                <a href="DeletePost.php?id=<?php echo $Id;?>"><span class="btn btn-danger">Delete</span></a>
                            </td>
                            <td>
                                <a href="FullPost.php?id=<?php echo $Id;?>" target="_blank"><span class="btn btn-primary">Live Previews</span></a>
                            </td>
                        </tr>
                        </tbody>
                    <?php }?>
                </table>    














        <div style="height: 10px; background: #27aae2;"></div>
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