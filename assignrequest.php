<?php
//require_once('-');
	$conn = mysqli_connect($sql_host,
		$sql_user,
		$sql_pswd,
		$sql_dbnm
		);

	if (!$conn) {
		// Displays an error message
		ECHO "<span class='form-error'> Connection failed. </span>";
	} 

	else{
			//Checks if the 'zvx8490' database schema exists inside the myPHP admin directory
			$db_exist = mysql_select_db($sql_dbnm, $conn);
		
			if(!db_exist){ //Display error message if 'zvx8490' is not found
				ECHO "<span class='form-error'> Error. Database table '$sql_dbnm' does not exist. Please check your MyPHPAdmin account and try again. </span>";
			}
		
			else{
				
				//Checks for the 'taxi' database table existence inside 'zvx8490' directory ising this sqlquery
				$exists = @mysql_query($conn, "SELECT * FROM taxi");
			
				if(mysqli_num_rows($exists)<0){ //Display error message if table not found
					ECHO "<span class='form-error'> Error. The database table for 'taxi' was not found in the '$sql_dbnm' 's database. Please check your MyPHPAdmin account and try again. </span>";
				}
				
				else{
						$request = $_POST['request']; // Get input data from the search box
			
						if(!$request || trim($request) == '') { // Checks if user entered data into the search box, otherwise displays error message 
							ECHO "<span class='form-error'>Error. No valid input detected. Please try again.</span>"; 
						}
				
						else{
				
				
						//SQL statement used to check if particular booking does not already have a taxi assigned to it
						$sql_c = "SELECT * FROM taxi WHERE book_id = '$request' AND assign_status = 1";
						$res_c = @mysqli_query($conn, $sql_c);
					
						if(mysqli_num_rows($res_c) > 0){ // if found, notify user that a taxi had already been assigned to that booking number
						ECHO "<span class='form-success'>A taxi has already been assigned the entered ID# $request. Please enter another number and try again.</span>";
						}
					
						else{
								//SQL statement used to assign a taxi to that particular booking
								$query = "UPDATE taxi SET assign_status = 1 WHERE book_id = '$request%';"; 
		
								$queryresult = @mysqli_query($conn, $query);// executes the query and store result into the result pointer
			 
								if(!$queryresult){ //Checks if query was successful, if not an error message is displayed
								ECHO "<span class='form-error'>Taxi assignment failed for Booking ID# - '$request'". mysqli_errno($conn)."</span>";
								}
							
								else{
								
									//Final check to ensure that a taxi was recently assigned to that booking entry
									$query3 = "SELECT * FROM taxi WHERE book_id = '$request' AND assign_status = 1";
									$res_d = @mysqli_query($conn, $query3);
								
									if(mysqli_num_rows($res_d) >= 1){ // Display message to user that assignment was successful
										ECHO"<span class='form-success'>The booking request for Booking ID# '$request' was successful. </span>";
									}
								else{ //Display error message if taxi assignment was unsuccessful
									ECHO"<span class='form-error'>The booking request for Booking ID# '$request' failed. Please re-check the database and try again. </span>";
								}
							}
						}
							
					}
				}
		}
	}
		mysqli_free_result($queryresult);// Free query operation
	// Close the database connection
	mysqli_close($conn);
?>