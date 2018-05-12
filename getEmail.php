<?php
require ('simple_html_dom.php');

$fake = "http://www.fakemailgenerator.com";
//$fake = "http://www.google.ca";

function loadPage($page){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $page);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function getUserName($str){
    $len = strpos($str, "@");
    return substr($str,0,$len);
}

function getDomain($str){
    $len = strlen(getUserName($str))+1;
    return str_replace(" ","",substr($str,$len));
}

function saveToFile(){
    $file = fopen("fakeEmail.txt", 'w');
    $fakeEmail = getFakeEmail();
    fwrite($file, $fakeEmail);
    fclose($file);
}

function readFromFile(){
    $file = fopen("fakeEmail.txt", 'r');
    $fakeEmail = fgets($file);
    echo $fakeEmail;
}

function getFakeEmail(){
    global $fake;
    $response = loadPage($fake);
    $html = new simple_html_dom();
    $html->load($response);

    $email1 = $html->getElementById('home-email')->attr["value"];
    $email2 = $html->getElementById('domain')->innertext;
    $fakeEmail = $email1.$email2;
    return str_replace(" ","",$fakeEmail);
}


function getFakeConfirm(){
    $fakeMail = readFromFile();
    $domain = getDomain($fakeMail);
    $username = getUserName($fakeMail);

    $site = "http://www.fakemailgenerator.com/inbox/".$domain."/".$username."/";

    $response = loadPage($site);
    $theFakeLink = "";
    $html = new simple_html_dom();
    $html->load($response);

    $fakeLink = $html->getElementsByTagName('li')->children[0]->attr["href"];
    $goLink = "http://www.fakemailgenerator.com".$fakeLink;
    $response = loadPage($goLink);
    $html->load($response);

    $link = $html->getElementById('emailFrame')->attr["src"];
    $response = loadPage($link);
    $fakeConfirm = $html->load($response);

    foreach ($fakeConfirm->find('a[href^=http]') as $link){
        if(strlen($link->innertext)>25){$theFakeLink = $link;break;}}
    $response = loadPage($theFakeLink->attr["href"]);
    echo $html->load($response);
}

saveToFile();
readFromFile();





