<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getUserProfile($user_id) {
	global $connection;

	$query = "SELECT User_Info ";
	$query .= "FROM users ";
	$query .= "WHERE `#U`= ? ";
	$query .= "LIMIT 1";
	$stmt = $connection->prepare($query);
	$userInfo = $stmt->execute(array($user_id));
	confirm_query($userInfo);
	if ($userInfo_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$query = "SELECT * ";
		$query .= "FROM user_info ";
		$query .= "WHERE `#UI`= ? ";
		$query .= "LIMIT 1";
		$stmt = $connection->prepare($query);
		$stmt->execute(array($userInfo_id['User_Info']));
		try {
			$user_info_array = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $user_info_array;
	}
	else {
		return null;
	}
}

function renderUserInfo($user_info_array) {
	$image_path="media/user_profile_pics/";
	$output = "<div class=\"uk-grid\">";
	$output .= "<div class=\"uk-width-3-10\">";
        //displayed photo here
        $output .= "<img src=\"".$image_path.$user_info_array['ProfilePhoto'] . "\" />";
	$output .= "</div>";//close the photo box 
	$output .= "<div class=\"uk-width-7-10\">";
	$output .= "<ul>";
	$output .= "<li> Name: ".htmlentities($user_info_array['FirstName']."  ".$user_info_array["LastName"]);
	$output .= "<li> Age: ".$user_info_array["Age"];
	$output .= "<li> Gender: ".$user_info_array["Sex"];
	$output .= "<li> Email: ". htmlentities($user_info_array["EmailAddress"]);
	$output .= "</ul></div>";//close the userinfo grid
	$output .= "<div>"; // close the grid div 
	
	return $output;
}

?>
