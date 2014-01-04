<html>
<body>
<table border=1>

<?php

function get_roles($startup_id, $role) {
	
  // Create a curl handle
  $ch = curl_init();

  // Escape a string used as a GET parameter
  $location = urlencode($row->id);
  $url = "https://api.angel.co/1/startup_roles?v=1&startup_id={$startup_id}&role={$role}";

  // Send HTTP request 
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $curl_result = curl_exec($ch);
  $curl_result = json_decode($curl_result);
  return $curl_result;
  curl_close($ch);
}

function print_roles($startup_roles, $name, $id) {
	foreach($startup_roles->startup_roles as $role) {
	echo "<tr><td>{$name} ({$id})</td>";
	  if ($role->role == "past_investor") {
	    echo "<td>Past Investor</td><td>".$role->tagged->name."</td>";
	  }
	  if ($role->role == "current_investor") {
	    echo "<td>Current Investor</td><td>".$role->tagged->name."</td>";
	  }
	echo "</tr>";	
	}
		
}


//iterate over each startup

mysql_connect("localhost", "root", "root");
mysql_select_db("angellist");
$startup_id_list = mysql_query("select * from id");

while ($startup_id = mysql_fetch_object($startup_id_list)) {
	if($startup_id->id) {
	  

	  //get past investors
	  print_roles(get_roles($startup_id->id, "past_investor"), $startup_id->name, $startup_id->id);
	  //print_roles($startup_roles);
	  

	  
//	  $startup_roles = get_roles($startup_id->id, "current_investor");
	  print_roles(get_roles($startup_id->id, "current_investor"), $startup_id->name, $startup_id->id);
    }
    else {
    	echo "<tr><td>{$startup_id->name}</td><td></td><td></td></tr>";
    }
    
}


 ?>
  