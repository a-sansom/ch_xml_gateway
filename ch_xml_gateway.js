// Define the module namespace
var ch_xml_gateway = {};

// If there's enough javascript support...
if(Drupal.jsEnabled) {
  // Wait until doc has finished loading...
  $(document).ready(
    function(){
      // DOM modifications
	  // For each link to officer details, adjust the href to call the JSON module function
      $('.officer-details-link').each(function(index) {
	    // Handle a click on the link, cancelling its navigation and  call the JSON function
		$(this).bind('click', {'odLink': $(this).attr('href'), 'apptIndex': index}, function(event) {
		  // Don't execute the link navigation
		  event.preventDefault();
		  // Format the URL to use module JSON function
          jsonUrl = ch_xml_gateway.json_url(event.data.odLink);
		  // Clear any previously set information
		  if ($('#selected-appointment-detail').children().length > 0) {
		    $('#selected-appointment-detail').empty();
		  }
		  if (Drupal.settings.ch_xml_gateway.access_officer_details) {
			  // Show a status of what's happening, to the user
			  $('#selected-appointment-detail').html('<div style="position: relative; margin-top:' + ch_xml_gateway.selected_index_top(event.data.apptIndex) + 'px;">Waiting for Companies House...</div>');
			  // Call the json returning URL to get data to display
			  ch_xml_gateway.exec_json(jsonUrl, event.data.apptIndex);
		  }
		  else {
		    $('#selected-appointment-detail').html('<div style="position: relative; margin-top:' + ch_xml_gateway.selected_index_top(event.data.apptIndex) + 'px;">Access denied.</div><div>You need to be granted permission to use the service by an administrator.</div>');
		  }
        })
      });
    }
  );
  
  // Find the 'top' position for the appoitnment element that was clicked
  // TODO: All of this should probably go in a modal window or similar
  ch_xml_gateway.selected_index_top = function(index) {
    oneBasedIndex = index + 1; // +1 so that we're operating a one-based index matching the tpl.php
	selectedIndexOffsetTop = $('.appointment-' + oneBasedIndex).offset().top;
	resultsContainerOffsetTop = $('#search-results').offset().top;
	return selectedIndexOffsetTop - resultsContainerOffsetTop;
  }
  
  // Format link URL so that it points to the JSON version
  ch_xml_gateway.json_url = function(link) {
    linkParts = link.split('/');
	jsonLink = Drupal.settings.ch_xml_gateway.json_url_stub + '/' + linkParts[2] + '/' + linkParts[3];
	return jsonLink;
  }
  
  // Execute submission to get JSON data
  ch_xml_gateway.exec_json = function(url, apptIndex) {
	$.get(url, function(data) {
	  appointmentData = Drupal.parseJson(data);
	  if (!appointmentData.status || appointmentData.status == 0) {
	    markup = '';
	    if (appointmentData.error) {
		  markup = '<div id="json-error">' + appointmentData.error + '</div>';
		} 
		else {
	      companies = appointmentData.company;
		  markup = '<div id="dynamic-appointments-container" style="position: relative; margin-top:' + ch_xml_gateway.selected_index_top(apptIndex) + 'px;">';
		  // markup = '<div id="dynamic-appointments-container">';
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
		$('#selected-appointment-detail').html(markup);
	  }
	});
  }
}