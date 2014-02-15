<?php
/**
 * @file
 * Admin functionality for the module.
 */


/**
 * Admin form for settings that will affect the usage of the XML gateway.
 *
 * @return array
 *   Form defined as per the Drupal form API dictates.
 */
function ch_xml_gateway_settings_form() {
  // select/radio control options.
  $options_zero_or_one = array(
    '1' => t('True'),
    '0' => t('False'),
  );

  $options_officer_type = array(
    'DIS' => t('Disqualified Directors only'),
    'LLP' => t('Limited Liability Partnerships'),
    'CUR' => t('Not above'),
    'EUR' => t('SE and ES appointments only'),
  );

  // Gateway Login.
  $form['login'] = array(
    '#type' => 'fieldset',
    '#title' => t('XML Gateway Login'),
    '#tree' => TRUE,
  );

  $form['login']['gateway_user'] = array(
    '#type' => 'textfield',
    '#title' => t('CH XML Gateway user name'),
    '#required' => TRUE,
    '#default_value' => variable_get('ch_xml_gateway_user', ''),
    '#size' => 40,
    '#maxlength' => 100,
  );

  $form['login']['gateway_pass'] = array(
    '#type' => 'textfield',
    '#title' => t('CH XML Gateway password'),
    '#required' => TRUE,
    '#default_value' => variable_get('ch_xml_gateway_pass', ''),
    '#size' => 40,
    '#maxlength' => 100,
  );

  // Request info (put into the header of the request sent to companies house).
  $form['request_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('XML Gateway Request Info'),
    '#tree' => TRUE,
  );

  // Email address packaged up in the XML sent to Companies House.
  $form['request_info']['sender_email'] = array(
    '#type' => 'textfield',
    '#title' => t('EmailAddress'),
    '#description' => t('May be used by the Gateway for auditing and as a secondary point of contact in the event of failure'),
    '#required' => FALSE,
    '#default_value' => variable_get('ch_xml_gateway_sender', ''),
    '#size' => 40,
    '#maxlength' => 129,
  );

  // CompanyDetails.
  $form['company_details'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyDetails'),
    '#tree' => TRUE,
    '#description' => t('Queries gateway for details about a specific company, given its Companies House company number.'),
  );

  $form['company_details']['give_mort_totals'] = array(
    '#type' => 'radios',
    '#title' => t('GiveMortTotals'),
    '#default_value' => variable_get('ch_xml_gateway_CompanyDetails_GiveMortTotals', 0),
    '#options' => $options_zero_or_one,
    '#description' => t('Requests the return of the Mortgages element. Totals are only returned if applicable.'),
  );

  // CompanyAppointments.
  $form['company_appointments'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyAppointments'),
    '#tree' => TRUE,
    '#description' => t('Queries gateway for information about current/resigned company appointments, given its Companies House company number. Charged per query?'),
  );

  $form['company_appointments']['include_resigned_ind'] = array(
    '#type' => 'radios',
    '#title' => t('IncludeResignedInd'),
    '#default_value' => variable_get('ch_xml_gateway_CompanyAppointments_IncludeResignedInd', 0),
    '#options' => $options_zero_or_one,
    '#description' => t('Indicates the status of appointments to be returned. True = All appointment types returned. False = Only current appointments returned.'),
  );

  // OfficerSearch.
  // There doesn't appear to be any way of limiting the number of results
  // returned? Or is it defined by the gateway?
  $form['officer_search'] = array(
    '#type' => 'fieldset',
    '#title' => t('OfficerSearch'),
    '#tree' => TRUE,
    '#description' => t('Queries directory of past and present directors and secretaries.'),
  );

  $form['officer_search']['officer_type'] = array(
    '#type' => 'select',
    '#title' => t('OfficerType'),
    '#default_value' => variable_get('ch_xml_gateway_OfficerSearch_OfficerType', 'CUR'),
    '#options' => $options_officer_type,
    '#description' => t("'Not above == Current'"),
  );

  $form['officer_search']['include_resigned_ind'] = array(
    '#type' => 'radios',
    '#title' => t('IncludeResignedInd'),
    '#default_value' => variable_get('ch_xml_gateway_OfficerSearch_IncludeResignedInd', 0),
    '#options' => $options_zero_or_one,
    '#description' => t('Indicate whether resigned appointments should be returned. True = All appointment types returned. False = Only current appointments returned.'),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Update'),
  );

  return $form;
}


/**
 * Validate settings form.
 */
function ch_xml_gateway_settings_form_validate($form, &$form_state) {
  $form_values = $form_state['values'];
  // Validation of sender email exactly the same as php-govtalk's GovTalk.php.
  // Says that the validation is dictated by the GovTalk specification.
  if (!empty($form_values['request_info']['sender_email']) && !preg_match('/[A-Za-z0-9\.\-_]{1,64}@[A-Za-z0-9\.\-_]{1,64}/', $form_values['request_info']['sender_email'])) {
    form_set_error('', t('Invalid EmailAddress value.'));
  }
}


