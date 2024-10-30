=== Load Video On Click ===
Contributors: giuse
Tags: video, videos, performace
Requires at least: 4.6
Tested up to: 5.9
Stable tag: 0.0.5
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Videos will not worse anymore the performance if they load only after clicking on the play button.


== Description ==

Videos will not worse anymore the performance if they load only after clicking on the play button.


== How to load videos on click ==
* Install and activate Load Video On Click
* Embed the videos using the shortcode [load_video_on_click] (see below) or by activating the switch "Load on click" of the Video and Embed blocks (in case of Gutenberg)


== Integrations ==

You can always add the provided shortcode, no matter which builder you are using. However, the actual version provides a full integration with the following builders (no need for the shortcode):
== ==
* WPBakery
* Gutenberg


== Shortcode ==

Shortcode name: load_video_on_click

== Shortcode parameters: ==
* link: Video URL
* el_id: ID for custom CSS
* el_aspect: video aspect ratio
* el_class: class for custom CSS
* image_placeholder: Image to be loaded instead of the video. You can use the ID or the URL of the image.
* load_on_click: Set on to load the video only after clicking on the button, or off to load it on page loading

Shortcode example:

[load_video_on_click link="https://www.youtube.com/watch?v=AQ3FoNHC6SU" image_placeholder="356"]

IF you embed a Youtube video and don't set the image placeholder parameter, the plugin will get it directly from Youtube.
For the other video providers or if you self host the video file, you need to set the parameter image_placeholder, in another case people will only see a play button before loading the video.


== Gutenberg ==

If you use Gutenberg, the  blocks Embed and Video will have the switch "Load on click". Activate that switch to load the embedded video after clicking on the play button.
Don't forget to set a Poster Image. It will be taken as placeholder before starting the video.


== Case study ==
Click <a href="https://gtmetrix.com/reports/josemortellaro.com/f4ZOXBNw/">here</a> to see the GTMetrix report of a blog post that includes a video.
As you can see even thought that blog post has a video, the score is 100/100. You can forget this kind of score just lazy loading the video, you need to load it after the click of the user.


== Help ==
For any question or if something doesn't work, don't hesitate to open a thread on the <a href="https://wordpress.org/support/plugin/load-video-on-click/">support forum</a>.


== For developers ==

= Filter hooks =

'load_video_on_click_for_blocks'

It enables/disables the loading on click for existing videos added with the Video and Embed blocks (Gutenberg).

Example:

`
add_filter( 'load_video_on_click_for_blocks','__return_true' ); //It enables the loading on click for all videos added with the Video and Embed blocks
`


'load_video_on_click_image_placeholder'

You can use it to replace the image placeholder.

Example:

`
add_filter( 'load_video_on_click_image_placeholder',function( $url,$attrs ){
  //$attrs is the array of parameters in case of shortcode, and the block attributes in case of Gutenberg blocks
  if( false !== strpos( $url,'yout' ) ){
    //Same image placeholder for all Youtube videos
    return wp_get_attachment_url( 2009 );
  }
  return $url;
},2,20 );
`


== Changelog ==


= 0.0.5 =
*Fix: stripped curly double-quotes when shortcode copied by the WordPress plugin page

= 0.0.4 =
*Fix: solved conflict with Real Cookie Banner


= 0.0.3 =
*Fix: displayed only first video

= 0.0.2 =
*Added: support to self hosted video
*Added: support to core/embed and core/video block

= 0.0.1 =
*Initial release
