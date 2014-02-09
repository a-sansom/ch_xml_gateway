// Define the module namespace
var ch_xml_gateway = {};

// D7 removed Drupal.jsEnabled()...
// Wait until doc has finished loading...
jQuery(document).ready(
  function(){
    // DOM modifications
    // For each link to officer details, adjust the href to call the JSON module function
    jQuery('.officer-details-link').each(function(index) {
	  // Handle a click on the link, cancelling its navigation and  call the JSON function
	  jQuery(this).bind('click', {'odLink': jQuery(this).attr('href'), 'apptIndex': index}, function(event) {
	    // Don't execute the link navigation
	    event.preventDefault();
	    // Format the URL to use module JSON function
	    jsonUrl = ch_xml_gateway.json_url(event.data.odLink);
	    // Clear any previously set information
	    if (jQuery('#selected-appointment-detail').children().length > 0) {
		  jQuery('#selected-appointment-detail').empty();
	    }
		// If user has been granted access to service, get officer details (permission also checked 
		// in module on menu callback to prevent circumventing permissions by tampering with script in browser)
	    if (Drupal.settings.ch_xml_gateway.access_officer_details) {
		  // Show a status of what's happening, to the user, in a dialog
		  jQuery('#selected-appointment-detail').html('<p>Waiting for Companies House...</p>').dialog({
		    modal: true,
            height: 400,
            width: 400,
            title: 'Other appointments for this person are:'
		  });
		  // Call the json returning URL to get data, display in the already open dialog
		  ch_xml_gateway.exec_json(jsonUrl, event.data.apptIndex);
	    }
	    else {
		  jQuery('#selected-appointment-detail').html('<p>You need to be granted permission to use the service by an administrator.</p>').dialog({
		    modal: true,
            title: 'Access denied'
		  });
	    }
	  });
    });
  }
);

// Format link URL so that it points to the JSON version
ch_xml_gateway.json_url = function(link) {
  linkParts = link.split('/');
  jsonLink = Drupal.settings.ch_xml_gateway.json_url_stub + '/' + linkParts[2] + '/' + linkParts[3];
  return jsonLink;
};

// Execute submission to get JSON data
ch_xml_gateway.exec_json = function(url, apptIndex) {
  jQuery.get(url, function(data) {
    appointmentData = jQuery.parseJSON(data);
    if (!appointmentData.status || appointmentData.status == 0) {
	  markup = '';
	  if (appointmentData.error) {
	    markup = '<div id="json-error">' + appointmentData.error + '</div>';
	  } 
	  else {
	    companies = appointmentData.company;
	    markup = '<div id="dynamic-appointments-container">';
	    for (var key in companies) {
		  companyNumber = String(key);
		  markup += '<div class="dynamic-appointment-appointments-company-header">Company:</div>';
		  markup += '<div class="dynamic-appointment-company-name"><a href="/chxmlgw/company-details/' + companyNumber + '">' + companies[companyNumber].name + '</a> (' + companies[companyNumber].status + ')</div>';
		  markup += '<div class="dynamic-appointment-appointments-header">Appointments:</div>';
		  for (var i=0;i<companies[companyNumber].appointment.length;i++) {
		    markup += '<div class="dynamic-appointment-detail">';
		    markup += '<div>Type:' + companies[companyNumber].appointment[i].type + '</div>';
		    markup += '<div>Status:' + companies[companyNumber].appointment[i].status + '</div>';
		    markup += '<div>Date:' + companies[companyNumber].appointment[i].date + '</div>';
		    markup += '<div>Occupation:' + companies[companyNumber].appointment[i].occupation + '</div>';
		    markup += '</div>';
		  }
	    }
	    markup += '</div>';
	  }
	  // Insert the created markup into the document
	  jQuery('#selected-appointment-detail').html(markup);
    }
  });
};