/**
 * Save updated settings.
 */
function ch_xml_gateway_settings_form_submit($form, &$form_state) {
  $form_values = $form_state['values'];
  variable_set('ch_xml_gateway_user', $form_values['login']['gateway_user']);
  variable_set('ch_xml_gateway_pass', $form_values['login']['gateway_pass']);
  variable_set('ch_xml_gateway_sender', $form_values['request_info']['sender_email']);
  variable_set('ch_xml_gateway_CompanyDetails_GiveMortTotals', $form_values['company_details']['give_mort_totals']);
  variable_set('ch_xml_gateway_CompanyAppointments_IncludeResignedInd', $form_values['company_appointments']['include_resigned_ind']);
  variable_set('ch_xml_gateway_OfficerSearch_OfficerType', $form_values['officer_search']['officer_type']);
  variable_set('ch_xml_gateway_OfficerSearch_IncludeResignedInd', $form_values['officer_search']['include_resigned_ind']);
  drupal_set_message(t('Details updated.'));
}


/**
 * Page for (potentially) a number of forms allowing config of search forms.
 *
 * @return array
 *   Markup containing at least one form.
 */
function ch_xml_gateway_search_options_page() {
  $output = drupal_get_form('chxml_gateway_search_options_form');
  // Add any further forms to be displayed on the page to $output...
  return $output;
}


/**
 * Config of which fields are available on form(s) generated by module.
 *
 * @return array
 *   Form defined as per the Drupal form API.
 */
function chxml_gateway_search_options_form() {
  $options_zero_or_one = array(
    '1' => t('True'),
    '0' => t('False'),
  );

  $form['all_searches'] = array(
    '#type' => 'fieldset',
    '#title' => t('All searches'),
    '#description' => t('Settings that affect all searches.'),
    '#tree' => TRUE,
  );

  // Should the module enable AJAX searches?
  $form['all_searches']['use_ajax_searches'] = array(
    '#type' => 'radios',
    '#title' => t('Use AJAX (where implemented)?'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_all_ajax_searches', 0),
    '#options' => $options_zero_or_one,
    '#description' => t('Show OfficerDetails results in the same page as results of CompanyAppointments or OfficerSearch with AJAX, where there is browser capability?'),
  );

  $form['company_details_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanySearch form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/company-details'), 'chxmlgw/company-details'))),
    '#tree' => TRUE,
  );

  $form['appointments_search_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyAppointments form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/appointments-search'), 'chxmlgw/appointments-search'))),
    '#tree' => TRUE,
  );

  $form['officer_search_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('OfficerSearch form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/officer-search'), 'chxmlgw/officer-search'))),
    '#tree' => TRUE,
  );

  $form['officer_search_page']['form_instructions'] = array(
    '#type' => 'textarea',
    '#title' => t('Text displayed to user instructing how to use the form'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_form_instructions', ''),
    '#description' => t('Only displayed if not empty.'),
  );

  // Should the form use one input for name...
  $form['officer_search_page']['single_name_input'] = array(
    '#type' => 'radios',
    '#title' => t('Use single name input control?'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_single_name_input', 0),
    '#options' => $options_zero_or_one,
    '#description' => t("If 'True' then follwoing name control option will be ignored."),
  );

  // ...or use multiple inputs.
  $form['officer_search_page']['show_all_forename'] = array(
    '#type' => 'radios',
    '#title' => t("Show second 'Forename' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_all_forename', 0),
    '#options' => $options_zero_or_one,
  );

  $form['officer_search_page']['show_town'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Town' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_town', 0),
    '#options' => $options_zero_or_one,
  );

  $form['officer_search_page']['show_officer_type'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Type' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_officer_type', 0),
    '#options' => $options_zero_or_one,
    '#description' => t("If this is set to 'False', the default value set for OfficerSearch -> OfficerType on the 'Gateway Options' page is used in the form."),
  );

  $form['officer_search_page']['show_resigned_indicator'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Include resigned appointments?' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_include_resigned', 0),
    '#options' => $options_zero_or_one,
    '#description' => t("If this is set to 'False', the default value set for OfficerSearch -> IncludeResignedInd on the 'Gateway Options' page is used in the form."),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Update'),
  );

  return $form;
}


/**
 * Save any settings changes.
 */
function chxml_gateway_search_options_form_submit($form, &$form_state) {
  $form_values = $form_state['values'];

  variable_set('ch_xml_gateway_form_settings_all_ajax_searches', $form_values['all_searches']['use_ajax_searches']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_form_instructions', $form_values['officer_search_page']['form_instructions']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_single_name_input', $form_values['officer_search_page']['single_name_input']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_show_all_forename', $form_values['officer_search_page']['show_all_forename']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_show_town', $form_values['officer_search_page']['show_town']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_show_officer_type', $form_values['officer_search_page']['show_officer_type']);
  variable_set('ch_xml_gateway_form_settings_OfficerSearch_show_include_resigned', $form_values['officer_search_page']['show_resigned_indicator']);

  drupal_set_message(t('Details updated.'));
}

