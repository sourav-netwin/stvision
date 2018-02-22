<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ltelayout{
    public function __construct() { 
        //parent::__construct(); 
    } 
    
    /**
    * load
    *
    * Outputs a load give view with required header and footer template
    *
    * @access	public
    * @param	string	Name of the view
    * @return	string
    */
    function view($child_view_to_load = '',$data = array())
    {
            $CI = &get_instance();
            $data['content_view'] = $child_view_to_load;
            $CI->load->view('ltelayout/starter',$data);
    }
    
}