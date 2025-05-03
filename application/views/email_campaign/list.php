<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<div class="container-header">
		<h1>Email Campaigns</h1>
		<div class="button"><a href="/email-campaign/create">Create new campaign</a></div>
	</div>
	<div class="filter">
	<input type="text" id="filterEmail" placeholder="Filter by email">
	<button onclick="filterCampaigns()">Search</button>
	</div>
	<table>
		<thead>
			<tr>
				<th>Subject</th>
				<th>Recipient email</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="campaignTable">

		</tbody>
	</table>
</div>

<script>
	async function loadCampaigns() {
	const res = await fetch(`/api/email-campaign/list`,{
	  method: 'GET',
	  headers: {
		  'Content-Type': 'application/json',
		  'Authorization': 'AIOBIC_ASSESSMENT_TOKEN'
	  }
  });
	const result = await res.json();
   
	const table = document.getElementById('campaignTable');
	if (result.status && result.data.length > 0) {
	table.innerHTML = result.data.map(c => `
	  <tr>
		<td>${c.subject}</td>
		<td>${c.recipient_email}</td>
		<td>${c.status}</td>
		<td>
		  ${c.status === 'draft' ? `<button class="email-btn" onclick="sendCampaign(${c.id})">Send Email</button>` : ''}
		</td>
	  </tr>
	`).join('');
	} else {
		table.innerHTML = '<td colspan="5">No campaigns found.</td>';
		}
  }
  
  async function sendCampaign(id) {
	const res = await fetch(`/api/email-campaign/${id}/send`, {
	   method: 'POST',
	   headers: {
		  'Content-Type': 'application/json',
		  'Authorization': 'AIOBIC_ASSESSMENT_TOKEN'
	  } });
	const result = await res.json();
	alert(result.status == true ? 'Email Sent!' : 'Failed');
	if (result.status == true) loadCampaigns();
  }
  
  loadCampaigns();

  function filterCampaigns() {
    const email = document.getElementById('filterEmail').value.trim();
	fetch(`/api/email-campaigns/filter?email=${encodeURIComponent(email)}`,{
	  method: 'GET',
	  headers: {
		  'Content-Type': 'application/json',
		  'Authorization': 'AIOBIC_ASSESSMENT_TOKEN'
	  }
  }).then(res => res.json())
        .then(data => {
            const table = document.getElementById('campaignTable');
            table.innerHTML = '';

            if (data.status && data.data.length > 0) {
                table.innerHTML = data.data.map(c => `
				<tr>
					<td>${c.subject}</td>
					<td>${c.recipient_email}</td>
					<td>${c.status}</td>
					<td>
					${c.status === 'draft' ? `<button class="email-btn" onclick="sendCampaign(${c.id})">Send Email</button>` : ''}
					</td>
				</tr>
				`).join('');
            } else {
                table.innerHTML = '<td colspan="5">No campaigns found.</td>';
            }
        });
	
       
}
</script>

</body>
</html>