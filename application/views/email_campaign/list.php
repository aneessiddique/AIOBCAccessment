<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<div class="container-header">
		<h1>Email Campaigns</h1>
		<div class="button"><a href="/email-campaign/create">Create new campaign</a></div>
	</div>
	<div class="filter">
	<input type="text" id="filterEmail" placeholder="Filter by email">
	<button onclick="loadCampaigns()">Search</button>
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
<script src="/assets/js/list.js"></script>
</body>
</html>
