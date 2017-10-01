function ajaxUpdateArea(link, target, func) {
	//alert('fdf');
	var ajaxRequest;
	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.open("GET", link, true);
	ajaxRequest.send(null);

	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {
			var ajaxDisplay = document.getElementById(target);
			if (ajaxRequest.responseText == '') {
				ajaxDisplay.innerHTML = 'Result not found.';
			} else {
				ajaxDisplay.innerHTML = ajaxRequest.responseText;
				setTimeout(func, 1);
			}
		} else {
			document.getElementById(target).innerHTML = "waiting..";
		}
	}
}