Module enabling Drupal to access to the Companies House XML 
(output) Gateway using the php-govtalk library, by
Alex Sansom (http://alex-sansom.info).

Companies House XML Gateway documentation is available at:

    http://xmlgw.companieshouse.gov.uk/

php-govtalk information is available at:

    http://code.google.com/p/php-govtalk/

Install the module as per any other Drupal module and enable it in
the site admin screen.

You will need to configure permissions to allow users other than
user id = 1 to be able to use the gateway at:

    http://<your_domain>/admin/people/permissions

BE CAREFUL WHO YOU GIVE PERMISSION TO WHICH SERVICES. SOME SERVICES
ARE CHARGEABLE. See:

	http://xmlgw.companieshouse.gov.uk/CHDpriceList.shtml

If you do not have your own login to the gateway, the services will
always return the same data. Enter your login details using the form 
under:

    Admin -> 'Site configuration' -> 'Companies House XML Gateway'

To apply for an account, please see info at:

    http://xmlgw.companieshouse.gov.uk/faq.shtml#hdiafaxga

Search for a company by name:

    http://<your_domain>/chxmlgw/company-search
	
Search for company 'officer' information by name:

    http://<your_domain>/chxmlgw/officer-search

Find information about a company from it's Companies House company 
number:

    http://<your_domain>/chxmlgw/company-details

Find out company appointments from a company number:

    http://<your_domain>/chxmlgw/appointments-search

If you've listed a company's appointments, you can view further info
about a specific person (that may have many appointments):

    http://<your_domain>/chxmlgw/officer-details/<encrypted_key>

    <encrypted_key> is returned in the 'appointments-search' results.

A demonstration can be seen by going to /chxmlgw/company-search in 
the browser, after module install and by following the links in the 
results returned by the Companies House test service. 

The module also makes available a number of Drupal blocks so that 
the search forms can be placed in other areas of the site. See:

    Admin -> Site building -> Blocks

Users use of the gateway is recorded into a DB table 'ch_xml_gateway_query'
and each user can see their usage history from a link on their account page,
displayed after login. Users, apart from user id=1, cannot view each others
history. See:

    http://<your_domain>/chxmlgw/gateway-history/user/<user_id>

There are a number of configuration settings available that affect
the display/behaviour of the forms (use AJAX etc), see:

    http://<your_domain>/admin/settings/chxmlgw

NOTE(S):

If you are disabling the module after use, also use the Drupal admin
module uninstall option so as to let the module clean up the 'variable'
database table.

If you have any trouble getting the module working, it may be 
because you do not have an PHP/XML component that the php-govtalk 
library that the module is using relies upon. You should install 
php-xml with:

yum install php-xml (or equivalent for your platform)

My development environment was with Drupal 7.12 and PHP 5.3.10 (and also
tested with 5.2.9-2) on Win XP/Vista.