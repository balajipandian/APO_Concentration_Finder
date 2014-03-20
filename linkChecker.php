<?php

// 3 = full display with link names and progress
// 2 = only display current link index
// 1 = only display errors
// 0 = no output
$VERBOSITY = 2;

// Connection
$con=mysqli_connect("localhost","balaji","Ar2Sy3Cb0","balaji_huit");

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

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $row['url']);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);
    if ($VEROSITY > 2)
        print("HTTP response code:" . $headers['http_code']);
    
    if (!(($headers['http_code'] == '200') || ($headers['http_code'] == '302'))) {
        if ($VERBOSITY > 0)
            print("ERROR: id ". $row['id'] . " url: " . $row['url'] . " not found<br>\n");
        
        $to = "balaji210@gmail.com";
        $subject = "my.harvard.edu link error";
        $message = "link id: " . $row['id'] . "url: " . $row['url'] . " does not work.";
        $from = "balaji@balajipandian.com";
        $headers = "From:" . $from;
        mail($to,$subject,$message,$headers);
    }
    
    set_time_limit(0);

    if ($VERBOSITY > 0)
        print("<br>");

}


mysqli_close($con);
?>