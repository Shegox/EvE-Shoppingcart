<?php
include_once "crest.php";
include_once "sql.php";
include_once "constants.php";

// surpress non critical errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

// getRefreshTokenAndSQL ( $_GET ["code"] );
function getRefreshTokenAndSQL($code) {
	$error = false;
	try {
		$auth_infos = getTokensFromCode ( $code, "authorization_code" );
		$refresh_token = $auth_infos->refresh_token;
		$auth_code = $auth_infos->access_token;
		$charInfo = getCharInfo ( $auth_code );
		$charID = $charInfo->id;
		$charName = $charInfo->name;
		if ($charID == NULL) {
			throw new Exception ( "Wrong Object! Error" );
		}
	} catch ( Exception $e ) {
		
		echo 'FEHLER! Please logIn again';
		header ( "Location: {$GLOBALS["LOGINURL"]}" );
		exit ();
		$error = true;
	}
	if ($error == false) {
		// echo $auth_code;
		// echo $charID;
		// echo $refresh_token;
		$time = time ();
		sql_write ( "INSERT INTO `characters`(`characterID`, `characterName`, `refreshToken`) VALUES ('$charID','$charName','$refresh_token')" );
		sql_write ( "UPDATE `characters` SET `refreshToken`='$refresh_token' WHERE `characterID`='$charID';" );
		sql_write ( "UPDATE `characters` SET `changed`=NOW() WHERE `characterID`='$charID';" );
		echo "You are added/updated to the watchlist tool. To remove your char please delete this application from your list. You can now close this window.";
	}
}
function getCharInfo($auth_code) {
	$charUrl = curl_get ( "https://crest-tq.eveonline.com/decode/", $auth_code )->character->href;
	$charInfo = curl_get ( $charUrl, $auth_code );
	return $charInfo;
}
function getTokensFromCode($code, $grant_type) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, "https://login-tq.eveonline.com/oauth/token/" );
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// Does not verify peer
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	
	// $BASICAUTH = global $BASICAUTH;
	$headers = array (
			"Authorization: Basic {$GLOBALS["BASICAUTH"]}",
			"Content-type: application/x-www-form-urlencoded" 
	);
	// headers
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	$post ["grant_type"] = "authorization_code";
	$post ["code"] = $code;
	// grant_type = authorization_code ; initial request
	// grant_type = refresh_token; for request with refresh_token
	if ($grant_type == "refresh_token") {
		$parameter = "refresh_token";
	} elseif ($grant_type == "authorization_code") {
		$parameter = "code";
	}
	$post = "grant_type=$grant_type&$parameter=$code";
	// echo $post;
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
	$response = curl_exec ( $ch );
	curl_close ( $ch );
	$response = json_decode ( $response );
	
	return $response;
}

?>