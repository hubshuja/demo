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

$result = $demoTask->get_locations();


if(!empty($_POST))
{
    
    $demoTask->save_locations();
}

if(!empty($_GET['location_id']))
{
    
    
    $demoTask->delete_locations_by_id($_GET['location_id']);
    
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Location</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Location Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // output data of each row
                            ?>
                             <tr>
                                        <td><?php echo $row['location_name'] ?></td>
                                         <td>
                                             <a class="location-update" href="#" data-id="<?php echo $row['location_id'] ?>"><i class="fa fa-pencil" data-toggle="modal" data-target="#exampleModal" aria-hidden="true"></i></a>
                                             | <i style="cursor:pointer" data-id="<?php echo $row['location_id'] ?>" class="delete fa fa-trash" aria-hidden="true"></i>
                                         </td>
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
        

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <form method="post" id="location-form">
                
              <input type="hidden" name="location_id">
              <div class="alert alert-danger" role="alert" id="location-fld">
                        Location field is required.
                </div>
                <div class="form-group">
                  <label for="location_name">Location Name*</label>
                  <input type="text" name="location_name" class="form-control" id="location_name" placeholder="Location Name">
                </div>
                
              <button type="button" id="save-btn" class="btn btn-primary">Save</button>
              </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</html>
<script type="text/javascript">

$(document).ready(function(){
    $('#save-btn').on('click', function(e){
        e.preventDefault();
         var location_value = $('input[name="location_name"]').val();
     
     if(location_value == '')
     {
         $('#location-fld').fadeIn();
         
         return false;
     }
        
        $('#location-form').submit();
    });
    
    $('.delete').on('click', function(){
        
        if(confirm('Are your sure you want to delete this record?'))
        {
            window.location.href="/demo_task/locations?location_id="+$(this).attr('data-id');
        }
        
    })
    
    $('.location-update').on('click', function(){
         $.ajax({

          url: "/demo_task/ajax.php",
             
           type: "POST",
           
             data:{
                 location_id:$(this).attr('data-id')
             },
                   
                  success:function(data) {
                       
                     var obj = jQuery.parseJSON( data );

                     $('input[name="location_id"]').val(obj.location_id);
                     
                      $('input[name="location_name"]').val(obj.location_name);
                  }

              })
        
    })
    
})
</script>
