<?php

include_once('config.php');
$dbmethod = new dbmethod();

if(isset($_POST['submit'])){
    //get photo url
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/oembed/?url='.$_POST['url']);
    $data = curl_exec($ch);
    curl_close($ch);

    //process
    $decode = json_decode($data,true);
    $imgurl = $decode['thumbnail_url'];
    $imgname = explode('/',$imgurl);
    $imgname = end($imgname);

    //save photo from url to hosting
    $ch = curl_init($imgurl);
    $fp = fopen('uploads/'.$imgname, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    $caption = 'from @'.$decode['author_name'].' '.$decode['title'];
    $dbmethod->insertimg($imgname,$caption);
}
?>