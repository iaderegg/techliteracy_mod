<?php
/**
 * Template Name: Comments_Dintev
 *
 */

global $wpdb;

	$data=array(    
            'Name' => '2',
            'Email' => '2',
            'Comment' => '2',
            'Tool' => '4'
        );
        $wpdb->insert($wpdb->prefix.'td_comments', $data);
    
    if(isset($_POST)){
        $data=array(    
            'Name' => $_POST['name'],
            'Email' => $_POST['email'],
            'Comment' => $_POST['comment'],
            'Tool' => $_POST['id']
        );
        $wpdb->insert($wpdb->prefix.'td_comments', $data);
    }
?>