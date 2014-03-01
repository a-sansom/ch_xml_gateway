<?php 
/**
 * @file
 * Template to display company search results.
 *
 * Available variables:
 * - $error: Error message indicating that the gateway search failed.
 * - $company_list: Array of 'exact' and non-exact company names. Includes:
 * - $company_list['exact']['name']: Nearest match company name.
 * - $company_list['exact']['number']: Nearest match company number.
 * - $company_list['match']: Array of near matches. Each item comprised of:
 * - $company_list['match']['name']: Company name.
 * - $company_list['match']['number']: Company number.
 *
 * @ingroup themeable
 */
?>
<?php if ($error): ?>
  <p>
    Error: <?php print $error ?>
  </p>
<?php endif; ?>

<?php if (count($company_list['exact']) > 0): ?>
  <h3>Exact match:</h3>
  <div>
    <?php print l($company_list['exact']['name'], 'chxmlgw/company-details/' . $company_list['exact']['number'], array('attributes' => array('title' => t('View more details'), 'class' => array('match', 'exact')))); ?>
  </div>
<?php endif; ?>

<h3>Non-exact matches:</h3>
<div>
  <ul>
    <?php foreach ($company_list['match'] as $company): ?>
      <li><?php print l($company['name'], 'chxmlgw/company-details/' . $company['number'], array('attributes' => array('title' => t('View more details'), 'class' => array('match', 'non-exact')))); ?></li>
    <?php endforeach; ?>
  </ul>
</div>

<p>
  <?php print l(t('Search again?'), 'chxmlgw/company-search'); ?>
</p>

