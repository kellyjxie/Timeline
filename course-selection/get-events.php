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

if (isset($_POST['course']) && isset($_POST['date'])) {
    $course = $_POST['course'];
    $date = $_POST['date'];
}

// MAE 6250 (id=2) and 1497931200 have events and activities results

$events = "SELECT CB.ID, CB.cID, CB.dC, CB.dN, CB.dD, RCD.sT
FROM roca_code_bank CB 
INNER JOIN roca_collection_data RCD ON RCD.bID = CB.id
INNER JOIN roca_collections RC ON RCD.cID = RC.id
INNER JOIN roca_collection_assignments RCA ON RCA.id = RC.aID
INNER JOIN system_courses SC ON SC.id = RCA.cID
WHERE RCA.oDY = $date AND SC.ID = $course AND RCD.eT = 0";

// SELECT CB.ID, CB.cID, CB.dC, CB.dN, CB.dD, RCD.sT 
// FROM roca_code_bank CB 
// INNER JOIN roca_collection_data RCD ON RCD.bID = CB.id 
// INNER JOIN roca_collections RC ON RCD.cID = RC.id 
// INNER JOIN roca_collection_assignments RCA ON RCA.id = RC.aID 
// INNER JOIN system_courses SC ON SC.id = RCA.cID 
// WHERE RCA.oDY = 1497931200 AND SC.ID = 2 AND RCD.eT = 0


$result = $conn->query($events);

if ($result -> num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        extract($row);
        $s = new Datetime("@$sT");
        $s->format('m-d-Y H:i:s');

        $encode[] = array('name'=>$dN, 'description'=>$dD, 'displayCode'=>$dC, 'startTime'=>$s, 'unixStart'=>$sT);
    }

    $encode_export = array('events_data'=>$encode);
	echo json_encode($encode_export);

    

} else {
    echo 'No results';
}


$conn->close();

?>