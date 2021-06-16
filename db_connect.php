<?php
/* Database connection start */
$servername = "localhost";
$username 	= "crm";
$password 	= "crmcrm";
$dbname 	= "crm";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
function unique_pin(){
	global $conn;
	//$number = time();
	$number = substr(number_format(time() * rand(),0,'',''),0,10);
	$pinresult = mysqli_query($conn," SELECT * FROM t_master_sales WHERE order_id = '".$number."' ");		
	if (mysqli_num_rows($pinresult) > 0 || $number == 0)
	{ unique_pin(); }
	else
	{ return $number ; }
}

?>