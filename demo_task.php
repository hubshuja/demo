<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Demo_Task{
    
    public $conn='';
    
    function __construct() {
        
    }
    
    /*
     * 
     * 
     * Database connection
     */
    
    private function db_connection(){
        
        $servername = "localhost";
        $database = "demo_task";
        $username = "root";
        $password = "";

        // Create connection

        $conn = mysqli_connect($servername, $username, $password, $database);
        
        return $conn;

        
    }
    
    /*
     * 
     * 
     * Get last part of current url
     */
    public function get_url_parts(){
        
        $actual_link =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $url_parts = basename($actual_link);
        
        return $url_parts;
    }
    
    /*
     * 
     * Sort customer by first name, last name, location name
     */
    
    function sort_customer(){
        
        $sort = $_GET['sort'];
       $sort_by = $_GET['sort_by'];
        $sql='';
        switch($sort_by){
            
            case"first_name":
                $sql = "SELECT users.*, locations.location_id, locations.location_name
                 from users
                 Inner join locations on users.location_id = locations.location_id
                 Order by users.first_name $sort
                ";
                return $result = mysqli_query($this->db_connection(), $sql);
            break;
        
            case"last_name":
              $sql = "SELECT users.*, locations.location_id, locations.location_name
                 from users
                 Inner join locations on users.location_id = locations.location_id
                 Order by users.last_name $sort
                ";
              return   $result = mysqli_query($this->db_connection(), $sql);
            break;
            
            case "location_name":
              $sql = "SELECT users.*, locations.location_id, locations.location_name
                 from users
                 Inner join locations on users.location_id = locations.location_id
                 Order by locations.location_name $sort
                ";
                 return $result = mysqli_query($this->db_connection(), $sql);
            break;
                
            
        }
    }
   /*
    * 
    * Get all customer or customer by id
    */ 
    public function get_records($id=''){
        
      if(!empty($id))
      {
          $sql = "SELECT * from users where user_id=$id
                ";
          
      }
    else{
        
        $sql = "SELECT users.*, locations.location_id, locations.location_name
                 from users
                 Inner join locations on users.location_id = locations.location_id
                 Order by users.user_id Desc
                ";
    }
        
        
        $result = mysqli_query($this->db_connection(), $sql);
        
        return $result;
        
    }
    
    
    public function get_locations($id=''){
        
        if(!empty($id))
        {
             $sql = "SELECT * from locations
                 where location_id =$id
                ";
        
        }
        else{
            
             $sql = "SELECT * from locations
                 Order by locations.location_id Desc
                ";
        
       
        }
        
         $result = mysqli_query($this->db_connection(), $sql);
        
        return $result;
        
    }
    /*
     * 
     * Delete Location by id
     */
    
    public function delete_locations_by_id($Id)
    {
        
        $sql = "delete from locations  WHERE location_id=".$Id;
            
             if (mysqli_query($this->db_connection(), $sql)) {
               header("Location: /demo_task/locations/?delete_message=true");
              } else {
               header("Location: /demo_task/locations/?error_message=true");
              }
        
    }
    /*
     * 
     * Delete user by id
     */
    
     public function delete_user_by_id($Id)
    {
        
        $sql = "delete from users  WHERE user_id=".$Id;
            
             if (mysqli_query($this->db_connection(), $sql)) {
               header("Location: /demo_task/customer/?delete_message=true");
              } else {
               header("Location: /demo_task/customer/?error_message=true");
              }
        
    }
    
    
    /*
     * 
     * Save and update customer
     */
    public function save_customer(){
        
        $first_name= $_POST['first_name'];
        $last_name= $_POST['last_name'];
        $location= $_POST['location_id'];
        
        if(!empty( $_POST['user_id']))
        {
            
            $sql = "UPDATE users SET first_name='$first_name',
                    last_name='$last_name',
                    location_id=$location
                     WHERE user_id=".$_POST['user_id'];
            
        }
        
        else{
            
              $sql = "INSERT INTO users (first_name, last_name, location_id)
                    VALUES ('$first_name', '$first_name', $location)";
            
        }
        
      
            
            if (mysqli_query($this->db_connection(), $sql)) {
               header("Location: /demo_task/customer/?success_message=true");
              } else {
               header("Location: /demo_task/customer/?error_message=true");
              }
    
        
    }


    /*
     * 
     * Save and update location
     */
    
    public function save_locations(){
        
        if(!empty($_POST['location_id']))
        { 
            $locatons_name = $_POST['location_name'];
            $sql = "UPDATE locations SET location_name='$locatons_name' WHERE location_id=".$_POST['location_id'];
            
             if (mysqli_query($this->db_connection(), $sql)) {
               header("Location: /demo_task/locations/?success_message=true");
              } else {
               header("Location: /demo_task/locations/?error_message=true");
              }
        }
        else{
            
            $locatons_name = $_POST['location_name'];
            
           $sql = "INSERT INTO locations (location_name)
                    VALUES ('$locatons_name')";
            
            if (mysqli_query($this->db_connection(), $sql)) {
               header("Location: /demo_task/locations/?success_message=true");
              } else {
               header("Location: /demo_task/locations/?error_message=true");
              }
        }
        
    }
   
    /*
     * 
     * Check user login credentials
     */
    
    public function check_user_login(){
        
        $username = $_POST['username'];
        $password = md5($_POST['password']);
         $sql = "SELECT * from password_protection
                 where username='$username' and password='$password'
                ";
       $result = mysqli_query($this->db_connection(), $sql);
        $record='';
       if (mysqli_num_rows($result) > 0) {
           
          
           while ($row = mysqli_fetch_assoc($result)) {
    
            $record = $row;  
            
           
          }
          return $record;
       }
       return $record;
        
       // return $result;
    }
    
}