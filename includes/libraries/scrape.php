
<?php

require_once dirname( __FILE__ ) . 'simple_html_dom.php'

/*
$arrContextOptions= //SSL error fix 
*[
*    'ssl' => [
*        'cafile' => '/cacert.pem',
*        'verify_peer'=> true,
*        'verify_peer_name'=> true,
*    ],
*];
*/


Class ScrapeData //Class that checks if podcastid is set and scrapes buzzsprout
{

public function databaseCheck() //Chekcs Database for podcastid
{
    global $wpdb;

    $count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->options WHERE option_name = 'podcastid'"); //Add Value of podcastid to $count variable
    if(!($count > 1)) scrapeModal(); //If podcastid is greater than 1, trigger scrape function
}



public function scrapeModal() //Scrape Buzzsprout podcast social media content using simple html dom
{
    global $wpdb;

    $podcastid = esc_attr(get_option('podcastid'))
    $html = file_get_html('https://www.buzzsprout.com/$podcastid'); //Download buzzsprout podcast page
    $scrape = $html->find('div[class=listen-modal]'); //filter out only the social links section
    $wpdb->insert('wp_buzzsync', array //insert data into database
    ( 
        'widgethtml' => '$scrape',
));
    
}
}

if(class_exists('ScrapeData') ) //Trigger Scrape Class
{
    $ScrapeData = new ScrapeData();
}




$ScrapeData = new ScrapeData();
$ScrapeData->scrapeModal();


