<?php
defined( 'ABSPATH' ) || exit;

$link = $allowfullscreen = $el_class = $el_id = $el_width = $el_aspect = $rel = $image_placeholder = '';
$args = array(
	'link' => '',
	'el_id' => '',
	'el_width' => '100',
	'el_aspect' => '169',
  'el_class' => '',
	'image_placeholder' => '',
	'load_on_click' => 'on',
	'btn_bg' => 'grey',
	'btn_col' => '#fff',
	'rel' => '0'
);
$inline_style = '
.vc-inner iframe,.eosb_video-bg iframe{
    max-width:none
}
.eosb_video-bg{
    height:100%;
    overflow:hidden;
    pointer-events:none;
    position:absolute;
    top:0;
    left:0;
    width:100%;
    z-index:0
}
.eosb_video-el-width-' . esc_attr( $el_width ).' .eosb_wrapper{
    width:'.esc_attr( $el_width ).'%
}
.eosb_video_widget .eosb_video_wrapper{
    padding-top:56.25%;
    position:relative;
    width:100%
}
.eosb_video_wrapper>div{
    padding-top:0!important;
    position:static
}
.eosb_video-aspect-ratio-169 .eosb_video_wrapper{
    padding-top:56.25%
}
.eosb_video-aspect-ratio-43 .eosb_video_wrapper{
    padding-top:75%
}
.eosb_video-aspect-ratio-235 .eosb_video_wrapper{
    padding-top:42.55319149%
}
.eosb_video_widget .eosb_wrapper iframe{
    width:100%;
    height:100%;
    display:block;
    position:absolute;
    margin:0;
    top:0;
    left:0;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box
}';
if( !is_array( $atts ) || empty( $atts ) ) return;
foreach( $atts as $att => $v ){
	$atts[$att] = str_replace( '″','',str_replace( '”','',$atts[$att] ) );
}
extract( shortcode_atts($args, $atts) );
if ( '' === $link ) {
	return null;
}
$image_placeholder = apply_filters( 'load_video_on_click_image_placeholder',$image_placeholder,$atts );
$script = '';
$video_w = 500;
$video_h = $video_w / 1.61; //1.61 golden ratio
global $wp_embed;
$embed = $provider = '';
if( false !== strpos( $link,'//vimeo.com/' ) ){
  $provider = '_vimeo';
	$link = str_replace( '//vimeo.com/','//player.vimeo.com/video/',$link );
	if( false === strpos( $link,'?h=' ) ){
		$lastArr = explode( '/',$link );
		$n = 0;
		foreach( $lastArr as $url_part ){
			if( 'video' === $url_part ){
				if( isset( $lastArr[$n + 1] ) && isset( $lastArr[$n + 2] ) ){
					$link =  str_replace( '/'.$lastArr[$n + 2],'?h='.$lastArr[$n + 2],$link );
					break;
				}
			}
			++$n;
		}
	}
	$link = add_query_arg( 'dnt','1',$link );
}
elseif( false !== strpos( $link,'youtube.com' ) && false !== strpos( $link,'watch?v' ) ){
  $provider = '_youtube';
	$link = str_replace( 'watch?v=','embed/',$link );
	if( 1 === substr_count( $link,'&' ) ){
		$link = str_replace( '&amp;','?',$link );
	}
	elseif( substr_count( $link,'&' ) > 1 ){
		$link = preg_replace( '/\&/','?',$str,1 );
	}
}
elseif( false !== strpos( $link,'://youtu.be/' ) ){
  $provider = '_youtube';
	$link = str_replace( '://youtu.be/','://www.youtube.com/embed/',$link );
}
elseif( false !== strpos( $link,get_home_url() ) ){
	$provider = '_self';
}
$link = str_replace( 'youtube.com','youtube-nocookie.com',$link );
if( $rel !== '1' ){
	$link = add_query_arg( 'rel','0',$link );
}
$style = '';
$id = 'eos-video-'.substr( md5( implode( '',array_values( $atts ) ) ),0,8 );
$spinner = $play_icon = '';
if ( is_object( $wp_embed ) ) {
	$src = ' src="'.esc_url( $link ).'"';
	$allowfullscreen = $allowfullscreen && '' !== $allowfullscreen ? $allowfullscreen : ' allowfullscreen';
	$tag = 'iframe';
	if( 'off' !== apply_filters( 'load_video_on_click'.esc_attr( sanitize_key( $provider ) ),$load_on_click ) ){
		if( false !== strpos( $link,'youtube' ) && ( '' === $image_placeholder || 0 === absint( $image_placeholder ) ) ){
			$a = explode( 'embed/',$link );
			if( isset( $a[1] ) ){
				$a = explode( '?',$a[1] );
				$thumbnail = esc_url( 'https://img.youtube.com/vi/'.esc_attr( $a[0] ).'/hqdefault.jpg' );
			}
		}
		else{
			$thumbnail = esc_url( $image_placeholder ) === $image_placeholder ? esc_url( $image_placeholder ) : wp_get_attachment_url( absint( $image_placeholder ) );
		}
		$play_icon = '<svg id="'.esc_attr( $id ).'-btn" class="hover" style="position:absolute;width:70px;top:50%;left:50%;right:50%;height:48px;margin-top:-24px;margin-left:-35px;margin-right:-35px" height="100%" width="100%"><path d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="'.esc_attr( $btn_bg ).'"></path><path d="M 45,24 27,14 27,34" fill="'.esc_attr( $btn_col ).'"></path></svg>';
		$spinner = '<img style="position:absolute;top:50%;left:50%;right:50%;width:32px;height:32px;margin:-16px;display:none" src="'.LOAD_VIDEO_ON_CLICK_PLUGIN_URL.'/assets/img/ajax-loader.gif" />';
		$src = '';
		$tag = 'div';
		$link = add_query_arg( 'autoplay','1',$link );
		$script .= '<script>document.getElementById("'.$id.'-btn").addEventListener("click",function(){var d=document.getElementById("'.esc_js( esc_attr( $id ) ).'-iframe"),i=document.createElement("iframe");if(d){document.getElementById("'.esc_js( esc_attr( $id ) ).'-btn").parentNode.getElementsByTagName("img")[0].style.display="inline-block";i.allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";i.src="'.esc_js( esc_url( $link ) ).'";i.width="'.esc_js( esc_attr( $video_w ) ).'";i.height="'.esc_js( esc_attr( round( $video_h,1 ) ) ).'";d.parentNode.replaceChild(i,d);}})</script>';
		$style = ' style="background-image:url('.$thumbnail.');background-size:cover;background-repeat:no-repeat;background-position:center"';
	}
	$embed = '<'.esc_attr( $tag ).' id="'.esc_attr( $id ).'-iframe" width="'.esc_attr( $video_w ).'" height="'.esc_attr( round( $video_h,1 ) ).'"'.$src.esc_attr( $allowfullscreen ).'></'.esc_attr( $tag ).'>'.$script;
}
$el_classes = array(
	'eosb_video_widget',
	'eosb_content_element',
	'eosb_clearfix',
	esc_attr( $el_class ),
	'eosb_video-aspect-ratio-' . esc_attr( $el_aspect ),
	'eosb_video-el-width-' . esc_attr( $el_width )
);
$css_class = implode( ' ', $el_classes );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$wrapper_attributes[] = 'style="position:relative"';
$output = '
	<div class="'.esc_attr( $css_class ).'" '.implode( ' ',$wrapper_attributes ).'>
		<div class="eosb_wrapper" style="position:relative"><div id="'.esc_attr( $id ).'" class="eosb_video_wrapper"'.$style.'>'.$play_icon.$spinner.$embed.'</div></div>';
$output .= '</div>';
$output = '<style id="'.$id.'-css">'.strip_tags( sanitize_text_field( $inline_style ) ).'</style>'.$output;
