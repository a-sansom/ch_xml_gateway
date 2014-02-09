<?php if ($error): ?>
 <p>
   Error: <?php print $error ?>
 </p>
<?php endif; ?>

<?php if ($companyAppointments): ?>
<div id="search-results">
  <!-- Placeholder to hold dynamic appointments content -->
  <div id="selected-appointment-detail"></div>
  
  <div id="search-results-matches">
    <!-- Meta info -->
    <div id="search-results-meta">
      <div>
        Company name: <?php print $companyAppointments['company_name'] ?>
      </div>
      <div>
        Company number: <?php print $companyAppointments['company_number'] ?>
      </div>
      <div>
        Has inconsistencies: <?php print $companyAppointments['has_inconsistencies'] ?>
      </div>
      <div>
        No. current appointments: <?php print $companyAppointments['num_current_appt'] ?>
      </div>
      <div>
        Search rows: <?php print $companyAppointments['search_rows'] ?>
      </div>
      <div>
        Continuation key: <?php print $companyAppointments['continuation_key'] ?>
      </div>
    </div>

    <!-- Actual appointment info -->
    <div id="company-appointments">
    <?php
      $index = 0;
      foreach ($companyAppointments['appointments'] AS $appointment):
        $index++;
    ?>
      <div class="appointment appointment-<?php print $index ?> <?php ($index % 2 == 0) ? print 'even' : print 'odd' ?>">
        <?php // Base 64 encode the officer id so various chars, such as '+', don't get URL encoded ?>
        <div>
          <span class="label">Name: </span><?php print l($appointment['title'] . ' ' . $appointment['forename'] . ' ' . $appointment['surname'], 'chxmlgw/officer-details/' . base64_encode($appointment['person_id']), array('attributes' => array('title' => t('See more detailed information about this person'), 'class' => array('officer-details-link')))); ?>
        </div>
        <?php if (!empty($appointment['honours'])): ?>
          <div>
            <span class="label">Honours: </span><?php print $appointment['honours'] ?>
          </div>
        <?php endif; ?>
        <div>
          <span class="label">DOB: </span><?php print $appointment['dob'] ?>
        </div>
        <?php if (!empty($appointment['nationality'])): ?>
          <div>
            <span class="label">Nationality: </span><?php print $appointment['nationality'] ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($appointment['country_of_residence'])): ?>
          <div>
            <span class="label">Country of residence: </span><?php print $appointment['country_of_residence'] ?>
          </div>
        <?php endif; ?>
        <div>
          <span class="label">Occupation: </span><?php print $appointment['occupation'] ?>
        </div>
        <div>
          <span class="label">Appointment date: </span><?php print $appointment['appointment_date'] ?>
        </div>
        <?php if (!empty($appointment['appointment_date_prefix'])): ?>
          <div>
            <span class="label">Appointment date prefix: </span><?php print $appointment['appointment_date_prefix'] ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($appointment['resignation_date'])): ?>
          <div>
            <span class="label">Resignation date: </span><?php print $appointment['resignation_date'] ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($appointment['appointment_type'])): ?>
          <div>  
            <span class="label">Appointment type: </span><?php print $appointment['appointment_type'] ?>
          </div>
        <?php endif; ?>
        <div>
          <span class="label">Appointment status: </span><?php print $appointment['appointment_status'] ?>
        </div>
        <div>
          <span class="label">Number of appointments: </span><?php print $appointment['number_of_appointments'] ?>
        </div>
        <div>
          <span>Address:</span>
          <div>
            <?php print $appointment['address']['address_line'] ?>
          </div>
          <div>
            <?php print $appointment['address']['post_town'] ?>
          </div>
          <div>
            <?php print $appointment['address']['county'] ?>
          </div>
          <div>
            <?php print $appointment['address']['country'] ?>
          </div>
          <div>
            <?php print $appointment['address']['postcode'] ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>