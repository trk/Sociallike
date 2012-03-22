<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sociallike extends Base_Controller 
{
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		print config_item('module_sociallike_name');
	}
}
