(function ($) {
  Drupal.behaviors.chXmlGateway = {
    attach: function (context, settings) {
      $('.officer-details-link').each(function(index) {
        var data = {'odLink': $(this).attr('href'), 'apptIndex': index};
        $(this).bind('click', data, function(event) {
          // Don't execute the link navigation
          event.preventDefault();
          // Format the URL to use module JSON function
          jsonUrl = chXmlGateway.jsonUrl(event.data.odLink);
          // Clear any previously set information
          if ($('#selected-appointment-detail').children().length > 0) {
            $('#selected-appointment-detail').empty();
          }
          // If user has been granted access to service, get officer details
          // (permission also checked in module on menu callback to prevent
          // circumventing permissions by tampering with script in browser)
          if (Drupal.settings.chXmlGateway.accessOfficerDetails) {
            // Show a status of what's happening, to the user, in a dialog
            var markup = '<p>Waiting for Companies House...</p>';
            $('#selected-appointment-detail').html(markup).dialog({
              modal: true,
              height: 400,
              width: 400,
              title: 'Other appointments for this person are:'
            });
            // Call the json returning URL to get data, display in the already
            // open dialog
            chXmlGateway.execJson(jsonUrl, event.data.apptIndex);
          }
          else {
            var markup = '<p>You need to be granted permission to use the '
             + 'service by an administrator.</p>';
            $('#selected-appointment-detail').html(markup).dialog({
              modal: true,
              title: 'Access denied'
            });
          }
        });
      });
    }
  };

  // Module namespace
  var chXmlGateway = {
    // Format link URL so that it points to the JSON version
    jsonUrl: function(link) {
      linkParts = link.split('/');
      jsonLink = Drupal.settings.chXmlGateway.jsonUrlStub + '/' + linkParts[2]
        + '/' + linkParts[3];

      return jsonLink;
    },

    // Execute submission to get JSON data
    execJson: function(url, apptIndex) {
      $.get(url, function(data) {
        apptData = $.parseJSON(data);
        if (!apptData.status || apptData.status == 0) {
          markup = '';
          if (apptData.error) {
            markup = '<div id="json-error">' + apptData.error + '</div>';
          }
          else {
            companies = apptData.company;
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
          $('#selected-appointment-detail').html(markup);
        }
      });
    },
  };
})(jQuery);
