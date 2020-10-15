var xhr = createRequest();

function getData(dataSource, divID, aName, aPhone, aAdd, aDes, aDate)  {
	
    if(xhr) {
				var obj = document.getElementById(divID);
		
				var requestentry = 'name='+encodeURIComponent(aName)+'&phone='+encodeURIComponent(aPhone)+'&address='+encodeURIComponent(aAdd)+'&des='+encodeURIComponent(aDes)+'&date='+encodeURIComponent(aDate);
		
				console.log(requestentry);
				
				xhr.open("POST", dataSource, true);
				
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    
				xhr.onreadystatechange = function() {
				
				alert(xhr.readyState); //to let us see the state of the computation
				
				if (xhr.readyState == 4 && xhr.status == 200) {
					obj.innerHTML = xhr.responseText;
					
					} // end if
				} // end anonymous call-back function
	    xhr.send(requestentry);
		} // end if
} // end function getData()