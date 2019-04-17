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

if (isset($_POST['course']) && isset($_POST['course'])) {
    $course = $_POST['course'];
    $date = $_POST['date'];
}


$intervals = "SELECT CB.ID, CB.cID, CB.dC, CB.dN, CB.dD, RCI.sT, RCI.ioID
FROM roca_code_bank CB
INNER JOIN roca_collection_interval RCI ON RCI.cID = CB.id
INNER JOIN roca_collection_data RCD ON RCD.bID = CB.id
INNER JOIN roca_collections RC ON RCD.cID = RC.id
INNER JOIN roca_collection_assignments RCA on RCA.id = RC.aID
INNER JOIN system_courses SC ON SC.id = RCA.cID
WHERE RCA.oDY = $date AND SC.ID = $course";

// $intervals = "SELECT CB.ID, CB.cID, CB.dC, CB.dN, CB.dD, RCI.sT, RCI.ioID
// FROM roca_code_bank CB
// INNER JOIN roca_collection_interval RCI ON RCI.cID = CB.id
// INNER JOIN roca_collection_data RCD ON RCD.bID = CB.id
// INNER JOIN roca_collections RC ON RCD.cID = RC.id
// INNER JOIN roca_collection_assignments RCA on RCA.id = RC.aID
// INNER JOIN system_courses SC ON SC.id = RCA.cID
// WHERE RCA.oDY = 1497931200 AND SC.ID = 2";




$result = $conn->query($intervals);

if ($result -> num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        extract($row);
        $s = new Datetime("@$sT");
        $s->format('m-d-Y H:i:s');

        $export[] = array('codebankID'=>$ID,'name'=>$dN, 'description'=>$dD, 'displayCode'=>$dC, 
        'startTime'=>$s, 'unixStart'=>$sT, 'RI,ioID'=>$ioID);
    }

    $encode_export = array('intervals_data'=>$export);
	echo json_encode($encode_export);

} else {
    echo 'No results';
}


$conn->close();

?>