<?php
/**
 * @file
 * Admin functionality for the module.
 */


/**
 * Various form select control options.
 */
function ch_xml_gateway_admin_form_select_options($type = '') {
  switch ($type) {
    case 'true_false':
      return array(
        '1' => t('True'),
        '0' => t('False'),
      );
      break;

    case 'officer_type':
      return array(
        'DIS' => t('Disqualified Directors only'),
        'LLP' => t('Limited Liability Partnerships'),
        'CUR' => t('Not above'),
        'EUR' => t('SE and ES appointments only'),
      );
      break;

    default:
      return array();
      break;
  }
}


/**
 * Admin form for settings that will affect the usage of the XML gateway.
 *
 * @return array
 *   Form defined as per the Drupal form API dictates.
 */
function ch_xml_gateway_settings_form() {
  $options_true_false = ch_xml_gateway_admin_form_select_options('true_false');

  // Gateway Login.
  $form['login'] = array(
    '#type' => 'fieldset',
    '#title' => t('XML Gateway Login'),
    '#tree' => FALSE,
  );

  $form['login']['ch_xml_gateway_user'] = array(
    '#type' => 'textfield',
    '#title' => t('CH XML Gateway user name'),
    '#required' => TRUE,
    '#default_value' => variable_get('ch_xml_gateway_user', ''),
    '#size' => 40,
    '#maxlength' => 100,
  );

  $form['login']['ch_xml_gateway_pass'] = array(
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
    '#tree' => FALSE,
  );

  // Email address packaged up in the XML sent to Companies House.
  $form['request_info']['ch_xml_gateway_sender'] = array(
    '#type' => 'textfield',
    '#title' => t('EmailAddress'),
    '#description' => t('May be used by the Gateway for auditing and as a secondary point of contact in the event of failure'),
    '#required' => FALSE,
    '#default_value' => variable_get('ch_xml_gateway_sender', ''),
    '#size' => 40,
    '#maxlength' => 129,
    '#element_validate' => array('ch_xml_gateway_validate_govtalk_email'),
  );

  // CompanyDetails.
  $form['company_details'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyDetails'),
    '#tree' => FALSE,
    '#description' => t('Queries gateway for details about a specific company, given its Companies House company number.'),
  );

  $form['company_details']['ch_xml_gateway_CompanyDetails_GiveMortTotals'] = array(
    '#type' => 'radios',
    '#title' => t('GiveMortTotals'),
    '#default_value' => variable_get('ch_xml_gateway_CompanyDetails_GiveMortTotals', 0),
    '#options' => $options_true_false,
    '#description' => t('Requests the return of the Mortgages element. Totals are only returned if applicable.'),
  );

  // CompanyAppointments.
  $form['company_appointments'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyAppointments'),
    '#tree' => FALSE,
    '#description' => t('Queries gateway for information about current/resigned company appointments, given its Companies House company number. Charged per query?'),
  );

  $form['company_appointments']['ch_xml_gateway_CompanyAppointments_IncludeResignedInd'] = array(
    '#type' => 'radios',
    '#title' => t('IncludeResignedInd'),
    '#default_value' => variable_get('ch_xml_gateway_CompanyAppointments_IncludeResignedInd', 0),
    '#options' => $options_true_false,
    '#description' => t('Indicates the status of appointments to be returned. True = All appointment types returned. False = Only current appointments returned.'),
  );

  // OfficerSearch.
  // There doesn't appear to be any way of limiting the number of results
  // returned? Or is it defined by the gateway?
  $form['officer_search'] = array(
    '#type' => 'fieldset',
    '#title' => t('OfficerSearch'),
    '#tree' => FALSE,
    '#description' => t('Queries directory of past and present directors and secretaries.'),
  );

  $form['officer_search']['ch_xml_gateway_OfficerSearch_OfficerType'] = array(
    '#type' => 'select',
    '#title' => t('OfficerType'),
    '#default_value' => variable_get('ch_xml_gateway_OfficerSearch_OfficerType', 'CUR'),
    '#options' => ch_xml_gateway_admin_form_select_options('officer_type'),
    '#description' => t("'Not above == Current'"),
  );

  $form['officer_search']['ch_xml_gateway_OfficerSearch_IncludeResignedInd'] = array(
    '#type' => 'radios',
    '#title' => t('IncludeResignedInd'),
    '#default_value' => variable_get('ch_xml_gateway_OfficerSearch_IncludeResignedInd', 0),
    '#options' => $options_true_false,
    '#description' => t('Indicate whether resigned appointments should be returned. True = All appointment types returned. False = Only current appointments returned.'),
  );

  return system_settings_form($form);
}


