<?php if ($error): ?>
  <p>
    Error: <?php print $error ?>
  </p>
<?php endif; ?>

<?php if ($officerDetails): ?>
    <!-- Name etc. -->
    <div>
      <h3><?php print $officerDetails['title'] . ' ' . $officerDetails['formatted_forename'] . ' ' . $officerDetails['surname'] ?></h3>
      <?php if (!empty($officerDetails['honours'])): ?>
        <div>
          <span class="label">Honours: </span><?php print $officerDetails['honours'] ?>
        </div>
      <?php endif; ?>
      <?php if( !empty($officerDetails['dob'])): ?>
        <div>
          <span class="label">DOB: </span><?php print date('d/m/Y', $officerDetails['dob']) ?>
        </div>
      <?php endif; ?>
      <div>
        <span class="label">Nationality: </span><?php print $officerDetails['nationality'] ?>
      </div>
    </div>

    <!-- Address -->
    <div>
      <span class="label">Address:</span>
      <?php if (is_array($officerDetails['address']['line'])): ?>
        <?php foreach($officerDetails['address']['line'] AS $line): ?>
          <div>
            <?php print $line ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
      <div>
        <?php print $officerDetails['address']['line'] ?>
      </div>
      <?php endif; ?>
      <div>
        <?php print $officerDetails['address']['posttown'] ?>
      </div>
      <div>
        <?php print $officerDetails['address']['postcode'] ?>
      </div>
    </div>

    <!-- Companies -->
    <div>
      <h3>Companies</h3>
      <?php foreach ($officerDetails['company'] AS $company_details): ?>
        <div>
          <div>
            <span class="label">Company number: </span><?php print $company_details['number'] ?>
          </div>
          <div>
            <?php print $company_details['name'] ?>
          </div>
          <div>
            <span class="label">Company status: </span><?php print $company_details['status'] ?>
          </div>

          <?php foreach ($company_details['appointment'] AS $appointment): ?>
            <div>
              <div>
                <span class="label">Type: </span><?php print $appointment['type'] ?>
              </div>
              <div>
                <span class="label">Status: </span><?php print $appointment['status'] ?>
              </div>
              <div>
                <span class="label">Appointment date: </span><?php print date('d/m/Y', $appointment['date']) ?>
              </div>
              <?php if (array_key_exists('resignation', $appointment)): ?>
                <div>
                  <span class="label">Resignation date: </span><?php print date('d/m/Y', $appointment['resignation']) ?>
                </div>
              <?php endif; ?>
              <?php if (array_key_exists('occupation', $appointment)): ?>
                <div>
                  <span class="label">Occupation: </span><?php print $appointment['occupation'] ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Disqualifications -->
    <?php if (array_key_exists("disqualifcation", $officerDetails)): ?>
      <div>
      <h3>Disqualifications</h3>
      <?php foreach ($officerDetails['disqualifcation'] AS $disqualification): ?>
        <div>
          <div>
            <span class="label">Reason: </span><?php print $disqualification['reason'] ?>
          </div>
          <div>
            <span class="label">Start date: </span><?php print date('d/m/Y', $disqualification['start']) ?>
          </div>
          <div>
            <span class="label">End date: </span><?php print date('d/m/Y', $disqualification['end']) ?>
          </div>
        
          <?php if (array_key_exists("exemption", $disqualification)): ?>
            <div>
              <h4>Exemptions</h4>
              <?php foreach($disqualification['exemption'] AS $exemption): ?>
                <div>
                  <div>
                    <?php print $exemption['name'] ?>
                  </div>
                  <div>
                    <span class="label">Company number: </span><?php print $exemption['number'] ?>
                  </div>
                  <div>
                    <span class="label"Start date: </span><?php print date('d/m/Y', $exemption['start']) ?>
                  </div>
                  <div>
                    <span class="label">End date: </span><?php print date('d/m/Y', $exemption['end']) ?>
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
  <a href="/chxmlgw/officer-search">Search for another?</a>
</p>