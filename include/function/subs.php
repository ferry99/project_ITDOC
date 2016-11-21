 <?php

      // is the id of an admin?          
    Function IsAdmin() {
             if (!isset($_COOKIE['my_cookies1'])) { return false; }
             $my_cookies = explode("-", $_COOKIE['my_cookies1']); 
             $customerid = $my_cookies[1];
             if (is_null($customerid)) { return false; }
           $f_query = "SELECT * FROM user WHERE Username = '$customerid'" ;
             $f_sql = mysql_query($f_query) or die(mysql_error());
             while ($f_row = mysql_fetch_row($f_sql)) {
                   if ($f_row[2] == "1") { return true; }
                   else { return false; }
             }
             return false;
    }

    // is the visitor logged in?          
    Function LoggedIn() {
             if (!isset($_COOKIE['my_cookies1'])) { return false; }
             return true;
    }

    ?>