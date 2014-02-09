<?php 
/**
 * @file
 * Template to display results of a company search.
 */
?>


<?php if ($error): ?>
  <p>
    Error: <?php print $error ?>
  </p>
<?php endif; ?>

<?php if ($company_details): ?>
<div>
  <div>
    <span class="label">Name: </span><?php print $company_details['name'] ?>
  </div>
  <div>
    <span class="label">Company number: </span><?php print $company_details['number'] ?>
  </div>
  <div>
    <span class="label">Category: </span><?php print $company_details['category'] ?>
  </div>
  <div>
    <span class="label">Status: </span><?php print $company_details['status'] ?>
  </div>
  <div>
    <span class="label">In liquidation: </span><?php print $company_details['liquidation'] ?>
  </div>
  <?php if (!empty($company_details['branchinfo'])): ?>
    <div>
      <span class="label">Has branch info: </span><?php print $company_details['branchinfo'] ?>
    </div>
  <?php endif; ?>
  <div>
    <span class="label">Has appointments: </span><?php print $company_details['appointments'] ?>
  </div>
  <?php if ($company_details['appointments'] == '1'): ?>
    <div>
      <?php print l(t('(View appointments)'), 'chxmlgw/appointments-search/' . $company_details['number']); ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('registration_date', $company_details) && !empty($company_details['registration_date'])): ?>
    <div>
      <span class="label">Registration date: </span><?php print $company_details['registration_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('dissolution_date', $company_details) && !empty($company_details['dissolution_date'])): ?>
    <div>
      <span class="label">Dissolution date: </span><?php print date('d/m/Y', $company_details['dissolution_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('incorporation_date', $company_details) && !empty($company_details['incorporation_date'])): ?>
    <div>
      <span class="label">Incorporation date: </span><?php print date('d/m/Y', $company_details['incorporation_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('closure_date', $company_details) && !empty($company_details['closure_date'])): ?>
    <div>
      <span class="label">Closure date: </span><?php print $company_details['closure_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('accounts', $company_details)): ?>
    <div>
      <span class="label">Accounts overdue: </span><?php print $company_details['accounts']['overdue'] ?>
    </div>
    <div>
      <span class="label">Accounts document available: </span><?php print $company_details['accounts']['document'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('reference_date', $company_details['accounts']) && !empty($company_details['accounts']['reference_date'])): ?>
    <!-- Different date value to other date values 'dd-mm' -->
    <div>
      <span class="label">Accounts reference date: </span><?php print $company_details['accounts']['reference_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('due_date', $company_details['accounts']) && !empty($company_details['accounts']['due_date'])): ?>
    <div>
      <span class="label">Accounts due date: </span><?php print date('d/m/Y', $company_details['accounts']['due_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('last_madeup', $company_details['accounts']) && !empty($company_details['accounts']['last_madeup'])): ?>
    <div>
      <span class="label">Accounts last made up: </span><?php print date('d/m/Y', $company_details['accounts']['last_madeup']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('category', $company_details['accounts']) && !empty($company_details['accounts']['category'])): ?>
    <div>
      <span class="label">Accounts category: </span><?php print $company_details['accounts']['category'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('returns', $company_details)): ?>
    <div>
      <span class="label">Returns overdue: </span><?php print $company_details['returns']['overdue'] ?>
    </div>
    <div>
      <span class="label">Returns document available: </span><?php print $company_details['returns']['document'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('due_date', $company_details['returns']) && !empty($company_details['returns']['due_date'])): ?>
    <div>
      <span class="label">Returns due date: </span><?php print date('d/m/Y', $company_details['returns']['due_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('last_madeup', $company_details['returns']) && !empty($company_details['returns']['last_madeup'])): ?>
    <div>
      <span class="label">Returns last made up: </span><?php print date('d/m/Y', $company_details['returns']['last_madeup']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('mortgage', $company_details)): ?>
    <div>
      <span class="label">Mortgage register: </span><?php print $company_details['mortgage']['register'] ?>
    </div>
    <div>
      <span class="label">Mortgage charges: </span><?php print $company_details['mortgage']['charges'] ?>
    </div>
    <div>
      <span class="label">Mortgage outstanding: </span><?php print $company_details['mortgage']['outstanding'] ?>
    </div>
    <div>
      <span class="label">Mortgage part satisfied: </span><?php print $company_details['mortgage']['part_satisfied'] ?>
    </div>
    <div>
      <span class="label">Mortgage fully satisfied: </span><?php print $company_details['mortgage']['fully_satisfied'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('previous_name', $company_details)): ?>
    <div>
      <span class="label">Previous names:</span>
      <?php foreach ($company_details['previous_name'] AS $previous_name): ?>
        <div>
          <?php print $previous_name ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <div>
    <span class="label">Address:</span>
    <?php foreach ($company_details['address'] AS $address_line): ?>
      <div>
        <?php print $address_line ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div>
    <span class="label">Sic code(s):</span>
    <?php foreach ($company_details['sic_code'] AS $sic_item): ?>
      <div>
        <?php print $sic_item ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<p>
  <?php print l(t('Search again?'), 'chxmlgw/company-details'); ?>
</p>