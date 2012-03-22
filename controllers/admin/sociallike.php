<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sociallike extends Module_Admin 
{
	/**
	* Constructor
	*
	* @access	public
	* @return	void
	*/
	function construct()
	{
		// Config Model
		// $this->load->model('config_model', '', TRUE);
	}

	/**
	* Admin panel
	* Called from the modules list.
	*
	* @access	public
	* @return	parsed view
	*/
	function index()
	{
		$this->output('admin/sociallike');
	}

}

