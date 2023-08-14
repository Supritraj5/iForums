<?php
    $showError="false";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        include '_dbconnect.php';
        $user_email=$_POST['signupEmail'];
        $pass=$_POST['Password'];
        $cpass=$_POST['cPassword'];

        // check if user exists
        $existsSql="SELECT * from `users` WHERE userEmail='$user_email';";
        $result=mysqli_query($conn,$existsSql);
        $numrows=mysqli_num_rows($result);
        if($numrows>0){
            $showError="Email already in use";
        }
        else if($pass==$cpass){
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` (`userEmail`, `userPass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp());";
            $result=mysqli_query($conn,$sql);
            if($result){
                $showalert=true;
                header("location: /iforums/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError="password do not match";
        }
        header("location: /iforums/index.php?signupsuccess=false&error=$showError");
        


        
    }
?>