
<?php
/*
 * 
 * start session if not started already
 */
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  /*
 * 
 * check if user is logged in or not
 */
  if(!empty($_SESSION["username"]))
{
    
     header("Location: /demo_task/customer");
}
include_once 'demo_task.php';


$error_message = '';
if(!empty($_POST))
{
    $demoTask = new Demo_Task();
    if($_POST['username'] =='')
    {
        $error_message .="<p>User Name is required</p>";
    }
    if($_POST['password'] =='')
    {
        $error_message .="<p>Password is required</p>";
    }
    if($error_message =='')
    {
        
      $record =  $demoTask->check_user_login();
        
        if(!empty($record))
        {
            
              $_SESSION["username"] = $record['username'];
              
              header("Location: /demo_task/customer");
            
        }
        
        else{
            
            $error_message .="<p>Username or Password is inccorect</p>";
        }
    }
    
    
}

?>
<!DOCTYPE html>

<html>

    <head>

        <title>Image</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="asset/login.css">   
    </head>
    <body>
        <div class="container custom-container">
            <form  method="post">
              <?php
                if(!empty($error_message)):
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   
                    <?php echo $error_message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
               <?php
               endif;
               ?>

                <div class="container">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username">

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password">

                    <button type="submit">Login</button>
                   
                </div>

            </form>
        </div>
    </body>
</html>