<?php
	if (file_exists($page . ".php")) {
	require_once  ($page . ".php");
	}
	else {
	  echo "no page";
	}

?>


