<?php
/**
 * @file
 * Display officer details search results.
 *
 * Available variables:
 * - $error: Error message indicating that the gateway search failed.
 * - $officer_details: Array of officer details information from gateway search containing:
 * - $officer_details['corporate_indicator']: Flag officer is a company.
 * - $officer_details['person_id']: Companies House unique identifier.
 * - $officer_details['title']: Officer title.
 * - $officer_details['formatted_forename']: Formatted forename (forename can be an array).
 * - $officer_details['forename']: Officer forename.
 * - $officer_details['surname']: Officer surname.
 * - $officer_details['honours']:
 * - $officer_details['dob']: Officer date of birth.
 * - $officer_details['nationality']: Officer nationality.
 * - $officer_details['continuation_key']:
 * - $officer_details['search_rows']:
 * - $officer_details['appt_count']['number_current_appointments']: Number of current appointments held.
 * - $officer_details['appt_count']['number_dissolved_appointments']: Number of dissolved appointments held.
 * - $officer_details['appt_count']['number_resigned_appointments']: Number of resigned appointments held.
 * - $officer_details['numberdisqualorders']:
 * - $officer_details['address']['care_of']: Officer addres detail.
 * - $officer_details['address']['po_box']: Officer addres detail.
 * - $officer_details['address']['line']: Officer addres detail.
 * - $officer_details['address']['posttown']: Officer addres detail.
 * - $officer_details['address']['postcode']: Officer addres detail.
 * - $officer_details['company'][NUMBER]['name']: Company name.
 * - $officer_details['company'][NUMBER]['number']: Companies House company number.
 * - $officer_details['company'][NUMBER]['status']: Company status.
 * - $officer_details['company'][NUMBER]['appointment'][INDEX]['type']: Appointment type.
 * - $officer_details['company'][NUMBER]['appointment'][INDEX]['status']: Appointment status.
 * - $officer_details['company'][NUMBER]['appointment'][INDEX]['date']: Appoitment date as a timestamp.
 * - $officer_details['company'][NUMBER]['appointment'][INDEX]['occupation']: Occupation.
 * - $officer_details['company'][NUMBER]['appointment'][INDEX]['resignation']: Appointment resignation date, if applicable.
 * - $officer_details['disqualifcation'][INDEX]['reason']: Reason ofr disqualification.
 * - $officer_details['disqualifcation'][INDEX]['start']: Start date of disqualification.
 * - $officer_details['disqualifcation'][INDEX]['end']: End date of disqualification.
 * - $officer_details['disqualifcation'][INDEX]['exemption'][INDEX]['name']:
 * - $officer_details['disqualifcation'][INDEX]['exemption'][INDEX]['number']:
 * - $officer_details['disqualifcation'][INDEX]['exemption'][INDEX]['start']:
 * - $officer_details['disqualifcation'][INDEX]['exemption'][INDEX]['end']:
 *
 * @see template_preprocess_officer_details_result().
 *
 * @ingoup themeable
 */
?>
<?php if ($error): ?>
<p>
  Error: <?php print $error ?>
</p>
<?php endif; ?>

<?php if ($officer_details): ?>
<!-- Name etc. -->
<div>
  <h3><?php print $officer_details['title'] . ' ' . $officer_details['formatted_forename'] . ' ' . $officer_details['surname'] ?></h3>
  <?php if (!empty($officer_details['honours'])): ?>
  <div>
    <span class="label">Honours: </span>
    <?php print $officer_details['honours'] ?>
  </div>
  <?php endif; ?>
  <?php if( !empty($officer_details['dob'])): ?>
  <div>
    <span class="label">DOB: </span>
    <?php print date('d/m/Y', $officer_details['dob']) ?>
  </div>
  <?php endif; ?>
  <div>
    <span class="label">Nationality: </span>
    <?php print $officer_details['nationality'] ?>
  </div>
</div>

<!-- Address -->
<div>
  <span class="label">Address:</span>
  <?php if (is_array($officer_details['address']['line'])): ?>
  <?php foreach($officer_details['address']['line'] AS $line): ?>
  <div>
    <?php print $line ?>
  </div>
  <?php endforeach; ?>
  <?php else: ?>
  <div>
    <?php print $officer_details['address']['line'] ?>
  </div>
  <?php endif; ?>
  <div>
    <?php print $officer_details['address']['posttown'] ?>
  </div>
  <div>
    <?php print $officer_details['address']['postcode'] ?>
  </div>
</div>

<!-- Companies -->
<div>
  <h3>Companies</h3>
  <?php foreach ($officer_details['company'] AS $company_details): ?>
  <div>
    <div>
      <span class="label">Company number: </span>
      <?php print $company_details['number'] ?>
    </div>
    <div>
      <?php print $company_details['name'] ?>
    </div>
    <div>
      <span class="label">Company status: </span>
      <?php print $company_details['status'] ?>
    </div>

    <?php foreach ($company_details['appointment'] AS $appointment): ?>
    <div>
      <div>
        <span class="label">Type: </span>
        <?php print $appointment['type'] ?>
      </div>
      <div>
        <span class="label">Status: </span>
        <?php print $appointment['status'] ?>
      </div>
      <div>
        <span class="label">Appointment date: </span>
        <?php print date('d/m/Y', $appointment['date']) ?>
      </div>
      <?php if (isset($appointment['resignation'])): ?>
      <div>
        <span class="label">Resignation date: </span>
        <?php print date('d/m/Y', $appointment['resignation']) ?>
      </div>
      <?php endif; ?>
      <?php if (isset($appointment['occupation'])): ?>
      <div>
        <span class="label">Occupation: </span>
        <?php print $appointment['occupation'] ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>
</div>

<!-- Disqualifications -->
<?php if (isset($officer_details['disqualifcation'])): ?>
<div>
  <h3>Disqualifications</h3>
  <?php foreach ($officer_details['disqualifcation'] AS $disqualification): ?>
  <div>
    <div>
      <span class="label">Reason: </span>
      <?php print $disqualification['reason'] ?>
    </div>
    <div>
      <span class="label">Start date: </span>
      <?php print date('d/m/Y', $disqualification['start']) ?>
    </div>
    <div>
      <span class="label">End date: </span>
      <?php print date('d/m/Y', $disqualification['end']) ?>
    </div>

    <?php if (isset($disqualification['exemption'])): ?>
    <div>
      <h4>Exemptions</h4>
      <?php foreach($disqualification['exemption'] AS $exemption): ?>
      <div>
        <div>
          <?php print $exemption['name'] ?>
        </div>
        <div>
          <span class="label">Company number: </span>
          <?php print $exemption['number'] ?>
        </div>
        <div>
          <span class="label">Start date: </span>
          <?php print date('d/m/Y', $exemption['start']) ?>
        </div>
        <div>
          <span class="label">End date: </span>
          <?php print date('d/m/Y', $exemption['end']) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<p>
  <?php print l(t('Search for another?'), 'chxmlgw/officer-search'); ?>
</p>
