<?php
    $showError="false";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        include '_dbconnect.php';
        $user_email=$_POST['loginEmail'];
        $pass=$_POST['loginPassword'];
        $sql="SELECT * FROM users WHERE userEmail='$user_email'";
        $result=mysqli_query($conn,$sql);
        $numrow=mysqli_num_rows($result);
        if($numrow==1){
            $row=mysqli_fetch_assoc($result);
            if(password_verify($pass,$row['userPass'])){
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['useremail']=$user_email;
                $_SESSION['slno']=$row['slno'];
            
            }
            else{
                $showError="wrong password";
                $_SESSION['loggedin']=false;
                $_SESSION['err']=$showError;
                header("location: /iforums/index.php?loginsuccess=false&err=$showError");
                exit();
            }
           
         header("location: /iforums/index.php");
            
            
        }
        else{
            $showError="username does not exists!";
            $_SESSION['loggedin']=false;
            $_SESSION['err']=$showError;
            header("location: /iforums/index.php?loginsuccess=false&err=$showError");
            exit();
        }
    }

?>