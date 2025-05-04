<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	
	<h1>Create email campaign</h1>
	<div class="form">
		<form id="createForm">
			<input type="text" id="subject" name="subject" placeholder="Subject" required>

			<input type="email" id="recipient_email" name="recipient_email" placeholder="Recipient Email" required>

			<textarea name="body" placeholder="Body" rows="4" required></textarea><br>
		
			<button type="submit" class="submitbtn">Create Campaign</button>
		</form>
	</div>
	</div>
	<script>
		document.getElementById('createForm').onsubmit = async function(e) {
	
			e.preventDefault();
			const form = new FormData(this);
			const plainFormData = Object.fromEntries(form.entries());
			const formDataJsonString = JSON.stringify(plainFormData);
			const res = await fetch(`/api/email-campaign`, { method: 'POST',
			headers: {
			'Content-Type': 'application/json',
			'Authorization': 'AIOBIC_ASSESSMENT_TOKEN'
			},	
			body: formDataJsonString });
			const result = await res.json();
			alert(result.status == true ? 'Created!' : 'Failed');
			window.location.href = "/";
			};
	</script>
</body>
</html>
