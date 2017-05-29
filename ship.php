<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
		
		// connect DB
		$servername = "localhost";
		$username = "MAAC";
		$password = "Maac0945";
		$dbname = "maac_logistics";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		if ($conn->connect_error) {
			die("Connection error: " . $conn->connect_error);
		}
		
		$conn->set_charset("utf8");
		
		$result = array();
		
		// read POST variables
		if (!empty($_POST['shipname'])) {
			$shipname = $_POST['shipname'];
			$shipname = "%" . $shipname . "%";
			if (isset($_POST['capacity'])) {
				// prepare, bind and execute SQL statement
				$stmt = $conn->prepare("SELECT capacity, name FROM ships WHERE name LIKE ?");
				$stmt->bind_param("s", $shipname);
				$stmt->execute();
				$stmt->bind_result($capacity, $name);
				
				while ($stmt->fetch()) {
					array_push( $result, array("capacity"=>$capacity, "name"=>$name) );
				}

				// print_r($result);
				
				$stmt->close(); // close statement
			} elseif (isset($_POST['route'])) {
				// prepare, bind and execute SQL statement
				$stmt = $conn->prepare("SELECT r.origin_point, r.destination_point, r.remain_travel_time, s.name
					FROM ships AS s 
					LEFT JOIN routes AS r ON (r.id = s.route_ID)
					WHERE s.name LIKE ?");
				$stmt->bind_param("s", $shipname);
				$stmt->execute();
				$stmt->bind_result($origin, $destination, $remain, $name);
				
				while ($stmt->fetch()) {
					array_push( $result, array("origin_point"=>$origin, "destination_point"=>$destination, "remain_travel_time" => $remain, "name" => $name) );
				}

				// print_r($result);
				
				$stmt->close(); // close statement
			}
		}

		
		header('Content-type: application/json');
		echo json_encode(array("result" => $result));
		
		$conn->close(); // close DB connection
?>