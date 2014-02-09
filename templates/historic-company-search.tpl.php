<p>
  <?php print l(t('Back to your gateway history'), 'chxmlgw/gateway-history/user/'. $meta['user_id']) ?>
</p>
<p>
  On <?php print $meta['query_timestamp'] ?>, you queried <?php print $meta['service_name'] ?> and it returned the following information:
</p>
<?php if (count($companyList['exact']) > 0): ?>
<h3>Exact match:</h3>
<div>
  <?php print l($companyList['exact']['name'], 'chxmlgw/gateway-history/user/' . $meta['user_id'], array('attributes' => array('class' => 'match exact'))) ?>
</div>
<?php endif; ?>

<h3>Non-exact matches:</h3>
<div>
<?php
  $index = 0; 
  foreach ($companyList['match'] as $company): 
    $index++;
?>
  <ul>
    <li><?php print l($company['name'], 'chxmlgw/gateway-history/user/' . $meta['user_id'], array('attributes' => array('title' => '', 'class' => array('match', 'non-exact', 'non-exact-' . $index)))); ?></li>
  </ul>
<?php endforeach; ?>
</div>