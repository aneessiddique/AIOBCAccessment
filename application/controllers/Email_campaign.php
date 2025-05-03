<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email_campaign extends CI_Controller
{
	// GET /email-campaign
    public function index()
    {	
		$this->load->view('layout/header');
        $this->load->view('email_campaign/list');
        $this->load->view('layout/footer');
        
    }

	// GET /email-campaign/create
    public function create()
    {	
		$this->load->view('layout/header');
        return $this->load->view('email_campaign/create');
        $this->load->view('layout/footer');
    }

}
