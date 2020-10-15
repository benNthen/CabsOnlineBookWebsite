// file xhr.js

// return a valid XHR object

 function createRequest() {
    
	var xhr = false;  
    
	if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
	
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
	
} // end function createRequest()
