<?php
    session_start();
    include '_dbconnect.php';
    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark text-light">
    <!-- <nav class="navbar bg-dark border-bottom border-bottom-dark"> -->
    <div class="container-fluid">
        <a class="navbar-brand" href="/iforums">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
          </a>
          <ul class="dropdown-menu">
          
          
          
          
          ';
        //   <li><a class="dropdown-item" href="">HOME</a></li>
        //   <li><a class="dropdown-item" href="">jkhjkh</a></li>
        //   <li><a class="dropdown-item" href="">jghgj</a></li>

            $sql="SELECT category_name,category_id FROM `categories` LIMIT 3";
            $result=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($result)){
                echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
            }

        echo '</ul>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="contacts.php">contacts</a>
            </li>
            
        </ul>
        <div class="d-flex mx-2">';

        echo '<form class="d-flex" role="search" method="get" action="search.php">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0 mx-2" type="submit">Search</button>  
        </form>';
        if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true ){

            echo '
            <p class="text-dark my-0 py-1 ">Welcome '.$_SESSION['useremail'].'</p>
            <a href="partials/_logout.php" class="mx-2 btn btn-outline-success">Logout</a>';
        }
        else{

            echo '
        <div class="btns mx-2">
            <button class="ml-2 btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
            <button class="mx-2 btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupmodal">Signup</button>
        </div>';

        }
    
        echo '</div>
        </div>
    </div>
    </nav>';


include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success ! </strong>You can Login now 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
}
if(isset($_GET['error']) && $_GET['signupsuccess']=="false"){
    echo '<div class="alert alert-danger alert-dismissible my-0 fade show" role="alert">
        <strong>Error ! </strong>'.$_GET['error'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
}
if(isset($_GET['err'])&& $_GET['loginsuccess']=="false"){
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Error ! </strong>'.$_GET['err'].'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>