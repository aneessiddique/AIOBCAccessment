async function loadCampaigns() {
	const email = document.getElementById('filterEmail').value.trim();
	const res = await fetch(`/api/email-campaign/list?email=${encodeURIComponent(email)}`,{
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
	  <tr draggable="true" data-id="${c.id}">
		<td>${c.subject}</td>
		<td>${c.recipient_email}</td>
		<td>${c.status}</td>
		<td>
		  ${c.status === 'draft' ? `<button class="email-btn" onclick="sendCampaign(${c.id})">Send Email</button>` : ''}
		</td>
	  </tr>
	`).join('');
	enableDragAndDrop();
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

function enableDragAndDrop() {
    let dragSrcEl = null;

    const table = document.getElementById('campaignTable');

    table.addEventListener('dragstart', function (e) {
        if (e.target && e.target.nodeName === "TR") {
            dragSrcEl = e.target;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', '');
            dragSrcEl.classList.add('dragging');
        }
    });

    table.addEventListener('dragover', function (e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(table, e.clientY);
        const dragging = document.querySelector('.dragging');
        if (afterElement == null) {
            table.appendChild(dragging);
        } else {
            table.insertBefore(dragging, afterElement);
        }
    });

    table.addEventListener('drop', function (e) {
        e.preventDefault();
        const dragging = document.querySelector('.dragging');
        dragging.classList.remove('dragging');

        const ids = Array.from(table.querySelectorAll('tr')).map(tr => tr.getAttribute('data-id'));

        fetch('/api/email-campaign/reorder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'AIOBIC_ASSESSMENT_TOKEN'
            },
            body: JSON.stringify({ order: ids })
        }).then(res => res.json())
          .then(data => console.log(data));
    });

    table.addEventListener('dragend', function (e) {
        if (e.target && e.target.nodeName === "TR") {
            e.target.classList.remove('dragging');
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('tr:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
}
