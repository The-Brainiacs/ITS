<?php
$connection = mysql_connect("localhost", "root", ""); // Establishing connection with server..
$db = mysql_select_db("college", $connection); // Selecting Database.
$matrics=$_POST['matrics1']; // Fetching Values from URL.
$password= sha1($_POST['password1']); // Password Encryption, If you like you can also leave sha1.
// check if e-mail address syntax is valid or not
$matrics = filter_var($matrics, FILTER_SANITIZE_MATRICS); // sanitizing matrics(Remove unexpected symbol like <,>,?,#,!, etc.)
if (!filter_var($matrics1, MATRICS)){
echo "Invalid matrics.......";
}else{
// Matching user input matrics and password with stored matrics and password in database.
$result = mysql_query("SELECT * FROM registration WHERE matrics='$matrics' AND password='$password'");
$data = mysql_num_rows($result);
if($data==1){
echo "Successfully Logged in...";
}else{
echo "Matrics or Password is wrong...!!!!";
}
}
mysql_close ($connection); // Connection Closed.
?>