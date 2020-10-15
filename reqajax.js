// file reqajax.js
var xhr = createRequest();

function getReq(dataSource, divID, aBook)  {
	
    if(xhr) {
				var place = document.getElementById(divID);
				
				var url = 'request='+encodeURIComponent(aBook);
				
				xhr.open("POST", dataSource, true);
				
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
				xhr.onreadystatechange = function() {
					
				alert(xhr.readyState);
					
						if (xhr.readyState == 4 && xhr.status == 200) {
							place.innerHTML = xhr.responseText;
					} // end if
				} // end anonymous call-back function
				xhr.send(url);
			} // end if
} // end function getRata()


