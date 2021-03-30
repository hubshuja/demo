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




if(!empty($_GET['user_id']))
{
    
    
    $demoTask->delete_user_by_id($_GET['user_id']);
    
}

if(!empty($_GET['sort']))
{
   $result =    $demoTask->sort_customer();
   
 
    
}
else{
    
    $result = $demoTask->get_records();
}



?>

<!DOCTYPE html>

<html>

    <head>

        <title>Demo Task</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../asset/style.css">  
      
    </head>
    <body>
        <div class="container custom-container">
             <h1>Demo Task</h1>
            <div class="row"> 
<?php
include_once '../sidebar.php';
?>

                <div class="col-lg-8 col-md-8 col-sm-12">

 <?php
                   if(!empty($_REQUEST['success_message']))
                   {
                       ?>
                      <div class="alert alert-success" role="alert">
                       Record saved successfully!
                      </div>
                    
                    <?php
                   }
                   ?>
                     <?php
                   if(!empty($_REQUEST['delete_message']))
                   {
                       ?>
                      <div class="alert alert-success" role="alert">
                       Record deleted successfully!
                      </div>
                    
                    <?php
                   }
                   ?>

                   
                    <div class="add-button-container">
                        <a href="/demo_task/add-customer">  <div class="btn btn-primary mb-2">Add Customer</div></a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th> <a href="/demo_task/customer/?sort=<?php echo !empty($_GET['sort']) && $_GET['sort']=="ASC" ?'DESC':'ASC'; ?>&sort_by=first_name">First Name</a><i class="fa fa-sort-desc" aria-hidden="true"></i></th>
                                <th><a href="/demo_task/customer/?sort=<?php echo !empty($_GET['sort']) && $_GET['sort']=="ASC" ?'DESC':'ASC'; ?>&sort_by=last_name">Last Name</a></th>
                                <th> <a href="/demo_task/customer/?sort=<?php echo !empty($_GET['sort']) && $_GET['sort']=="ASC" ?'DESC':'ASC'; ?>&sort_by=location_name">Location</a></th>
<!--                                <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // output data of each row
                            ?>
                             <tr>
                                        <td><?php echo $row['first_name'] ?></td>
                                        <td><?php echo $row['last_name'] ?></td>
                                        <td><?php echo $row['location_name'] ?></td>
<!--                                        <td>
                                            <a href="/demo_task/edit-customer/?user_id=<?php echo $row['user_id'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                             | <i style="cursor:pointer" data-id="<?php echo $row['user_id'] ?>" class="delete fa fa-trash" aria-hidden="true"></i>
                                        </td>-->
                                    </tr>
        <?php
                                }
                            } else {

                                echo "<tr><td  colspan='4'>No Result Found!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>      
            </div>
    </body>
</div>
</html>
<script type="text/javascript">
$(document).ready(function(){
    
    
     $('.delete').on('click', function(){
        
        if(confirm('Are your sure you want to delete this record?'))
        {
            window.location.href="/demo_task/customer/?user_id="+$(this).attr('data-id');
        }
        
    })
})

</script>