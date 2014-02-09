<?php 
/**
 * @file
 * Template to display a users previous officer name searches.
 */
?>


<p>
  <?php print l(t('Back to your gateway history'), 'chxmlgw/gateway-history/user/'. $meta['user_id']) ?>
</p>
<p>
  On <?php print $meta['query_timestamp'] ?>, you queried <?php print $meta['service_name'] ?> and it returned the following information:
</p>
<div id="search-results">
<?php if (count($officer_list['match']) > 0): ?>
  <div id="search-results-matches">
    <!-- Nearest match is returned in $officer_list['exact'] -->
    <?php if(array_key_exists("exact", $officer_list)): ?>
    <h3>Exact match</h3>
    <div id="exact-match">
      <div class="appointment appointment-1 odd">
        <div>
          <?php print l($officer_list['exact']['title'] . ' ' . $officer_list['exact']['forename'] . ' ' . $officer_list['exact']['surname'], 'chxmlgw/gateway-history/user/' . $meta['user_id'], array('attributes' => array('class' => array('officer-details-link')))); ?>
        </div>
        <?php if (array_key_exists('dob', $officer_list['exact']) && !empty($officer_list['exact']['dob'])): ?>
          <div>
            <span class="label">DOB: </span><?php print date('d/m/Y', $officer_list['exact']['dob']) ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('posttown', $officer_list['exact']) && !empty($officer_list['exact']['posttown'])): ?>
          <div>
            <span class="label">Town: </span><?php print $officer_list['exact']['posttown'] ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('postcode', $officer_list['exact']) && !empty($officer_list['exact']['postcode'])): ?>
          <div>
            <span class="label">Postcode: </span><?php print $officer_list['exact']['postcode'] ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Rest of the matches are returned in $officer_list['match'] -->
    <h3>Near matches</h3>
    <div id="near-matches">
      <?php
        $index = 1; // 'Exact match' is always going to be appointment-1    
        foreach ($officer_list['match'] AS $officer):
          $index++;
      ?>
      <div class="appointment appointment-<?php print $index ?> <?php ($index % 2 == 0) ? print 'even' : print 'odd' ?>">
        <div>
          <?php print l($officer['title'] . ' ' . $officer['forename'] . ' ' . $officer['surname'], 'chxmlgw/gateway-history/user/' . $meta['user_id'], array('attributes' => array('class' => array('officer-details-link')))); ?>
        </div>
        <?php if (array_key_exists('dob', $officer) && !empty($officer['dob'])): ?>
          <div>
            <span class="label">DOB: </span><?php print date('d/m/Y', $officer['dob']) ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('posttown', $officer) && !empty($officer['posttown'])): ?>
          <div>
            <span class="label">Town: </span><?php print $officer['posttown'] ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('postcode', $officer) && !empty($officer['postcode'])): ?>
          <div>
            <span class="label">Postcode: </span><?php print $officer['postcode'] ?>
          </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php else: ?>
  <div>
    No matches
  </div>
<?php endif; ?>