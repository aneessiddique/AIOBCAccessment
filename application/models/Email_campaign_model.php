<?php
class Email_campaign_model extends CI_Model
{
    protected $table = 'email_campaigns';

    public function create_campaign($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_all_campaigns($email = null)
    {	
		if (!empty($email)) {
			$this->db->like('recipient_email', $email);
		}
		$this->db->order_by('position','ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_campaign_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function mark_as_sent($id)
    {
        return $this->db->update($this->table, ['status' => 'sent'], ['id' => $id]);
    }

	public function get_campaigns_by_email($email = null)
	{
		if (!empty($email)) {
			$this->db->like('recipient_email', $email);
		}

		$query = $this->db->get('email_campaigns');
		return $query->result();
	}

	public function reorder($ids)
	{
		foreach ($ids as $position => $id) {
			$this->db->where('id', $id);
			$this->db->update('email_campaigns', ['position' => $position]);
		}
	}

}
