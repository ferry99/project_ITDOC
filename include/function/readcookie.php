<?php
    // open the cookie and read the fortune ;-)
    $username = "";

	if (isset($_COOKIE['my_cookies1']))
	{
    $my_cookies = explode("-", $_COOKIE['my_cookies1']);
   // $name = $cookie_info[0];
    $username = $my_cookies[1];
	}
    //if ($customerid == NULL) { $customerid = 0; }
?>