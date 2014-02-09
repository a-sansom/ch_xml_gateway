<?php if ($error): ?>
  <p>
    Error: <?php print $error ?>
  </p>
<?php endif; ?>

<?php if ($companyDetails): ?>
<div>
  <div>
    <span class="label">Name: </span><?php print $companyDetails['name'] ?>
  </div>
  <div>
    <span class="label">Company number: </span><?php print $companyDetails['number'] ?>
  </div>
  <div>
    <span class="label">Category: </span><?php print $companyDetails['category'] ?>
  </div>
  <div>
    <span class="label">Status: </span><?php print $companyDetails['status'] ?>
  </div>
  <div>
    <span class="label">In liquidation: </span><?php print $companyDetails['liquidation'] ?>
  </div>
  <?php if (!empty($companyDetails['branchinfo'])): ?>
    <div>
      <span class="label">Has branch info: </span><?php print $companyDetails['branchinfo'] ?>
    </div>
  <?php endif; ?>
  <div>
    <span class="label">Has appointments: </span><?php print $companyDetails['appointments'] ?>
  </div>
  <?php if ($companyDetails['appointments'] == '1'): ?>
    <div>
      <?php print l(t('(View appointments)'), 'chxmlgw/appointments-search/' . $companyDetails['number']); ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('registration_date', $companyDetails) && !empty($companyDetails['registration_date'])): ?>
    <div>
      <span class="label">Registration date: </span><?php print $companyDetails['registration_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('dissolution_date', $companyDetails) && !empty($companyDetails['dissolution_date'])): ?>
    <div>
      <span class="label">Dissolution date: </span><?php print date('d/m/Y', $companyDetails['dissolution_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('incorporation_date', $companyDetails) && !empty($companyDetails['incorporation_date'])): ?>
    <div>
      <span class="label">Incorporation date: </span><?php print date('d/m/Y', $companyDetails['incorporation_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('closure_date', $companyDetails) && !empty($companyDetails['closure_date'])): ?>
    <div>
      <span class="label">Closure date: </span><?php print $companyDetails['closure_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('accounts', $companyDetails)): ?>
    <div>
      <span class="label">Accounts overdue: </span><?php print $companyDetails['accounts']['overdue'] ?>
    </div>
    <div>
      <span class="label">Accounts document available: </span><?php print $companyDetails['accounts']['document'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('reference_date', $companyDetails['accounts']) && !empty($companyDetails['accounts']['reference_date'])): ?>
    <!-- Different date value to other date values 'dd-mm' -->
    <div>
      <span class="label">Accounts reference date: </span><?php print $companyDetails['accounts']['reference_date'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('due_date', $companyDetails['accounts']) && !empty($companyDetails['accounts']['due_date'])): ?>
    <div>
      <span class="label">Accounts due date: </span><?php print date('d/m/Y', $companyDetails['accounts']['due_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('last_madeup', $companyDetails['accounts']) && !empty($companyDetails['accounts']['last_madeup'])): ?>
    <div>
      <span class="label">Accounts last made up: </span><?php print date('d/m/Y', $companyDetails['accounts']['last_madeup']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('category', $companyDetails['accounts']) && !empty($companyDetails['accounts']['category'])): ?>
    <div>
      <span class="label">Accounts category: </span><?php print $companyDetails['accounts']['category'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('returns', $companyDetails)): ?>
    <div>
      <span class="label">Returns overdue: </span><?php print $companyDetails['returns']['overdue'] ?>
    </div>
    <div>
      <span class="label">Returns document available: </span><?php print $companyDetails['returns']['document'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('due_date', $companyDetails['returns']) && !empty($companyDetails['returns']['due_date'])): ?>
    <div>
      <span class="label">Returns due date: </span><?php print date('d/m/Y', $companyDetails['returns']['due_date']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('last_madeup', $companyDetails['returns']) && !empty($companyDetails['returns']['last_madeup'])): ?>
    <div>
      <span class="label">Returns last made up: </span><?php print date('d/m/Y', $companyDetails['returns']['last_madeup']) ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('mortgage', $companyDetails)): ?>
    <div>
      <span class="label">Mortgage register: </span><?php print $companyDetails['mortgage']['register'] ?>
    </div>
    <div>
      <span class="label">Mortgage charges: </span><?php print $companyDetails['mortgage']['charges'] ?>
    </div>
    <div>
      <span class="label">Mortgage outstanding: </span><?php print $companyDetails['mortgage']['outstanding'] ?>
    </div>
    <div>
      <span class="label">Mortgage part satisfied: </span><?php print $companyDetails['mortgage']['part_satisfied'] ?>
    </div>
    <div>
      <span class="label">Mortgage fully satisfied: </span><?php print $companyDetails['mortgage']['fully_satisfied'] ?>
    </div>
  <?php endif; ?>
  <?php if (array_key_exists('previous_name', $companyDetails)): ?>
    <div>
      <span class="label">Previous names:</span>
      <?php foreach ($companyDetails['previous_name'] AS $previousName): ?>
        <div>
          <?php print $previousName ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <div>
    <span class="label">Address:</span>
    <?php foreach ($companyDetails['address'] AS $addressLine): ?>
      <div>
        <?php print $addressLine ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div>
    <span class="label">Sic code(s):</span>
    <?php foreach ($companyDetails['sic_code'] AS $sicItem): ?>
      <div>
        <?php print $sicItem ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<p>
  <?php print l(t('Search again?'), 'chxmlgw/company-details'); ?>
</p>