<?php
/**
 * @package BuzzsproutSync
 */

 

if(class_exists('ScrapeData') ) //Trigger Scrape Class
{
    $ScrapeData = new ScrapeData();
}

include_once( ABSPATH . 'wp-includes/widgets.php' );
include_once( ABSPATH . 'wp-includes/wp-db.php' );

if (file_exists(dirname(__FILE__) . '/libraries/simple_html_dom.php') ) {
    include_once dirname(__FILE__) . '/libraries/simple_html_dom.php';
}

$arrContextOptions= //SSL error fix 
[
    'ssl' => [
        'cafile' => '/cacert.pem',
        'verify_peer'=> true,
        'verify_peer_name'=> true,
    ],
];


class ScrapeData //Class that checks if podcastid is set and scrapes buzzsprout
{

    public function register()
    {
        add_action('widgets_init', array( $this, 'scrapeModal' ));

        add_action('widgets_init', array( $this, 'databaseCheck' ));


    }


    public function databaseCheck() //Checks Database for podcastid
    {

    global $wpdb;

    $count = $wpdb->get_var("SELECT COUNT(option_value) FROM $wpdb->options WHERE option_name = 'podcastid'"); //Add Value of podcastid to $count variable
    if(!$count > 0) scrapeModal(); //If podcastid is greater than 0, trigger scrape function
    }




    public function scrapeModal() //Scrape Buzzsprout podcast social media content using simple html dom
    {

    global $wpdb;

    $podcastid = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'podcastid'" ); //Obtain Podcastid to use
    $html = file_get_html("https://www.buzzsprout.com/$podcastid"); //Download buzzsprout podcast page
    $scrape = $html->find('div[class=listen-modal]'); //filter out only the social links section
    $wpdb->insert('wp_buzzsync', array //insert data into database
        ( 
        'widgethtml' => '$scrape',
        ));
    
    }
}



$ScrapeData = new ScrapeData();
$ScrapeData->register();


