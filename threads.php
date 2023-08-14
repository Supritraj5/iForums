<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 400px;
    }
    </style>
</head>

<body>
    <?php  include 'partials/_dbconnect.php'; ?>
    <?php  include 'partials/_header.php'; ?>

    <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){

        $thread=$row['thread_title'];
        $desc=$row['thread_desc'];
        $th_user_id=$row['thread_user_id'];
        $sql2="SELECT userEmail FROM users WHERE slno='$th_user_id';";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $postedby=$row2['userEmail'];
    }
    ?>

    <?php
        $showalert=false;
        $method=$_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            // insert comment to db
            $comment= $_POST['comment'];
            $comment= str_replace("<","&lt",$comment);
            $comment= str_replace(">","&gt",$comment);

            $slno=$_POST['slno'];
            $sql="INSERT INTO `comments` (`comment_id`, `comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES (NULL, '$comment', '$id', current_timestamp(),'$slno');";
            $result=mysqli_query($conn,$sql);
            $showalert=true;
            if($showalert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success ! </strong>Your comment has been added
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
    ?>



    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $thread;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>this is a peer to peer forums for sharing knowledge with each other <br>
                Forum Guidelines
                Warn About Adult Content.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.</p>
            <p><b>Posted by- <em> <?php echo $postedby;?></em></b></p>
        </div>
    </div>


    <?php
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true ){
            echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <form action="'.$_SERVER['REQUEST_URI'].'"method="post">
                <label for="floatingTextarea2">Type your comments</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment"
                        style="height: 100px"></textarea>  
                        <input type="hidden" name="slno" value="'.$_SESSION['slno'].'">
                </div>
                <button type="submit" class="btn btn-success my-2">Submit</button>
            </form>
        </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <p class="lead">You are not logged in, please login to be able to comment</p>
        </div>';
    }
    ?>



    <div class="container" id="ques">
        <h1 class="py-4">Discussions</h1>

        <?php
        $noresult=true;
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `comments` WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){

        $noresult=false;
        $id=$row['comment_id'];
        $content=$row['comment_content'];
        $comment_time=$row['comment_time'];
        $userid=$row['comment_by'];
        $sql2="SELECT userEmail FROM users WHERE slno=$userid;";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);

        echo '<div class="media d-flex align-items-center my-3">
        <img src="img/def_user_img.png" width="60px" height="60px" alt="...">
        <div class="media-body flex-grow-1 ms-3">
        <p class="fw-bold my-0">commented by '.$row2['userEmail'].' at '.$comment_time.'</p>
            '.$content.'
        </div>
    </div>';
    }


    if($noresult){
        echo '
        <div class="jumbotron jumbotron-fluid py-3 px-1" style="background-color: #d7d4d4;">
        <div class="container">
            <h4 class="display-6">No comments found</h4>
            <p class="lead">Be the first person to ask a question</p>
        </div>
        </div>';
    }


    ?>

    </div>


    <!-- categories container starts here -->
    <div class="container my-3">

    </div>

    <?php  include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
</body>

</html>