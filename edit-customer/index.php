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
if(empty($_SESSION["username"]))
{
    
     header("Location: /demo_task");
}
include_once '../demo_task.php';

$demoTask = new Demo_Task();

$locations = $demoTask->get_locations();

$customer = $demoTask->get_records($_GET['user_id']);

$first_name= "";
$last_name= "";
$location_id= "";

$error_message = '';
if(!empty($_POST))
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $location_id = $_POST['location_id'];
    if($_POST['first_name'] =='')
    {
        $error_message .="<p>First Name is required</p>";
    }
    if($_POST['last_name'] =='')
    {
        $error_message .="<p>Last Name is required</p>";
    }
    if($_POST['location_id'] =='')
    {
        $error_message .="<p>Location  is required</p>";
    }
    
    if($error_message =='')
    {
        
        $demoTask->save_customer();
    }
    
    
}

$record='';

if (mysqli_num_rows($customer) > 0) {
    
while ($row = mysqli_fetch_assoc($customer)) {
    
  $record = $row;  
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
        <link rel="stylesheet" href="../asset/style.css">  
      
    </head>
    <body>
        <div class="container custom-container">
           
            <h1>Add Customer</h1>
            <form method="post">
                
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
                <div class="form-group">
                    <input type="hidden" name="user_id" value="<?php echo $record['user_id'];?>">
                  <label for="first_name">First Name*</label>
                  <input type="text" name="first_name" value="<?php echo !empty($record['first_name'])?$record['first_name']:''; ?>" class="form-control" id="first_name" placeholder="First Name">
                </div>
                
                <div class="form-group">
                  <label for="last_name">Last Name*</label>
                  <input type="text" name="last_name" value="<?php echo !empty($record['last_name'])?$record['last_name']:''; ?>" class="form-control" id="first_name" placeholder="Last Name">
                </div>
                
               <div class="form-group">
                 <label for="first_name">Location*</label>
                 <select id="location_id" name="location_id" class="form-control">
                     <option value="">Choose</option>
                      <?php
                      if (mysqli_num_rows($locations) > 0) {
                        while ($row = mysqli_fetch_assoc($locations)) {
                      ?>
                           <option <?php echo !empty($record['location_id'])?'selected':''; ?> value="<?php echo $row['location_id'] ?>"><?php echo $row['location_name'] ?></option>
                         <?php
                         }
                      
                        }
                      ?>
                    </select>
                 </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
              </form>
        </div>
    </body>
</html>
