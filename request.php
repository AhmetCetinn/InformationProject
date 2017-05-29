<?php
	if (!empty($_GET['ship'])) {
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
		if (!empty($_GET['ship'])) {
			$shipname = $_GET['ship'];
			$shipname = "%" . $shipname . "%";
			// if (isset($_POST['capacity'])) {
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
			/* } elseif (isset($_POST['route'])) {
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
			} */
		}
		
		header('Content-type: application/json');
		echo json_encode(array("result" => $result));
		
		$conn->close(); // close DB connection
		
		exit();
	}
?><!DOCTYPE html>
<html>
   <head>
      <title>MAAC LOGISTIC- Web Service</title>
      <meta charset="utf-8">
      <meta name="description" content="Traveling HTML5 Template" />
      <meta name="author" content="Destinationsgn Hooks" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Raleway:400,700" rel="stylesheet" />
      <link href="../img/favicon.png" type="image/x-icon" rel="shortcut icon" />
      <link href="../css/screen.css" rel="stylesheet" />
      <style type="text/css">
         #dvMain {
         width: 500px;
         margin-left: auto;
         margin-right: auto;
         padding: 15px;
         background-color: #FAFAFA;
         }
         .dvInner {
         border: 1px solid #ddd;
         padding: 10px;
         margin-bottom: 10px;
         }
         td {
         padding: 4px;
         }
         #divCallResult {
         border: 1px solid #ddd;
         padding: 10px;
         }
      </style>

      
   </head>
   <body class="home" id="page">
      <!-- Header -->
      <header class="main-header">
         <div class="container">
            <div class="header-content">
               <a href="../index.php">
                  <img src="../img/site-identity.png" alt="site identity" />
               </a>

               <nav class="site-nav">
                  <ul class="clean-list site-links">
                     <li>
                        <a href="../index.php">Go to Main Page</a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
      </header>

      <!-- Main Content -->
      <div class="content-box">
            <!-- Hero Section -->
            <section class="section section-hero">
               <div class="hero-box">
                  <div class="container">
                     <div class="hero-text align-center">
                        <h1>Web Service</h1>
                        <p></p>
                     </div>
                       <div id="dvMain">
         <div class="dvInner">
            <h2>Synchronous POST</h2>
            <form action="ship.php" method="POST"> 
               <table>
                  <tr>
                     <td>
                        Ship Name : 
                     </td>
                     <td>
                        <input type="text" name="shipname" id="shipname" title="Isim" />
                     </td>
                  </tr>
                  <tr><td>or</td></tr>
                  <tr>
                     <td>
                        Ship ID :
                     </td>
                     <td>
                        <input type="text" name="id" id="id" title="ID" />
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <input type="button" id="btnCallCapacity" value="Call Ship Capacity" />
                        <input type="button" id="btnCallRoute" value="Call Ship Route" />
                     </td>
                  </tr>
               </table>
            </form> 
         </div>
         
         <div class="dvInner">
            
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            
            <h2>Async POST</h2>
            <h3>Result:</h3>
            <div id="divCallResult">
               Please call the service
            </div>
         </div>
         
      </div>



                  </div>
               </div>

             

               <!-- Statistics Box -->
               <div class="container">
                  <div class="statistics-box">
                     <div class="statistics-item">
                        <span class="value">2,300</span>
                        <p class="title">Destinations</p>
                     </div>

                     <div class="statistics-item">
                        <span class="value">957</span>
                        <p class="title">Cities</p>
                     </div>

                     <div class="statistics-item">
                        <span class="value">2,870</span>
                        <p class="title">Ship&Tanker</p>
                     </div>

                     <div class="statistics-item">
                        <span class="value">50,000</span>
                        <p class="title">Sailors</p>
                     </div>
                  </div>
               </div>
            </section>
            
      </div>

      <!-- Scripts -->
      <script src="../js/jquery.js"></script>
      <script src="../js/functions.js"></script>
      <script>
         // JQuery 
         $(document).ready(function() { // when DOM is ready, this will be executed
         
         $("#btnCallCapacity").click(function(e) { // click event for "btnCallSrvc"
            
            var shipname = $("#shipname").val(); // get country cod
            
            $.ajax({ // start an ajax POST 
               type  : "post",
               url      : "ship.php",
               data  :  { 
                  shipname: shipname,
                  capacity: true
               },
               success : function(reply) { // when ajax executed successfully
                  console.log(reply);
                     $("#divCallResult").html( JSON.stringify(reply) );
                  
               },
               error   : function(err) { // some unknown error happened
                  console.log(err);
                  alert(" There is an error! Please try again. " + err); 
               }
            });
            
         });
         
         $("#btnCallRoute").click(function(e) { // click event for "btnCallRoute"
            
            var shipname = $("#shipname").val(); // get ship name
            
            $.ajax({ // start an ajax POST 
               type  : "post",
               url      : "ship.php",
               data  :  { 
                  shipname: shipname,
                  route: true // requesting route
               },
               success : function(reply) { // when ajax executed successfully
                  console.log(reply);
                     $("#divCallResult").html( JSON.stringify(reply) );
                  
               },
               error   : function(err) { // some unknown error happened
                  console.log(err);
                  alert(" There is an error! Please try again. " + err); 
               }
            });
            
         });
         
      });
      </script>
   </body>
</html>
