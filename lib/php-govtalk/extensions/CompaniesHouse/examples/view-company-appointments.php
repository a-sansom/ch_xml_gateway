<?php

	 // Include the Companies House module...
require_once('../../../GovTalk.php');
require_once('../CompaniesHouse.php');

	// Include the Companies House configuration
require_once('config.php');

if (isset($_GET['companynumber'])) {

	$companiesHouse = new CompaniesHouse($chUserId, $chPassword);
	if ($companyAppointments = $companiesHouse->companyAppointmentsDetails($_GET['companyname'], $_GET['companynumber'], false)) {
            // print_r($companyAppointments);
            foreach ($companyAppointments['appointments'] AS $appointment) {
                echo 'Appointment name: '.$appointment['forename']. ' ' .$appointment['surname'].'<br />';
                echo 'Occupation: '.$appointment['occupation'].'<br /><br />';
            }
	} else {
	 // No companies found / error occured...
		echo 'No companies found for \''.$_GET['companynumber'].'\'.';
	}

} else {

	 // First page visit, display the search box...
?>

<form action="" method="get">
	Lookup company appointments:
        Name: <input name="companyname" type="text" value="MILLENNIUM STADIUM PLC"/>
        Number: <input name="companynumber" type="text" value="03176906"/>
        <input type="submit" value="Lookup" />
</form>

<?php

}

?>