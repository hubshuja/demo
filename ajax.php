<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'demo_task.php';

$demoTask = new Demo_Task();

$result = $demoTask->get_locations($_POST['location_id']);

 if (mysqli_num_rows($result) > 0) {
 while ($row = mysqli_fetch_assoc($result)) {
     
     echo json_encode($row);
 }
 
 }