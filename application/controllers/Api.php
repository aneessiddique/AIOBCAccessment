<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('email_campaign_model');
        $this->load->helper('api');
		authorize_request();
    }

	// GET /email-campaign
    public function list()
    {	
		$campaigns = $this->email_campaign_model->get_all_campaigns();
		api_response($campaigns);
    }
	
    // POST /email-campaign
    public function store()
    {	
		$this->load->helper('security');
		$data = json_decode(file_get_contents('php://input'), true);
		$data = $this->security->xss_clean($data);
        $id = $this->email_campaign_model->create_campaign($data);
		api_response([ 'id' => $id]);
    }

    // POST /email-campaign/{id}/send
    public function send($id)
    {
        $campaign = $this->email_campaign_model->get_campaign_by_id($id);
        if (!$campaign || $campaign->status == 'sent') {
			api_error('Invalid or already sent',404);
            return;
        }

        $message = wordwrap($campaign->body, 70);
        mail($campaign->recipient_email, $campaign->subject, $message);

        $this->email_campaign_model->mark_as_sent($id);
        api_response([ 'id' => $id]);
    }

	public function filter()
	{
		$email = $this->input->get('email', TRUE);

		$campaigns = $this->email_campaign_model->get_campaigns_by_email($email);
		api_response($campaigns);
	}
}
