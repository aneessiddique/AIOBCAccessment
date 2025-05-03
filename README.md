# Email Automation Workflow System (CodeIgniter 3)
A simple email campaign automation system built with CodeIgniter 3 and RESTful APIs. It allows users to create, view, and send email campaigns. Includes optional React or plain HTML/JS frontend support.

---

## Features

- RESTful API for managing email campaigns
- Email sending via `mail()`
- Frontend form to create and send campaigns
- Filter campaigns by recipient email
- Clean MVC structure

## Setup Instructions

1. Clone the repo:
   git clone https://github.com/aneessiddique/AIOBCAccessment.git

2. Import the SQL:
   Run the provided SQL to create the `email_campaigns` table.
   CREATE TABLE email_campaigns (
		id INT AUTO_INCREMENT PRIMARY KEY,
		subject VARCHAR(255) NOT NULL,
		body TEXT NOT NULL,
		recipient_email VARCHAR(255) NOT NULL,
		status ENUM('draft', 'sent') DEFAULT 'draft',
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		);


3. Configure base URL and database in:
   - `application/config/config.php`
   - `application/config/database.php`

4. Start the app (Apache or built-in PHP server).

## Usage

- Visit `/email_campaigns/create` to create a new campaign.
- Visit `/email_campaigns/list` to view and send draft campaigns.

## API Endpoints

POST	/api/email-campaign/store				Create new campaign
GET		/api/email-campaigns/list				List all campaigns
POST	/api/email-campaign/{id}/send			Send campaign & mark sent
GET		/api/email-campaigns/filter?email=...	Filter campaigns by email

## Application Structue
application/
│
├── controllers/
│ └── Email_campaign.php
  ├── Api.php
├── models/
│ └── Email_campaign_model.php
├── views/
│ ├── layout/
│ │ ├── header.php
│ │ ├── footer.php
│ ├── email_campaign/
│ │ └── create.php
│ │ └── list.php
│
├── helpers/
│ └── api_helper.php
assets/
│ └── css/
│ └── app.css

## Watch Video
https://youtu.be/McBxCOLCT9I
