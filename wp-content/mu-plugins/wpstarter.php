<?php
/*
Plugin Name: WP Starter
Description: A little utility plugin for the Lando development environment post. 
Version: 1.0.0
*/

function wpStarter_forceEmailToMailhog($phpmailer)
{
    if (getenv('LANDO')) {
        $phpmailer->IsSMTP();
        $phpmailer->Host = 'mailhog';
        $phpmailer->Port = 1025;
        $phpmailer->Username = '';
        $phpmailer->Password = '';
        $phpmailer->SMTPAuth = true;
    }
}
add_action('phpmailer_init', 'wpStarter_forceEmailToMailhog');