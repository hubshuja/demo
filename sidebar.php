<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$url_part = $demoTask->get_url_parts();

?>

<div class="col-lg-3 col-md-3 col-sm-12 side-bar">
               <?php
               ?>
    <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link <?php echo $demoTask->get_url_parts() =='demo_task'?'active':"" ?>" href="/demo_task">Cuctomers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $demoTask->get_url_parts() =='locations'?'active':"" ?>" href="/demo_task/locations">Location</a>
        </li>
      </ul>
    
 </div>