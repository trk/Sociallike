<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sociallike_Tags extends TagManager 
{
	public static $ci = NULL;
	public static $lang = NULL;
	
	/**
	 * If need load a model use this function
	 * 	@usage :
	 * 		self::load_model('your_model_name', 'your_mode_short_name');
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
	 * 			<ion:google_plus />
	 * 		</ion:sociallike>
	 */
	public static function googleplus($tag) {
		
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? 'href="' . base_url() . '"' : '';
		
		$google_plus = '<g:plusone size="medium" ' . $url . '></g:plusone>
						<script type="text/javascript">
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
	 * 			<ion:facebook />
	 * 		</ion:sociallike>
	 */
	public static function facebook($tag) {
		
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? 'data-href="' . base_url() . '"' : '';
		$lang_upper = (self::$lang == 'en') ? 'US' : strtoupper(self::$lang);
		$lang = self::$lang . '_' . $lang_upper;
		
		$facebook = '<div class="fb-like" ' . $url . ' data-layout="button_count"></div>
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
	 * 			<ion:twitter />
	 * 		</ion:sociallike>
	 */
	public static function twitter($tag) {
		
		$url = (isset($tag->attr['url']) && $tag->attr['url'] == 'base_url') ? 'data-url="' . base_url() . '"' : '';
		
		$twitter = '<a href="https://twitter.com/share" class="twitter-share-button" ' . $url . ' data-lang="' . self::$lang . '">Twitter</a>
					<script>
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
	 * 		<ion:comments>
	 * 			<ion:comments>
	 * 				........
	 * 			</ion:comments>
	 * 		</ion:comments>
	 */
	public static function comments(FTL_Binding $tag)
	{		
		// Order. Default order : ordering ASC
		$order_by = (isset($tag->attr['order_by']) && $tag->attr['order_by'] != '') ? $tag->attr['order_by'] : 'created ASC';
		
		if(self::$user && self::$user['group']['level'] >= 1000) {
			$where = array('id_article' => $tag->locals->article['id_article'], 'order_by' => $order_by);
		} else {
			$where = array('id_article' => $tag->locals->article['id_article'], 'status' => 1, 'order_by' => $order_by);
		}		
		
		self::load_model('comments_model', '');
		
        $comments = self::$ci->comments_model->get_list($where);
		
		$tag->locals->count_comments = count($comments);
		
		$output = '';
		
		foreach ($comments as $comment)
		{
			$tag->locals->comment = $comment;

			$output .= $tag->expand();
		}
		
		return $output;
	}

	/**
	 * @usage :
	 * 		<ion:comments>
	 * 			<ion:comment_allowed />
	 * 		</ion:comments>
	 */
	public static function comment_allowed(FTL_Binding $tag){
		self::load_model('article_model', '');
        $comment_allowed = self::$ci->article_model->get_row_array($tag->locals->article['id_article']);
		
		$tag->locals->comment_allowed = $comment_allowed;
		
		return ($tag->locals->comment_allowed['comment_allow'] && $tag->locals->comment_allowed['comment_allow'] != '' && $tag->locals->comment_allowed['comment_allow'] == 1) ? 1 : 0;
	}
	
	// <ion:count_comments />
	public static function count_comments(FTL_Binding $tag){
		self::load_model('comments_model', '');
		return count(self::$ci->comments_model->get_list(array('id_article' => $tag->locals->article['id_article'], 'status' => 1)));
	}	
	// <ion:id_comment />
	public static function id_comment($tag) { return self::wrap($tag, $tag->locals->comment['id_article_comment']); }
	// <ion:id_article />
	public static function id_article($tag) { return self::wrap($tag, $tag->locals->comment['id_article']); }
	// <ion:author />
	public static function author($tag) { return self::wrap($tag, $tag->locals->comment['author']); }
	// <ion:email />
	public static function email($tag){
		if(self::$user && self::$user['group']['level'] >= 1000)
			return self::wrap($tag, $tag->locals->comment['email']);
		return '';
	}
	// <ion:site />
	public static function site($tag) { return self::wrap($tag, $tag->locals->comment['site']); }
	// <ion:content />
	public static function content($tag) { return self::wrap($tag, $tag->locals->comment['content']); }
	// <ion:ip />
	public static function ip($tag) {		
		if(self::$user && self::$user['group']['level'] >= 1000)
			return self::wrap($tag, $tag->locals->comment['ip']);
		return '';
	}
	// <ion:status />
	public static function status($tag) { return self::wrap($tag, $tag->locals->comment['status']); }
	// <ion:date />
	public static function date($tag)
	{
		if ( ! empty($tag->attr['from']))
		{
			$tag->attr['name'] = 'date';
			return self::tag_field($tag);
		}
		return self::wrap($tag, self::format_date($tag, $tag->locals->comment['created']));
	}
	// <ion:admin />
	public static function admin($tag) { return self::wrap($tag, $tag->locals->comment['admin']); }
	// <ion:id_reply />
	public static function id_reply($tag) { return self::wrap($tag, $tag->locals->comment['id_reply']); }
	// <ion:editor />
	public static function editor($tag) { return (self::$user && self::$user['group']['level'] >= 1000) ? 1 : 0; }
}