<?php
/**
 * @file
 * Display officer search results.
 *
 * Available variables:
 * - $error: Error message indicating that the gateway search failed.
 * - $officer_list: Array of officer information and search meta data. Contains
 * elements 'exact' and 'match'. 'exact' is the match marked as the nearest
 * match by Companies House, 'match being the rest of the results':
 *
 * - $officer_list['search_rows']: Number of results returned.
 * - $officer_list['search_criteria']['surname']: Search parameter.
 * - $officer_list['search_criteria']['forename']: Search parameter.
 * - $officer_list['search_criteria']['officer_type']: Search parameter.
 * - $officer_list['search_criteria']['town']: Search parameter.
 * - $officer_list['search_criteria']['include_resigned']: Search parameter.
 *
 * - $officer_list['exact']['id']: Nearest match Companies House unique identifier.
 * - $officer_list['exact']['title']: Nearest match title.
 * - $officer_list['exact']['forename']: Nearest match forename.
 * - $officer_list['exact']['surname']: Nearest match surname.
 * - $officer_list['exact']['dob']: Nearest match timestamp date of birth.
 * - $officer_list['exact']['posttown']: Nearest match post town.
 * - $officer_list['exact']['postcode']: Nearest match post code.
 * - $officer_list['exact']['country_of_residence']: Nearest match country of residence.
 * - $officer_list['exact']['state_of_residence']: Nearest match state of residence.
 *
 * - $officer_list['match']['index']: One-based numeric index.
 * - $officer_list['match']['title']: See 'exact' property description.
 * - $officer_list['match']['forename']: See 'exact' property description.
 * - $officer_list['match']['surname']: See 'exact' property description.
 * - $officer_list['match']['dob']: See 'exact' property description.
 * - $officer_list['match']['posttown']: See 'exact' property description.
 * - $officer_list['match']['postcode']: See 'exact' property description.
 * - $officer_list['match']['country_of_residence']: See 'exact' property description.
 * 
 *   $officer_list['match']['duplicate_officers'] is array of information of
 *   officer records that are known to be the same person.
 * 
 * - $officer_list['match']['duplicate_officers']['title']: See 'exact' property description.
 * - $officer_list['match']['duplicate_officers']['forename']: See 'exact' property description.
 * - $officer_list['match']['duplicate_officers']['surname']: See 'exact' property description.
 * - $officer_list['match']['duplicate_officers']['dob']: YYYY-MM-DD date of birth value.
 * - $officer_list['match']['duplicate_officers']['posttown']: See 'exact' property description.
 * - $officer_list['match']['duplicate_officers']['postcode']: See 'exact' property description.
 * - $officer_list['match']['duplicate_officers']['country_of_residence']: See 'exact' property description.
 *
 * @see template_preprocess_officer_search_result().
 *
 * @ingoup themeable
 */
?>
<?php if ($error): ?>
<div>
  Error: <?php print $error; ?>
</div>
<?php endif; ?>

<?php if ($officer_list): ?>
  <div id="search-results">
  <?php if (count($officer_list['match']) > 0): ?>
    <!-- Placeholder for dynamic appointments -->
    <div id="selected-appointment-detail"></div>

    <div id="search-results-matches">
      <?php if (isset($officer_list['exact'])): ?>
      <h3>Exact match</h3>
      <div id="exact-match">
        <div class="appointment appointment-1 odd">
          <div>
            <?php print l($officer_list['exact']['title'] . ' ' . $officer_list['exact']['forename'] . ' ' . $officer_list['exact']['surname'], 'chxmlgw/officer-details/' . $officer_list['exact']['id_base64'], array('attributes' => array('title' => t('See more detailed information about this person'), 'class' => array('officer-details-link')))); ?>
          </div>
          <?php if (isset($officer_list['exact']['dob'])): ?>
            <div>
              <span class="label">DOB: </span><?php print date('d/m/Y', $officer_list['exact']['dob']); ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer_list['exact']['posttown'])): ?>
            <div>
              <span class="label">Town: </span><?php print $officer_list['exact']['posttown']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer_list['exact']['postcode'])): ?>
            <div>
              <span class="label">Postcode: </span><?php print $officer_list['exact']['postcode']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer_list['exact']['country_of_residence']) && !empty($officer_list['exact']['country_of_residence'])): ?>
            <div>
              <span class="label">Country of residence: </span><?php print $officer_list['exact']['country_of_residence']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer_list['exact']['state_of_residence']) && !empty($officer_list['exact']['state_of_residence'])): ?>
            <div>
              <span class="label">State of residence: </span><?php print $officer_list['exact']['state_of_residence']; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <h3>Near matches</h3>
      <div id="near-matches">
        <?php foreach ($officer_list['match'] AS $officer): ?>
        <div class="appointment appointment-<?php print $officer['index']; ?> <?php ($index % 2 == 0) ? print 'even' : print 'odd' ?>">
          <div>
            <?php print l($officer['title'] . ' ' . $officer['forename'] . ' ' . $officer['surname'], 'chxmlgw/officer-details/' . $officer['id_base64'], array('attributes' => array('title' => t('See more detailed information about this person'), 'class' => array('officer-details-link')))); ?>
          </div>
          <?php if (isset($officer['dob']) && !empty($officer['dob'])): ?>
            <div>
              <span class="label">DOB: </span><?php print date('d/m/Y', $officer['dob']); ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer['posttown']) && !empty($officer['posttown'])): ?>
            <div>
              <span class="label">Town: </span><?php print $officer['posttown']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer['postcode']) && !empty($officer['postcode'])): ?>
            <div>
              <span class="label">Postcode: </span><?php print $officer['postcode']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer['country_of_residence']) && !empty($officer['country_of_residence'])): ?>
            <div>
              <span class="label">Country of residence: </span><?php print $officer['country_of_residence']; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($officer['duplicate_officers'])): ?>
            <h4>Duplicate officer(s)</h4>
            <?php foreach ($officer['duplicate_officers'] as $duplicate): ?>
              <div>
                <?php print $duplicate['title'] . ' ' . $duplicate['forename'] . ' ' . $duplicate['surname']; ?>
              </div>
              <?php if (isset($duplicate['dob']) && !empty($duplicate['dob'])): ?>
                <div>
                  <span class="label">DOB: </span><?php print $duplicate['dob']; ?>
                </div>
              <?php endif; ?>
              <?php if (isset($duplicate['posttown']) && !empty($duplicate['posttown'])): ?>
                <div>
                  <span class="label">Post town: </span><?php print $duplicate['posttown']; ?>
                </div>
              <?php endif; ?>
              <?php if (isset($duplicate['postcode']) && !empty($duplicate['postcode'])): ?>
                <div>
                  <span class="label">Postcode: </span><?php print $duplicate['postcode']; ?>
                </div>
              <?php endif; ?>
              <?php if (isset($duplicate['country_of_residence']) && !empty($duplicate['country_of_residence'])): ?>
                <div>
                  <span class="label">Country of residence: </span><?php print $duplicate['country_of_residence']; ?>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <div>
      <?php print t('No matches'); ?>
    </div>
  <?php endif; ?>
  </div>
<?php endif; ?>

<p>
  <?php print l(t('Search again?'), 'chxmlgw/officer-search'); ?>
</p>
