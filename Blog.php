<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style.css">
    <title>Blog Page</title>
    <script src="https://kit.fontawesome.com/6592553267.js" crossorigin="anonymous"></script>
</head>
<body>
    <div style="height: 10px; background: #27aae2;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a href="#" class="navbar-brand">Jazebarkara.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="form-group">
                            <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
                            <button class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae2;"></div>
    <div class="container">
        <div class="row mt-4">
            <!-- Main Area Start -->
            <div class="col-sm-8">
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by using PHP by Jazeb Akram</h1>
                <?php 
                    echo ErrorMessage();
                    echo SuccessMessage(); 
                ?>
                <?php
                global $ConnectingDB;
                // SQL query when Search button is active
                if (isset($_GET["SearchButton"])) {
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM posts
                            WHERE datetime LIKE :search
                            OR title LIKE :search
                            OR category LIKE :search
                            OR post LIKE :search";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':search', '%' . $Search . '%');
                    $stmt->execute();
                } elseif (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    if ($Page == 0 || $Page < 1) {
                        $ShowPostFrom = 0;
                    } else {
                        $ShowPostFrom = ($Page * 5) - 5;
                    }

                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $ShowPostFrom, 5";
                    $stmt = $ConnectingDB->query($sql);
                } 
                elseif (isset($_GET["category"])) {
                    $Category = $_GET["category"];
                    $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                }
                else {
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0, 3";
                    $stmt = $ConnectingDB->query($sql);
                }
                while ($DataRows = $stmt->fetch()) {
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];
                ?>
                <div class="card">
                    <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height: 450px;" class="img-fluid card-img-top">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                        <small class="text-muted">Category: <span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> Written by<a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a> on <span class="text-dark"> <?php echo htmlentities($DateTime); ?></span></small>
                        <span style="float:right;" class="badge badge-dark text-light">Comments 
                            <?php echo ApproveCommentsAccordingtoPost($PostId); ?>
                        </span>
                        <hr>
                        <p class="card-text">
                            <?php
                            if (strlen($PostDescription) > 150) {
                                $PostDescription = substr($PostDescription, 0, 150) . "...";
                            }
                            echo htmlentities($PostDescription);
                            ?>
                        </p>
                        <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                            <span class="btn btn-info">Read More >> </span>
                        </a>
                    </div>
                </div>
                <?php } ?>
                <nav>
                    <ul class="pagination pagination-lg">
                        <?php if (isset($Page)) {
                            if ($Page > 1) { ?>
                                <li class="page-item">
                                    <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                                </li>
                        <?php } }?>
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        $PostPagination = $TotalPosts / 5;
                        $PostPagination = ceil($PostPagination);
                        for ($i = 1; $i <= $PostPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                        <?php } } ?>
                        <?php if (isset($Page) && !empty($Page)) {
                            if ($Page + 1 <= $PostPagination) { ?>
                                <li class="page-item">
                                    <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                                </li>
                        <?php } }?>
                    </ul>
                </nav>
            </div>
            <!-- Main Area End -->
            <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="images/startblog.png" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up !</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the forum</button>
                        <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id DESC";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                            <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"> <?php echo $CategoryName; ?></span></a><br>
                        <?php } ?>
                    </div>
                </div>
                <br>
                <div class="card">
    <div class="card-header bg-info text-white">
        <h2 class="lead">Recent Posts</h2>
    </div>
    <div class="card-body">
        <?php
        global $ConnectingDB;
        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
            $Id = $DataRows['id'];
            $Title = $DataRows['title'];
            $DateTime = $DataRows['datetime'];
            $Image = $DataRows['image'];
        ?>
        <div class="media">
    <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start width="90" height="94" alt="" " />
    <div class="media-body ml-2">
        <a href="fullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
            <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
        </a>
        <p class="small"><?php echo htmlentities($DateTime); ?></p>
    </div>
</div>
<hr>

            <!-- Display post details here -->
        <?php } ?>
    </div>
</div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Jazeb Aram | <span id="year"></span> &copy; ----All rights reserved.</p>
                </div>
            </div>
        </div>
        <div style="height: 10px; background: #27aae2;"></div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>
