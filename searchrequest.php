<?php
//require_once('-');
	$conn = mysqli_connect($sql_host,
		$sql_user,
		$sql_pswd,
		$sql_dbnm
		);

	if (!$conn) {
		// Displays an error message if connection failed
		ECHO "<span class='form-error'> Connection failed. </span>";
	} 

	else{
		
			$request = $_POST['request']; // Get input data from the admin.html form
			
			if(!$request || trim($request) == '') { // Checks if user entered data into the search box, otherwise displays error message 
					ECHO "<span class='form-error'>Error. No valid input detected. Please try again.</span>"; 
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
				
									$query = "SELECT * FROM taxi "  // Set up the SQL command to retrieve the data matching reference number from the database
											. "WHERE book_id LIKE '$request%' AND assign_status = 0 AND pickup_date >= DATE_SUB(NOW(), INTERVAL 2 HOUR)";
		
									$result = @mysqli_query($conn, $query);// executes the query and store result into the result pointer
					
									if(mysqli_num_rows($result) == 0){ //Checks if query did not return zero matches
										ECHO "<span class='form-error'>Sorry but your search for Booking ID# '$request' - did not match any unassigned requests. Please try another number.</span>";
									}
						
									else{	
											//If query has found matches in search, then display the results table 
											ECHO"<span class='form-success'>Your search - '$request' - returned ". mysqli_num_rows($result). " match(es). </span> <br> <br>";
							
											echo "<span class='form-success'><table border=\"1\">";
											echo "<tr>\n"
											."<th scope=\"col\">Booking Reference Number</th>\n"
											."<th scope=\"col\">Customer Name</th>\n"
											."<th scope=\"col\">Contact Phone</th>\n"
											."<th scope=\"col\">Pick-Up Address</th>\n"
											."<th scope=\"col\">Destination Suburb</th>\n"
											."<th scope=\"col\">Time of Booking</th>\n"
											."<th scope=\"col\">Time of Pick-Up    </th>\n"
											."<th scope=\"col\">Taxi Assigned</th>\n"
											."</tr>\n </span>";
							
											while ($row = mysqli_fetch_assoc($result)){//retrieve and place matching status message with all its attributes to the results table
													echo "<tr>";
													echo "<td>",$row["book_id"],"</td>";
													echo "<td>",$row["name"],"</td>";
													echo "<td>",$row["phone"],"</td>";
													echo "<td>",$row["addr"],"</td>";
													echo "<td>",$row["dest"],"</td>";
													echo "<td>",(date('d/m/y H:i a', strtotime($row["book_date"]))),"</td>"; 
													echo "<td>",(date('d/m/y H:i a', strtotime($row["pickup_date"]))),"</td>";
													echo "<td>",($row["assign_status"] ? 'Yes': 'No'),"</td>";
													echo "</tr>";
												}
											echo "</table>";
									}
									mysqli_free_result($result);// Free query operation
								}
							}	
				}
	}
		
	// Close the database connection
	mysqli_close($conn);
?>