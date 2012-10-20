<?php if ($error): ?>
  <div>
    Error: <?php print $error ?>
  </div>
<?php endif; ?>

<?php if (count($companyList['exact']) > 0): ?>
<h3>Exact match:</h3>
<div>
  <a class="match exact" href="/chxmlgw/company-details/<?php print $companyList['exact']['number'] ?>" title="View more details"><?php print $companyList['exact']['name'] ?></a>
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
    <li><a class="match non-exact non-exact-<?php print $index ?> <?php ($index % 2 == 0) ? print 'even' : print 'odd' ?>" href="/chxmlgw/company-details/<?php print $company['number'] ?>" title="View more details"><?php print $company['name'] ?></a></li>
  </ul>
<?php endforeach; ?>
</div>

<p>
  <a href="/chxmlgw/company-search">Search again?</a>
</p>