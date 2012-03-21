<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sociallike_Tags extends TagManager 
{
	public static $ci = NULL;
	public static $lang = NULL;
	
	/**
	 * If need load a model use this function
	 * 	@usage :
	 * 		self::load_model('your_model_name', 'your_model_short_name');
	 */
	private static function load_model($model_name, $new_name='') {
		
        if (!isset(self::$ci->{$new_name}))
            self::$ci->load->model($model_name, $new_name, true);
    }
	
	/**
	 * @usage :
	 * 		<ion:sociallike>
	 * 			........
	 * 		</ion:sociallike>
	 */
	public static function index(FTL_Binding $tag)
	{
		self::$ci = &get_instance();
		self::$lang = Settings::get_lang();
		
		return $tag->expand();
	}
	
	/**
	 * @usage :
	 * 		<ion:sociallike>
	 * 			<ion:google_plus size="null(for standart), small, medium, tall" annotation="null(for standart), none, inline" width="300" url="base_url" js="false" />
	 * 		</ion:sociallike>
	 *	
	 */
	public static function googleplus($tag) {
		// Parameters for Size : null(for standart), small, medium, tall
		$size = (isset($tag->attr['size']) && $tag->attr['size'] != '') ? ' size="' . $tag->attr['size'] . '"' : '';
		// Parameters for annotation : null(for standart), none, inline
		$annotation = (isset($tag->attr['annotation']) && $tag->attr['annotation'] != '') ? ' annotation="' . $tag->attr['annotation'] . '"' : '';
		// Width of your share button (if you set annotation option : inline)
		$width = (isset($tag->attr['width']) && $tag->attr['witdh'] != '') ? 'width="' . $tag->attr['width'] . '"' : '';
		// If you type "base_url" will share the website url. if url is empty will share current url
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? ' href="' . base_url() . '"' : '';
		
		$google_plus = '<g:plusone' . $size . $annotation . $width . $url . '></g:plusone>';
		$js = (isset($tag->attr['js']) && $tag->attr['js'] == 'false') ? FALSE : TRUE;
		if($js === TRUE)
			$google_plus .= '<script type="text/javascript">
								window.___gcfg = {lang: \'' . self::$lang . '\'};
								(function() {
									var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
									po.src = "https://apis.google.com/js/plusone.js";
									var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
								})();
							</script>';
							
		return $google_plus;
	}
	
	/**
	 * @usage :
	 * 		<ion:sociallike>
	 * 			<ion:facebook send="false" layout="button_count" width="450" show-faces="false" action="recommend" colorscheme="dark" js="false" />
	 * 		</ion:sociallike>
	 */
	public static function facebook($tag) {
		
		/**
		 * Parameters for Send : true, false
		 * specifies whether to include a Send button with the Like button. This only works with the XFBML version.
		 **/
		$send = (isset($tag->attr['send']) && $tag->attr['send'] != '') ? ' data-send="' . $tag->attr['send'] . '"' : '';
		
		/**
		 * Parameters for Layout :
		 * 	standard,
		 * 		(displays social text to the right of the button and friends'
		 * 		 profile photos below. Minimum width: 225 pixels.
		 * 		 Minimum increases by 40px if action is 'recommend'
		 * 		 by and increases by 60px if send is 'true'.
		 * 		 Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).)
		 *	button_count,
		 *		(displays the total number of likes to the right of the button.
		 * 		 Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.)
		 *	box_count,
		 * 		(displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.)
		 **/
		$layout = (isset($tag->attr['layout']) && $tag->attr['layout'] != '') ? ' data-layout="' . $tag->attr['layout'] . '"' : '';
		
		// Parameters for Width : the width of the Like button
		$width = (isset($tag->attr['width']) && $tag->attr['width'] != '') ? ' data-width="' . $tag->attr['width'] . '"' : '';
		
		/**
		 * Parameters for Show Faces : true, false
		 * 		specifies whether to display profile photos below the button (standard layout only)
		 **/
		$show_faces = (isset($tag->attr['show_faces']) && $tag->attr['show_faces'] != '') ? ' data-show-faces="' . $tag->attr['show_faces'] . '"' : '';
		
		/**
		 * Parameters for Action : null(for like option), recommend
		 * 		the verb to display on the button.
		 **/
		$action = (isset($tag->attr['action']) && $tag->attr['action'] != '') ? ' data-action="' . $tag->attr['action'] . '"' : '';
		
		/**
		 * Parameters for Font : arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana
		 * 		the font to display in the button.
		 **/
		$font = (isset($tag->attr['font']) && $tag->attr['font'] != '') ? ' data-font="' . $tag->attr['font'] . '"' : '';
		
		/**
		 * Parameters for Color Scheme : null(light(default style)), dark
		 * 		the color scheme for the like button.
		 */
		$colorscheme = (isset($tag->attr['colorscheme']) && $tag->attr['colorscheme'] != '') ? ' data-colorscheme="' . $tag->attr['colorscheme'] . '"' : '';
		
		/**
		 * Parameters for Color Scheme : base_url, null (for current url)
		 **/
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? ' data-href="' . base_url() . '"' : '';
		
		$lang_upper = (self::$lang == 'en') ? 'US' : strtoupper(self::$lang);
		$lang = self::$lang . '_' . $lang_upper;
		
		$facebook = '<div class="fb-like"' . $send . $layout . $width . $show_faces . $action . $font . $colorscheme . $url . '></div>';
					
		$js = (isset($tag->attr['js']) && $tag->attr['js'] == 'false') ? FALSE : TRUE;
		if($js === TRUE)
			$facebook .= '<div id="fb-root"></div>
							<script>
								(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) return;
									  js = d.createElement(s); js.id = id;
									  js.src = "//connect.facebook.net/'. $lang .'/all.js#xfbml=1";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, \'script\', \'facebook-jssdk\'));
							</script>';
								
		return $facebook;
	}

	/**
	 * @usage :
	 * 		<ion:sociallike>
	 * 			<ion:twitter js="false" />
	 * 		</ion:sociallike>
	 */
	public static function twitter($tag) {
		
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? 'data-url="' . base_url() . '"' : '';
		
		$twitter = '<a href="https://twitter.com/share" class="twitter-share-button" ' . $url . ' data-lang="' . self::$lang . '">Twitter</a>';
		
		$js = (isset($tag->attr['js']) && $tag->attr['js'] == 'false') ? FALSE : TRUE;
		if($js === TRUE)
			$twitter .= '<script>
							!function(d,s,id){
							var js,fjs=d.getElementsByTagName(s)[0];
							if(!d.getElementById(id)){
								js=d.createElement(s);
								js.id=id;js.src="//platform.twitter.com/widgets.js";
								fjs.parentNode.insertBefore(js,fjs);
							}}(document,"script","twitter-wjs");
						</script>';
		return $twitter;
	}
	
	/**
	 * @usage :
	 * 		<ion:sociallike>
	 * 			<ion:js google_plus="true" facebook="true" twitter="true" />
	 * 		</ion:sociallike>
	 */
	public static function js($tag) {
		
		$google_plus = (isset($tag->attr['google_plus']) && $tag->attr['google_plus'] == 'true') ? TRUE : FALSE;
		$facebook = (isset($tag->attr['facebook']) && $tag->attr['facebook'] == 'true') ? TRUE : FALSE;
		$twitter = (isset($tag->attr['twitter']) && $tag->attr['twitter'] == 'true') ? TRUE : FALSE;
		
		$lang_upper = (self::$lang == 'en') ? 'US' : strtoupper(self::$lang);
		$fb_lang = self::$lang . '_' . $lang_upper;
		
		$js = '';
		
		if($google_plus === TRUE)
			$js .= '<script type="text/javascript">
						window.___gcfg = {lang: \'' . self::$lang . '\'};
						(function() {
							var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
							po.src = "https://apis.google.com/js/plusone.js";
							var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
						})();
					</script>';
		if($facebook === TRUE)
			$js .= '<div id="fb-root"></div>
					<script>
						(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/'. $fb_lang .'/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, \'script\', \'facebook-jssdk\'));
					</script>';
		if($twitter === TRUE)
			$js .= '<script>
						!function(d,s,id){
						var js,fjs=d.getElementsByTagName(s)[0];
						if(!d.getElementById(id)){
							js=d.createElement(s);
							js.id=id;js.src="//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js,fjs);
						}}(document,"script","twitter-wjs");
					</script>';
			
		return $js;
	}
}