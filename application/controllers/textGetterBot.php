<?php

// 3 = full display with link names and progress
// 2 = only display current link index
// 1 = only display errors
// 0 = no output
$VERBOSITY = 2;

// Connection
$con=mysqli_connect("localhost","balaji","password","balaji_huit");

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Get all links
$result = mysqli_query($con,"SELECT * FROM links");

$numRows = mysqli_num_rows($result);

$i = 0;
    
while($row = mysqli_fetch_array($result))
{

    if ($VERBOSITY > 1)
        print("Checking id:" . $row['id'] . "<br>\n");


	$text = strip_tags(file_get_contents($row['id']));
	
	$sql = "update links set text='{$text}' where 'id'='{$row['id']}'";
    
    set_time_limit(0);


}


mysqli_close($con);
?>