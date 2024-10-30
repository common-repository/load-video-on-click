<?php
defined( 'ABSPATH' ) || exit;
vc_map( array(
	'name' => __( 'Video on click', 'load-video-on-click' ),
	'base' => 'load_video_on_click',
	'icon' => 'icon-eosb-video-icon',
	'category' => __( 'Content', 'load-video-on-click' ),
	'description' => __( 'Load video on click', 'load-video-on-click' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Video link', 'load-video-on-click' ),
			'param_name' => 'link',
			'value' => '',
			'admin_label' => true,
			'description' => __( 'Enter the link to the video.', 'load-video-on-click' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Video width', 'load-video-on-click' ),
			'param_name' => 'el_width',
			'value' => array(
				'100%' => '100',
				'90%' => '90',
				'80%' => '80',
				'70%' => '70',
				'60%' => '60',
				'50%' => '50',
				'40%' => '40',
				'30%' => '30',
				'20%' => '20',
				'10%' => '10',
			),
			'description' => __( 'Select video width (percentage).', 'load-video-on-click' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Video aspect ration', 'load-video-on-click' ),
			'param_name' => 'el_aspect',
			'value' => array(
				'16:9' => '169',
				'4:3' => '43',
				'2.35:1' => '235',
			),
			'description' => __( 'Select video aspect ratio.', 'load-video-on-click' ),
		),
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'load-video-on-click' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'load-video-on-click' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Related videos (only for Youtube)','load-video-on-click' ),
			'param_name' => 'rel',
			'std' => '0',
			'class' => '',
			'value' => array( __( 'Hide related videos at end','load-video-on-click' ) => '0',__( 'Allow related videos at end','load-video-on-click' ) => '1' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Load on click','load-video-on-click' ),
			'param_name' => 'load_on_click',
			'std' => 'on',
			'class' => '',
			'value' => array( __( 'Load on page load','load-video-on-click' ) => 'off',__( 'Load on click','load-video-on-click' ) => 'on' )
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image placeholder','load-video-on-click' ),
			'param_name' => 'image_placeholder',
			'std' => '0',
			'class' => '',
			'dependency' => array(
				'element' => 'load_on_hover',
				'value' => 'on',
			),
			'admin_label' => true,
			'description' => __( 'It will appear instead of the video. The video will load on click.','load-video-on-click' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'load-video-on-click' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'load-video-on-click' ),
		)
	)
) );
