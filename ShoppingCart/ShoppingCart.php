<?php
Include "crestLogIn.php";
$auth_code = $_POST ["auth_code"];

$charInfo = getCharInfo($auth_code);
$items = [];
foreach ($_POST ["items"] as $item) {
    $item = json_decode($item);
    $itemAdd = [];
    $itemAdd ["name"] = $item [0];
    $itemAdd ["quantity"] = $item [1];
    $items [] = $itemAdd;
}
postCart($items, $auth_code, $_POST ["name"], getCharInfo($auth_code)->id);
function getItemID($name)
{
    $id = sql_read("SELECT * FROM `invTypes` WHERE `typeName`='$name'") [0] ["typeID"];
    // echo $id;
    return $id;
}

function postCart($items, $auth_code, $name, $charID)
{
    $post = [];
    $post ["name"] = $name;
    $post ["description"] = "Added by Shegox Shoppingcart";
    foreach ($items as $item) {
        //print_r ( $item );
        //echo "test";
        $itemID = getItemID(addslashes($item ["name"]));
        if ($itemID != "") {
            $itemArr = [];
            $itemArr ["flag"] = 5;
            $itemArr ["quantity"] = ( int )$item ["quantity"];
            $itemArr ["type"] ["id"] = ( int )$itemID;
            $itemArr ["type"] ["name"] = $item ["name"];
            $itemArr ["type"] ["href"] = "http://crest.regner.dev/types/$itemID/";
            $post ["items"] [] = $itemArr;
        }
    }
    $post ["ship"] ["id"] = 670;
    $post ["ship"] ["name"] = "Capsule";
    $post ["ship"] ["href"] = "http://crest.regner.dev/types/670/";

    $post = json_encode($post);

    $url = "https://crest-tq.eveonline.com/characters/$charID/fittings/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Does not verify peer
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Get the response and close the channel.
    $headers = array(
        "Authorization: Bearer " . $auth_code,
        "Content-type: json"
    );
    // headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // Post options, for get comment out
    curl_setopt($ch, CURLOPT_POST, 1);
    // $post["blocked"] = true;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    // curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10);
    $response = curl_exec($ch);
    $response = json_decode($response);


    if (curl_getinfo($ch) ["http_code"] == 201) {
        echo "Shopping list posted to Capsule. Fitting name $name";
    } else {
        echo "Error, please see below for the error log from the EvE-Server $response->message";
    }
    curl_close($ch);

}