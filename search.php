<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #maincontainer{
            min-height: 350px;
        }
    </style>
    <title>iDiscuss</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <?php  include 'partials/_dbconnect.php'; ?>
    <?php  include 'partials/_header.php'; ?>


    <!-- search result -->
    <div class="container my-3" id="maincontainer">

        <h1 class="mb-5">Search result for <em>"<?php echo $_GET['search'];?>"</em></h1>


    <?php
        $noresult=true;
        $key=$_GET["search"];
        $sql="SELECT * FROM threads WHERE match (thread_title,thread_desc) against ('$key');";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){

            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_id=$row['thread_id'];
            $url='threads.php?threadid='.$thread_id;
            $noresult=false;
            echo '<div class="result">
                <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                <p>'.$desc.'</p>
                </div>';
            }
        if($noresult){
            echo '
                <div class="jumbotron jumbotron-fluid py-3 px-1" style="background-color: #d7d4d4;">
                <div class="container">
                    <h4 class="display-6">No results found</h4>
                    <p class="lead">
                    Suggestions
                        <ul>
                            <li>Try different keywords.</li>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try more general keywords</li>
                        </ul>
                    </p>
                </div>
                </div>';
        }
    ?>

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>