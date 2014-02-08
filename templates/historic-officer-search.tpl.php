<p>
  <?php print l('Back to your gateway history', 'chxmlgw/gateway-history/user/'. $meta['user_id']) ?>
</p>
<p>
  On <?php print $meta['query_timestamp'] ?>, you queried <?php print $meta['service_name'] ?> and it returned the following information:
</p>
<div id="search-results">
<?php if (count($officerList['match']) > 0): ?>
  <div id="search-results-matches">
    <!-- Nearest match is returned in $officerList['exact'] -->
    <?php if(array_key_exists("exact", $officerList)): ?>
    <h3>Exact match</h3>
    <div id="exact-match">
      <div class="appointment appointment-1 odd">
        <div>
          <a class="officer-details-link" href="/chxmlgw/gateway-history/user/<?php print $meta['user_id'] ?>"><?php print $officerList['exact']['title'] . ' ' . $officerList['exact']['forename'] . ' ' . $officerList['exact']['surname']?></a>
        </div>
        <?php if (array_key_exists('dob', $officerList['exact']) && !empty($officerList['exact']['dob'])): ?>
          <div>
            <span class="label">DOB: </span><?php print date('d/m/Y', $officerList['exact']['dob']) ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('posttown', $officerList['exact']) && !empty($officerList['exact']['posttown'])): ?>
          <div>
            <span class="label">Town: </span><?php print $officerList['exact']['posttown'] ?>
          </div>
        <?php endif; ?>
        <?php if (array_key_exists('postcode', $officerList['exact']) && !empty($officerList['exact']['postcode'])): ?>
          <div>
            <span class="label">Postcode: </span><?php print $officerList['exact']['postcode'] ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Rest of the matches are returned in $officerList['match'] -->
    <h3>Near matches</h3>
    <div id="near-matches">
      <?php
        $index = 1; // 'Exact match' is always goinbg to be appointment-1    
        foreach ($officerList['match'] AS $officer):
          $index++;
      ?>
      <div class="appointment appointment-<?php print $index ?> <?php ($index % 2 == 0) ? print 'even' : print 'odd' ?>">
        <div>
          <a class="officer-details-link" href="/chxmlgw/gateway-history/user/<?php print $meta['user_id'] ?>"><?php print $officer['title'] . ' ' . $officer['forename'] . ' ' . $officer['surname'] ?></a>
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