<?php if ($error): ?>
  <p>
    Error: <?php print $error ?>
  </p>
<?php endif; ?>

<?php if (count($companyList['exact']) > 0): ?>
<h3>Exact match:</h3>
<div>
  <?php print l($companyList['exact']['name'], 'chxmlgw/company-details/' . $companyList['exact']['number'], array('attributes' => array('title' => t('View more details'), 'class' => array('match', 'exact')))); ?>
</div>
<?php endif; ?>

<h3>Non-exact matches:</h3>
<div>
<?php
  $index = 0; 
  foreach ($companyList['match'] as $company): 
    $index++;
?>
    <li><?php print l($company['name'], 'chxmlgw/company-details/' . $company['number'], array('attributes' => array('title' => t('View more details'), 'class' => array('match', 'non-exact', 'non-exact-' . $index)))); ?></li>
  </ul>
<?php endforeach; ?>
</div>

<p>
  <?php print l(t('Search again?'), 'chxmlgw/company-search'); ?>
</p>