/*
 Based on SitePoint's Build Your Own AJAX Web Applications
*/

function Ajax() {
	// ------------------------------
	//       VARIABLES
	// ------------------------------	
	this.req = null;
	this.url = null;
	this.method = 'GET'; // default
	this.async = true; // the "A" in AJAX
	
	// status code and text
	this.status = null;
	this.statusText = '';
	
	// string of formated data for POST
	this.postData = null;
	
	// ------------------------------
	//       RESPONSE HANDLING
	// ------------------------------
	// loading handler (spinner)
	this.loadingHand = loading; // loading() will display a spinner in <div id="loading">
	// response handler (e.g., for writing to a div)
	this.responseHand = toDiv; // toDiv() will write via innerHTML to a target div id
	// target div id to be used with our response handler
	this.responseDiv = null;
	// format of the response
	this.responseFormat = 'text', // 'text', 'xml', or 'object'
	this.responseText = null;
	this.responseXML = null;

	// ------------------------------
	//       INITIALIZE OBJECT
	// ------------------------------	
	// The init method goes through each possible way of creating an XMLHttpRequest
	// object until it creates one successfully. This object is then returned to the calling
	// function.
	this.init = function() {
		if (!this.req) {
			try {
				// Try to create object for Firefox, Safari, IE7, etc.
				this.req = new XMLHttpRequest();
			}
			catch (e) {
				try {
					// Try to create object for later versions of IE.
					this.req = new ActiveXObject('MSXML2.XMLHTTP');
				}
				catch (e) {
					try {
						// Try to create object for early versions of IE.
						this.req = new ActiveXObject('Microsoft.XMLHTTP');
					}
					catch (e) {
						// Could not create an XMLHttpRequest object.
						return false;
					}
				}
			}
		}
		return this.req;
	};

	// ------------------------------
	//       AJAX REQUEST PROCESS
	// ------------------------------	
	// This first part of doReq calls init to create an instance of the XMLHttpRequest
	// class, and displays a quick alert if it’s not successful.
	this.doReq = function() {
		if (!this.init()) {
			alert('Could not create XMLHttpRequest object.');
			return;
		}
		// Next, our code calls the open method on this.req—our new instance of the
		// XMLHttpRequest class—to begin setting up the HTTP request:
		//
		// method: GET, POST
		// url: requested (or POSTed) page
		// async: work asynchronously if set to true
		this.req.open(this.method, this.url, this.async);
		
		// in case we POST data via doPost()
		if (this.method == "POST") {
			// change headers
			this.req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		}
		
		var self = this; // Fix loss-of-scope in inner function
		// An XMLHttpRequest object tells you about each change in state by firing an
		// readystatechange event
		this.req.onreadystatechange = function() {
			var resp = null;
			// completed: the response has been loaded and the request is completed.
			if (self.req.readyState == 4) {
                                // remove the spinner class first
				//document.getElementById('loading').innerHTML = '';
				
				// Provide response in different formats:
				switch (self.responseFormat) {
					case 'text':
						resp = self.req.responseText; // JavaScript string
						break;
					case 'xml':
						resp = self.req.responseXML; // XML document object
						break;
					case 'object':
						resp = req;
						break;
				}
				// a code indicating whether or not the request succeeded is returned in
				// the status property of our XMLHttpRequest object.
				// Between 200 and 299 inclusive is a successful response:
				if (self.req.status >= 200 && self.req.status <= 299) {
					//self.handleResp(resp); // handle with response handler method
					self.responseHand(self.responseDiv, resp)
				} else {
					//self.errorHand(resp);
				}
			}
			// interactive: the response is being downloaded, responseText holds partial data
			if (self.req.readyState == 3) {
			}
			// loaded: send has been called, but the response is not yet available
			if (self.req.readyState == 2) {
				// seems to work well in Opera
				//self.loadingHand();
			}
			// loading: send has not been called yet
			if (self.req.readyState == 1) {
				// add a class with a spinner
				//self.loadingHand();
			}
			// uninitialized: open has not been called yet
			if (self.req.readyState == 0) {
				// Do stuff to handle response
			}
		};
		
		// Use the send method of the XMLHttpRequest class to start the HTTP request:
		this.req.send(this.postData);
	
	};

	// ------------------------------
	//       GET & POST REQUESTS
	// ------------------------------	
	// To make a request we set the url and handler
	// url: target URL
	// target: a target div id for the response
	// format: default text (can pass object or xml as well)
	this.doGet = function(url, targetDiv, format) {
		this.url = url;
		this.responseDiv = targetDiv;
		this.responseFormat = format || 'text';
		this.doReq();
	};

	// For POSTing of data
	this.doPost = function(url, formName, targetDiv, format) {
		this.url = url; // target URL
		this.responseDiv = targetDiv; // target: a target div id for the response
		this.responseFormat = format || 'text'; // text (xml, object)
		this.method = 'POST'; // change to POST so that we can alter the headers appropriately in doReq()
		this.postData = this.formString(document.getElementById(formName)); // format form data to a string
		this.doReq();
	};

	// ------------------------------
	//       ERROR HANDLING
	// ------------------------------	
	// This method checks to make sure that pop-ups are not blocked, then tries to
	// display the full text of the server’s error page content in a new browser window.
	this.errorHand = function() {
		var errorWin;
		try {
			errorWin = window.open('', 'errorWin');
			errorWin.document.body.innerHTML = this.responseText;
		}
		catch (e) {
			alert('Error\n'
			      + 'Status Code: ' + this.req.status + '\n'
			      + 'Status Description: ' + this.req.statusText);
		}
	};
	
	// This method changes the onreadystate event handler to an empty function,
	// calls the abort method on your instance of the XMLHttpRequest class, then destroys
	// the instance you’ve created.
	this.abort = function() {
		if (this.req) {
			this.req.onreadystatechange = function() { };
			this.req.abort();
			this.req = null;
		}
	};

	// ------------------------------
	//       FORM POST STRING
	// ------------------------------		
	// a helper function that will create a key-value pair from form data so that we can POST it
	// source: form name
	this.formString = function(formName) {
		var result = ''; // hold the resulting string
		var fieldsNumber = formName.elements.length; // get the number of fields
		// go through all the form fields
		for (i = 0; i < fieldsNumber; i++) {
			formElem = formName.elements[i]; // get the form element
			switch (formElem.type) {
				case 'checkbox':
					if (formElem.checked) {
						result += formElem.name + '=' + escape(formElem.value);
					}
					break;
				default:
					// form 'name=value' pair
					result += formElem.name + '=' + escape(formElem.value);
			}
			// add '&' symbol if we have more data to add
			if (i < fieldsNumber) {
				result += '&';
			}
		}
		return result;
	}
}

// ------------------------------
//       HANDLERS
// ------------------------------	
// handler that will write the result 'str' into <div id="'id'">
var toDiv = function(id, str) {
	// check if we are reloading maybe?
        if (str == "location.reload(true)") { location.reload(true); }
        // write the text
	else document.getElementById(id).innerHTML = str;
}

// handler function that will add some effects to 'loading' status display
var loading = function() {
	document.getElementById('loading').innerHTML = '<span class="loading">Loading</span>';
}

// show/hide target div
var toggle = function(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'block')
		e.style.display = 'none';
	else
		e.style.display = 'block';
}

// ------------------------------
//       INSTANTIALIZE
// ------------------------------	
// make and instance of Ajax class
var ajax = new Ajax();