<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'neve_child_load_css' ) ):
	/**
	 * Load CSS file.
	 */
	function neve_child_load_css() {
		wp_enqueue_style( 'neve-child-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'neve-style' ), NEVE_VERSION );
	}
endif;
add_action( 'wp_enqueue_scripts', 'neve_child_load_css', 20 );

add_action( 'wpcf7_before_send_mail', 'contactform7lead' );
function contactform7lead($cf7)
{
    $submission = WPCF7_Submission::get_instance();
    $args = array();
    if($submission)
    {
        $data = $submission->get_posted_data();
        $args['Token'] = 'e8fd5b3c-1378-459a-8953-e39a229f7c8b';
        $args['Nome'] = $data['nome'];
        $args['Email'] = $data['email'];
        $args['Mensagem'] = $data['mensagem'];
        $args['Celular'] = $data['celular'];
        $args['Conversao'] = $cf7->title();
	$args['Origem'] = 'Site';
        // $args['Tags'] = 'tag1,tag2';
        $args['Fonte'] = $data['origem'][0];
        $args['Pax'] = $data['pax'];
        $args['DataEvento'] = $data['dataevento'];
        $args['TipoEvento'] = $data['tipoevento'][0];
    }
    $result = wp_remote_post('https://api.kazah.io/apiv1/lead', array('body' => $args));
}


