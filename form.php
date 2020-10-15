<?php
//require_once('-');
	$conn = mysqli_connect($sql_host,
		$sql_user,
		$sql_pswd,
		$sql_dbnm
		);

	if (!$conn) {
		// Displays an error message
		echo "<span class='form-error'> Connection failed. </span>";
	} 

	else{

			//Get the mandatory inputs from booking.html
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$addr= $_POST['address'];
			$dest= $_POST['des'];
			$date_time= mysqli_real_escape_string($conn, $_POST['date']);
			
			//A pick-up date & time by the taxi is generated based on the valid date received
			$date = date("Y-m-d H:i:s", strtotime($date_time));
							
			//Variables prepared for ticket print
			$pickupDate = date("Y-m-d H:i:s", strtotime ($date."+25 minutes")); // 25 minutes is allocated to date-time entered
			$setTime = date("H:i A",strtotime($pickupDate)); 
			$setDate = date("M j, Y",strtotime($pickupDate));
			$setDay = date("l",strtotime($pickupDate));
			
			//Check if name received is valid and not null otherwise display error
			if(!isset($name)|| trim($name) == ''){
				ECHO"<span class='form-error'> Name received is invalid.</span>";
			}
			else{
				$name2 = $name; //Valid data is prepared in a new variable
			}
					
			//Check if phone received is valid and not null otherwise display error
			if(!is_numeric($phone) || strlen($phone)< 7){
				ECHO"<span class='form-error'> Phone number received is invalid. </span>";
			}
			else{			
				$phone2 = $phone;
			}
		
			//Check if pick-up address received is valid and not null otherwise display error
			if(!isset($addr)|| trim($addr) == ''){
				ECHO"<span class='form-error'> Pick-up address received is invalid. </span>";
			}
			else{	
				$addr2 = $addr;
		    }
					
			//Check if destination address received is valid and not null otherwise display error
			if(!isset($dest)|| trim($dest) == ''){
				ECHO"<span class='form-error'> Destination address received is invalid.</span>";
			}	
			else{	
				$dest2 = $dest;
			}
			
			//Notify client on booking.html page to try again as one or more entries received were invalid
			if(empty($name2) || empty($phone2)|| empty($addr2)|| empty($dest2) || empty($date) || empty($pickupDate)){
				ECHO"<span class='form-error'> Error. Fill in all fields with appropriate entries and try again! </span>";
			}
			
			else{
					//Allow application to load for 5 seconds while retrieving data
					sleep(5);
					
					//Prepare an SQL that saves the passenger details into the taxi database
					$sqlString = "INSERT INTO taxi(name, phone, addr, dest, book_date, pickup_date, assign_status) VALUES('$name2','$phone2','$addr2','$dest2','$date','$pickupDate',0);";
					  
					$queryResult = @mysqli_query($conn, $sqlString);
					
					if(!$queryResult){ //Checks if query was successful otherwise an error message is displayed
						ECHO"<span class='form-error'> Error details were not saved. Please try again.</span>";
					}
				
					else{ 
							//Displays message indicating that user's input is now recorded into the database
							ECHO"<span class='form-success'> Registration successful! Printing ticket.....</span>";
					
							//SQL statement check to ensure that the booking already exists inside the database to avoid duplication
							$sql_b = "SELECT * FROM taxi WHERE book_date = '$date'";
					
							$queryID = @mysqli_query($conn, $sql_b);
						
							if(mysqli_num_rows($queryID) == 0){ //Display error if query failed to find recently entered input
								ECHO"<span class='form-error'> Printing failed. Please check your PHP code and try again! </span>";
							}
						
							else{	
									//Prints the content of the recently entered input into a statement resembling a ticket
									while($row = mysqli_fetch_assoc($queryID)) {
												
										ECHO"<span class='form-success'> Thank you! Your reference number is #".$row['book_id'] 
											." You will be picked up in front of your provided address at '$setTime' on '$setDay' '$setDate'.</span>";
									}
							}
								
							mysqli_free_result($queryID);// Free query operation
						}
					mysqli_free_result($queryResult);
				}
	}
	
	mysqli_close($conn);// Close the database connection
?>