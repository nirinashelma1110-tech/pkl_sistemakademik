<?php  
date_default_timezone_set('Asia/Jakarta');
session_start();

$con = mysqli_connect('localhost', 'root', '', 'pkl'); 

if (!$con) 
{
    die('Connect Error: ' . mysqli_connect_error());
}

function base_url($url = null)
{
    
    $base_url = "http://localhost/pkl";
    
    if ($url != null)
    {
        return $base_url . "/" . ltrim($url, '/');
    }
    else
    {
        return $base_url;
    }
} 
?>