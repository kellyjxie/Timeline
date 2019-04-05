<?php 

$servername = "localhost";
$username = "root";
$password = "";
// $password = "pwdpwd";
$dbname = "dots2";

// create connection to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error) {
	die("Unable to connect to DB: " . $conn -> connect_error);
}


if (isset($_POST['course'])) {
    $courseID = $_POST['course'];
}

$courseODates = "SELECT RCA.oDY FROM system_courses SC 
INNER JOIN roca_collection_assignments RCA ON SC.ID = RCA.cID
INNER JOIN roca_collections RC ON RC.aID = RCA.id WHERE SC.ID = $courseID";

// $courseODates = "SELECT RCA.oDY FROM system_courses SC 
// INNER JOIN roca_collection_assignments RCA ON SC.ID = RCA.cID
// INNER JOIN roca_collections RC ON RC.aID = RCA.id WHERE SC.ID = 2";

$result = $conn->query($courseODates);

if ($result -> num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        extract($row);

        $oDate = new Datetime("@$oDY");
        $oDate->format('m-d-Y H:i:s');
        $export[] = array("unixTime"=>$oDY, "oDate"=>$oDate);
    }
    
    echo json_encode($export);

} else {
    echo 'No results';
}


$conn->close();

?>