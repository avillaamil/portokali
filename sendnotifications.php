<?php
	/* Send an SMS using Twilio. You can run this file 3 different ways:
	 *
	 * - Save it as sendnotifications.php and at the command line, run 
	 *        php sendnotifications.php
	 *
	 * - Upload it to a web host and load mywebhost.com/sendnotifications.php 
	 *   in a web browser.
	 * - Download a local server like WAMP, MAMP or XAMPP. Point the web root 
	 *   directory to the folder containing this file, and load 
	 *   localhost:8888/sendnotifications.php in a web browser.
	 */
	// Include the PHP Twilio library. You need to download the library from 
	// twilio.com/docs/libraries, and move it into the folder containing this 
	// file.
	require "Services/Twilio.php";

	// Set our AccountSid and AuthToken from twilio.com/user/account
	$AccountSid = 'AC72311e860888d737ad39b2355613d545'; 
	$AuthToken = '17c6a48528fcb0cf7d0aee6579c2b966'; 

	
	// Instantiate a new Twilio Rest Client
	$client = new Services_Twilio($AccountSid, $AuthToken);


$people = array(
        "+13053369765"=>"Alessandra"
        // "+17866299267"=>"Twilio"
     
    );

	$body = $_REQUEST['Body'];
	$body_int = (float)$body ;
	$body_tip = $body_int *0.15;
	// number_format((float)$body_tip, 2, '.', '');
	$body_total = $body_int + $body_tip;
	// number_format((float)$body_total, 2, '.', '');

    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(!$name = $people[$_REQUEST['From']]){
    	
        $name = "Computer";



        
  //       /* Your Twilio Number or Outgoing Caller ID */
		// $from =  "+17866299267";
		// $to = "3053369765";
		// $body = "Hi Ali you don't have any more money, Sorry :(";
		// $client->account->sms_messages->create($from, $to, $body);
		// echo "Sent message to $to";

		header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    }
    
   

?>

<Response>
    <Message> Hi <? echo $name?>. You should tip at least $<? echo number_format((float)$body_tip, 2, '.', '');?>, for a total of $<?echo number_format((float)$body_total, 2, '.', '');?> </Message>
</Response>