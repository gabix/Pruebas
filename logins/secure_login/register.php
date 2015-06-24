<?php 
//REGISTERING A NEW USER

// The hashed password from the form
$password = $_POST['p']; 

// Create a random salt
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

// Create salted password (Careful not to over season)
$password = hash('sha512', $password.$random_salt);
 
// Add your insert to database script here. 
// Make sure you use prepared statements!
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {    
   $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt); 
   // Execute the prepared query.
   $insert_stmt->execute();
}
/*
 * Make sure the value of $_POST['p'] is already hashed from javascript, 
 * if you are not using this method because you want to validate the password server side then make sure you hash it.
 */

?>

<?php
/* Page Protection Script.
 * One of the most common problems with authentication systems is the developer 
 * forgetting to check if the user is logged in. 
 * It is very important you use the below code to check that the user is logged in.
 */

// Include database connection and functions here.
sec_session_start();
if(login_check($mysqli) == true) {
 
   // Add your protected page content here!
 
} else {
   echo 'You are not authorized to access this page, please login. <br/>';
}
?>
