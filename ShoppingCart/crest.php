<?php
function curl_multi_post_handle($url, $auth_code, $character_id, $character_name, $standing, $watched, $blocked) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// Does not verify peer
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// Get the response and close the channel.
	$headers = array (
			"Authorization: Bearer " . $auth_code,
			"Content-type: json" 
	);
	// auth header
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	// Post options, for get comment out
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	$post ["standing"] = ( int ) $standing;
	$post ["contactType"] = "character";
	$post ["contact"] = array ();
	$post ["contact"] ["id_str"] = "" . $character_id;
	$post ["contact"] ["href"] = "https://public-crest.eveonline.com/characters/" . $character_id . "/";
	$post ["contact"] ["name"] = $character_name;
	$post ["contact"] ["id"] = $character_id;
	$post ["watched"] = ( bool ) $watched;
	// $post["blocked"] = (BOOL) $blocked;
	$post = json_encode ( $post, JSON_UNESCAPED_UNICODE );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
	curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, true );
	return $ch;
}
function curl_post($url, $auth_code, $character_id, $character_name) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// Does not verify peer
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// Get the response and close the channel.
	$headers = array (
			"Authorization: Bearer " . $auth_code,
			"Content-type: json" 
	);
	// headers
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	// Post options, for get comment out
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	$post ["standing"] = 0;
	$post ["contactType"] = "character";
	$post ["contact"] = array ();
	$post ["contact"] ["id_str"] = "" . $character_id;
	$post ["contact"] ["href"] = "https://public-crest.eveonline.com/characters/" . $character_id . "/";
	$post ["contact"] ["name"] = $character_name;
	$post ["contact"] ["id"] = $character_id;
	$post ["watched"] = true;
	// $post["blocked"] = true;
	$post = json_encode ( $post, JSON_UNESCAPED_UNICODE );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
	curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, true );
	// curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10);
	$response = curl_exec ( $ch );
	curl_close ( $ch );
	$response = json_decode ( $response );
	return $response;
}
function curl_get($url, $auth_code) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// Does not verify peer
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// Get the response and close the channel.
	$headers = array (
			"Authorization: Bearer " . $auth_code 
	)
	// "Content-type: application/vnd.ccp.eve.warscollection-v1+json"
	;
	// auth header
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	// print_r($ch);
	$response = curl_exec ( $ch );
	// print_r($response);
	curl_close ( $ch );
	$response = json_decode ( $response );
	return $response;
}
function curl_get_public($url) {
	$ch = curl_init ();
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	$headers = array (
			"Cache-Control: no-cache" 
	);
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// Does not verify peer
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// Get the response and close the channel.
	// print_r($ch);
	$response = curl_exec ( $ch );
	// print_r($response);
	curl_close ( $ch );
	$response = json_decode ( $response );
	return $response;
}

?>