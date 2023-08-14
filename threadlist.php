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
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){

        $catname=$row['category_name'];
        $catdesc=$row['category_desc'];
    }
    ?>

    <?php
    $showalert=false;
    
        $method=$_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            // insert thread into db
            $thtitle= $_POST['title'];
            $thdesc= $_POST['desc'];
            $slno=$_POST['slno'];

            $thtitle=str_replace("<","&lt",$thtitle);
            $thtitle=str_replace(">","&gt",$thtitle);

            $thdesc= str_replace("<","&lt",$thdesc);
            $thdesc= str_replace(">","&gt",$thdesc);
    
            $sql="INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (NULL, '$thtitle', '$thdesc', '$id', '$slno', current_timestamp());";
            $result=mysqli_query($conn,$sql);
            $showalert=true;
            if($showalert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success ! </strong>Your thread has been added please wait while community responds
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
    ?>


    <div class="container my-4">
        <div class="jumbotron px-4 px-4" style="background-color: #d7d4d4;">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>this is a peer to peer forums for sharing knowledge with each other <br>
                Forum Guidelines
                Warn About Adult Content.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.</p>
            <p class="lead py-4">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true ){
            echo '<div class="container">
            <h1 class="py-2">Start a discussion</h1>
            <form action="'.$_SERVER['REQUEST_URI'].'"method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Problem title</label>
                    <input type="text" id="title" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Keep your title crisp and short as possible</div>
                </div>
                <label for="floatingTextarea2">Elaborate your concern</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc"
                        style="height: 100px"></textarea>
                        <input type="hidden" name="slno" value="'.$_SESSION['slno'].'">
                </div>
                <button type="submit" class="btn btn-success my-2">Submit</button>
            </form>
            </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Start a discussion</h1>
        <p class="lead">You are not logged in please login to start a discussion</p>
        </div>';
    }
    ?>
    

    <div class="container" id="ques">
        <h1 class="py-4">Browse questions</h1>

        <?php
        $id=$_GET['catid'];
        $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result=mysqli_query($conn,$sql);
        $noresult=true;
        while($row=mysqli_fetch_assoc($result)){

        $noresult=false;
        $id=$row['thread_id'];
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_time=$row['timestamp'];

        $thid=$row['thread_user_id'];
        $sql2="SELECT userEmail from `users` where slno='$thid'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        

        echo '<div class="media d-flex align-items-center my-3">
        <img src="img/def_user_img.png" width="60px" height="60px" alt="...">
        <div class="media-body flex-grow-1 ms-3">
            <p class="fw-bold my-0">Asked by '.$row2['userEmail'].' at '.$thread_time.'</p>
            <h5 class="mt-0"><a class="text-dark text-decoration-none" href="threads.php?threadid='.$id.'">'.$title.'</a></h5>
            '.$desc.'
        </div>
    </div>';
    }
    if($noresult){
        echo '
        <div class="jumbotron jumbotron-fluid py-3 px-1" style="background-color: #d7d4d4;">
        <div class="container">
            <h4 class="display-6">No Threads found</h4>
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