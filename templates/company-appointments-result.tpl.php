<?php 
/**
 * @file
 * Display results of a CompanyAppointments search.
 *
 * Available variables:
 * - $error: Error message indicating that the gateway search failed.
 * - $company_appointments: Array of company information from gateway search containing:
 * - $company_appointments['company_name']: Company appointment is for.
 * - $company_appointments['company_number']: Company number of the company that appointment is for.
 * - $company_appointments['has_inconsistencies']: Indicates that the Companies House company record is marked as having inconsistencies.
 * - $company_appointments['num_current_appt']: Number of appointments that the company has.
 * - $company_appointments['search_rows']:
 * - $company_appointments['continuation_key']:
 * - $company_appointments['appointments']: Array of appointment(s) information, including:
 * - $appointment['index']: One-based index value.
 * - $appointment['title']: Appointment title.
 * - $appointment['forename']: Appointment first name.
 * - $appointment['surname']: Appointment last name.
 * - $appointment['person_id']: Appointment Companies House identifier.
 * - $appointment['person_id_base64']: Base 64 encoded person_id. For use in links.
 * - $appointment['honours']:
 * - $appointment['dob']: Appointment date of birth.
 * - $appointment['nationality']: Appointment nationality.
 * - $appointment['country_of_residence']: Appointment country of residence.
 * - $appointment['occupation']: Appointment occupation.
 * - $appointment['appointment_date']: Date of appointment.
 * - $appointment['appointment_date_prefix']:
 * - $appointment['resignation_date']: Date of appointment resignation, if applicable.
 * - $appointment['appointment_type']: Type of appointment. Director/Secretary etc.
 * - $appointment['appointment_status']: Appointment status indicator.
 * - $appointment['number_of_appointments']: Number of appointments held by person.
 * - $appointment['address']['care_of']: Appointment address detail.
 * - $appointment['address']['po_box']: Appointment address detail.
 * - $appointment['address']['address_line']: Appointment address detail.
 * - $appointment['address']['post_town']: Appointment address detail.
 * - $appointment['address']['county']: Appointment address detail.
 * - $appointment['address']['country']: Appointment address detail.
 * - $appointment['address']['postcode']: Appointment address detail.
 *
 * @see template_preprocess_company_appointments_result().
 *
 * @ingoup themeable
 */
?>
<?php if ($error): ?>
 <p>
   Error: <?php print $error ?>
 </p>
<?php endif; ?>

<?php if ($company_appointments): ?>
<div id="search-results">
  <!-- Placeholder for dynamic appointments -->
  <div id="selected-appointment-detail"></div>

  <div id="search-results-matches">
    <div id="search-results-meta">
      <div>
        Company name: <?php print $company_appointments['company_name'] ?>
      </div>
      <div>
        Company number: <?php print $company_appointments['company_number'] ?>
      </div>
      <div>
        Has inconsistencies: <?php print $company_appointments['has_inconsistencies'] ?>
      </div>
      <div>
        No. current appointments: <?php print $company_appointments['num_current_appt'] ?>
      </div>
      <div>
        Search rows: <?php print $company_appointments['search_rows'] ?>
      </div>
      <div>
        Continuation key: <?php print $company_appointments['continuation_key'] ?>
      </div>
    </div>

    <div id="company-appointments">
    <?php foreach ($company_appointments['appointments'] AS $appointment): ?>
      <div class="appointment appointment-<?php print $appointment['index'] ?> <?php ($appointment['index'] % 2 == 0) ? print 'even' : print 'odd' ?>">
        <div>
          <span class="label">Name: </span><?php print l($appointment['title'] . ' ' . $appointment['forename'] . ' ' . $appointment['surname'], 'chxmlgw/officer-details/' . $appointment['person_id_base64'], array('attributes' => array('title' => t('See more detailed information about this person'), 'class' => array('officer-details-link')))); ?>
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
          <?php if (!empty($appointment['address']['care_of'])): ?>
          <div>
            <?php print $appointment['address']['care_of'] ?>
          </div>
          <?php endif; ?>
          <?php if (!empty($appointment['address']['po_box'])): ?>
          <div>
            <?php print $appointment['address']['po_box'] ?>
          </div>
          <?php endif; ?>
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