/**
 * Validate sender email as per php-govtalk's GovTalk.php.
 *
 * Validation is dictated by the GovTalk specification.
 */
function ch_xml_gateway_validate_govtalk_email($element, &$form_state, $form) {
  $email = $element['#value'];
  if (!empty($email) && !preg_match('/[A-Za-z0-9\.\-_]{1,64}@[A-Za-z0-9\.\-_]{1,64}/', $email)) {
    form_error($element, t('Invalid EmailAddress format/value.'));
  }
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
  $options_true_false = ch_xml_gateway_admin_form_select_options('true_false');

  $form['all_searches'] = array(
    '#type' => 'fieldset',
    '#title' => t('All searches'),
    '#description' => t('Settings that affect all searches.'),
    '#tree' => FALSE,
  );

  // Should the module enable AJAX searches?
  $form['all_searches']['ch_xml_gateway_form_settings_all_ajax_searches'] = array(
    '#type' => 'radios',
    '#title' => t('Use AJAX (where implemented)?'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_all_ajax_searches', 0),
    '#options' => $options_true_false,
    '#description' => t('Show OfficerDetails results in the same page as results
       of CompanyAppointments or OfficerSearch with AJAX, where there is browser
       capability?'),
  );

  $form['company_details_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanySearch form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/company-details'), 'chxmlgw/company-details'))),
    '#tree' => FALSE,
  );

  $form['appointments_search_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('CompanyAppointments form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/appointments-search'), 'chxmlgw/appointments-search'))),
    '#tree' => FALSE,
  );

  $form['officer_search_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('OfficerSearch form'),
    '#description' => t('Settings for form displayed at !path', array('!path' => l(t('chxmlgw/officer-search'), 'chxmlgw/officer-search'))),
    '#tree' => FALSE,
  );

  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_form_instructions'] = array(
    '#type' => 'textarea',
    '#title' => t('Text displayed to user instructing how to use the form'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_form_instructions', ''),
    '#description' => t('Only displayed if not empty.'),
  );

  // Should the form use one input for name...
  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_single_name_input'] = array(
    '#type' => 'radios',
    '#title' => t('Use single name input control?'),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_single_name_input', 0),
    '#options' => $options_true_false,
    '#description' => t("If 'True' then follwoing name control option will be
      ignored."),
  );

  // ...or use multiple inputs.
  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_show_all_forename'] = array(
    '#type' => 'radios',
    '#title' => t("Show second 'Forename' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_all_forename', 0),
    '#options' => $options_true_false,
  );

  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_show_town'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Town' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_town', 0),
    '#options' => $options_true_false,
  );

  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_show_officer_type'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Type' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_officer_type', 0),
    '#options' => $options_true_false,
    '#description' => t("If this is set to 'False', the default value set for
      OfficerSearch -> OfficerType on the 'Gateway Options' page is used in the
      form."),
  );

  $form['officer_search_page']['ch_xml_gateway_form_settings_OfficerSearch_show_include_resigned'] = array(
    '#type' => 'radios',
    '#title' => t("Show 'Include resigned appointments?' control"),
    '#default_value' => variable_get('ch_xml_gateway_form_settings_OfficerSearch_show_include_resigned', 0),
    '#options' => $options_true_false,
    '#description' => t("If this is set to 'False', the default value set for
      OfficerSearch -> IncludeResignedInd on the 'Gateway Options' page is used
      in the form."),
  );

  return system_settings_form($form);
}
