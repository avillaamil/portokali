<?php

	require "Services/Twilio.php";

  // Set our AccountSid and AuthToken from twilio.com/user/account
	$AccountSid = file_get_contents('alexid.txt');
	$AuthToken = file_get_contents('alexauth.txt');
  $alex = file_get_contents('alexnumber.txt');

	// Instantiate a new Twilio Rest Client
	$client = new Services_Twilio($AccountSid, $AuthToken);

  // start the session to set cookie
  session_start();
  // get the session varible if it exists get actual cookie
  $counter = $_SESSION['counter'];
  // add another session variable to hold the value attribute
  $values = $_SESSION['values'];

  // if it doesn't, set the default
  if(!strlen($counter)) {
        $counter = 0;
        // $daily_limit = 30.00;
    }

  // if it doesn't, set the default
  if(!strlen($values)) {
        $values = 30.00;
  }  

  // increment session counter
  $counter++;
  // and save back to session
  $_SESSION['counter'] = $counter;
  

  //an array of people that we can recognize - caller id style

$people = array(
    "+13472499500" =>"Alexander"
  // (int)$alex =>"Alexander"
        // "+17866299267"=>"Twilio"
     
    );

  $reset ='0000';
  if ($_REQUEST['Body'] == $reset){
    echo $_REQUEST['Body'];
    // $client->account->sms_messages->create("+19177467733","+13472499500", "Reset");

    session_destroy();


  }else{
    //assign body var to body contents
    $body = $_REQUEST['Body'];
    // $that = $_REQUEST['From'];
    //regex to extract number
    preg_match_all("/\$|\d+\W\d\d/", $body, $output_array);
    //assign to output_num var as float
    $output_num = (float)$output_array[0][0];
  }

  //calculate your daily limit if it's the first session
  if($counter == 1){
     $daily_limit = $values;
     $left_amount = $daily_limit - $output_num;
     $values = $left_amount;
     //save value to session
     $_SESSION['values'] = $values;
     
  }else{
    $values = $_SESSION['values'];
    $daily_limit = $values;
    $left_amount = $daily_limit - $output_num;
    $values = $left_amount;
    $_SESSION['values'] = $values;

  }
  

	// if the sender is known, then greet them by name
  // otherwise, consider them as "computer"
  if(!$name = $people[$_REQUEST['From']]){
      
        $name = "Computer";

    // /* Your Twilio Number or Outgoing Caller ID */
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
<Message> Hi <? echo $name?>. You SPENT $<? echo $output_num ?>. You have $<? echo $left_amount?> LEFT from daily limit of $30.00. Transaction <?echo $counter?></Message>
</Response>