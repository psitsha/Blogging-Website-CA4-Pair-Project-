<?php
session_start();
include('database.php');
include("include/header.php");

$name = $_GET["name"];


$sql = "SELECT * from users WHERE name='$name'";

$result = mysqli_query($link, $sql);
$email = "";
if (!$result) {
    printf("Error: %s\n", mysqli_error($link));
    exit();
}
while ($row = mysqli_fetch_array($result)) {
    $email = $row["email"];
    $avatar = $row["avatar"];
}


$query = $link->prepare("SELECT u.name,u.avatar, p.date, p.post_id, p.post_title, LEFT(p.content, 200) AS content "
        . "FROM users as u, posts as p WHERE u.user_id = p.user_id and u.name='$name'");
$query->execute();
$query->bind_result($name1, $avatar, $date, $post_id, $post_title, $content);
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->



<style>
    .btn12 {
  background: #ff001a;
  background-image: -webkit-linear-gradient(top, #ff001a, #852828);
  background-image: -moz-linear-gradient(top, #ff001a, #852828);
  background-image: -ms-linear-gradient(top, #ff001a, #852828);
  background-image: -o-linear-gradient(top, #ff001a, #852828);
  background-image: linear-gradient(to bottom, #ff001a, #852828);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 14px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn12:hover {
  background: #ff4400;
  text-decoration: none;
}
</style>
<h1 style="text-shadow: 6px 6px 0px rgba(0,0,0,0.2);font-size: 5.5em;   ">My Profile</h1>
<div style="float: left;    width: 20%; height:40%;
     display: inline-block;
     background-color: white;">
    <div style="border-bottom: 50px;"> 
        <img  src="uploads/<?php echo $avatar; ?>" style="width: 50%;height: 100%;">
    </div>



    <h2> <span itemprop="name"><?php echo $name; ?></span></h2>
<!--                                        <p itemprop="jobTitle">Your Position</p>
    <p><span itemprop="affiliation">Your Company</span></p>
    <p>
        <i class="fa fa-map-marker"></i> <span itemprop="addressRegion">Your City, Your State</span>
    </p>-->
    <p itemprop="email"> <i class="fa fa-envelope"> </i> <a href="mailto:example@email.com"><?php echo $email; ?></a> </p>
</div>
<!--                        <div class="col-lg-12 centered-text">
                            Your Short Bio goes here.
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div id="social-links" class=" col-lg-12">
                            <div class="row">
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-3 social-btn-holder">
                                    <a title="google" class="btn btn-social btn-block btn-google" target="_BLANK" href="http://plus.google.com/+You/">
                                        <i class="fa fa-google"></i> +You
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-3 social-btn-holder">
                                    <a title="twitter" class="btn btn-social btn-block btn-twitter" target="_BLANK" href="http://twitter.com/yourid">
                                        <i class="fa fa-twitter"></i> /yourid
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-3 social-btn-holder">
                                    <a title="github" class="btn btn-social btn-block btn-github" target="_BLANK" href="http://github.com/yourid">
                                        <i class="fa fa-github"></i> /yourid
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-3 social-btn-holder">
                                    <a title="stackoverflow" class="btn btn-social btn-block btn-stackoverflow" target="_BLANK" href="http://stackoverflow.com/users/youruserid/yourid">
                                        <i class="fa fa-stack-overflow"></i> /yourid
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->


<?php
while ($query->fetch()):
    $lastspace = strrpos($content, ' ')
    ?>
    <div class="card mb-4" style="width: 35%; float: right;margin-right: 20px;">
        <img class="card-img-top" src="img/blog.png" alt="Card image cap">
        <div class="card-body">
            <h2 class="card-title"><?php echo $post_title ?></h2>

        <!--                  <a href=<?php echo 'view_post.php?post_id=' . $post_id ?>class="btn btn-primary" class="btn btn-primary">Read More &rarr;</a>-->
            <?php echo substr($content, 0, $lastspace) . "<br><a href='view_post.php?post_id=$post_id' class='btn btn-primary' class='btn btn-primary'> READ MORE...</a><br><form action='delete_post.php' method='POST'>" ?>
            <?php echo "<input type='hidden' name='postName' value='".$post_id."'>
                                    <input  name='submit' type='submit' value='delete' class='btn12'/>
                                </form>" ?>
        </div>
        <div class="card-footer text-muted">
            Posted on <?php echo $date ?> 

        </div>
        <div id='popover' style='display: none'>



        </div>
    </div>
<?php endwhile ?>