#  NLP Chatbot for Training Company (Dialogflow + PHP)

This project is a smart chatbot designed for a training company using **Dialogflow** for Natural Language Processing and **PHP** as the backend. The chatbot helps users with course inquiries, registration, schedules, and more.

## Features

- Course information (Python, Web Dev, Mobile Dev)
- User registration and login
- Role-based access (Admin, Student, Teacher)
- Personalized course recommendations
- Quiz and schedule handling
- Admin panel to manage content

---

## How to Run the Project


### Requirements

- PHP 7.x or higher
- MySQL Database
- XAMPP/Laragon/WAMP (Recommended for local server)
- Internet connection (for Dialogflow webhook)
- Ngrok (for exposing localhost to Dialogflow)

---

### Folder Structure

/dialogflow-chatbot/
├── backend/ # PHP backend files
│ ├── index.php
│ ├── webhook.php # Handles Dialogflow requests
│ ├── db.php # DB connection
│ └── ...
├── assets/ # CSS, JS, images
├── sql/ # Database schema file (.sql)
├── README.md # This file
└── .env # Environment config (optional)

yaml
Copy
Edit

---

###  Setup Instructions

1. **Clone or Download the Project**


Start Local Server

Use XAMPP or Laragon

Put project inside /htdocs/ 

Import Database

Open phpMyAdmin

Create a new DB named dialogflow_chatbot_db

Import dialogflow_chatbot_db.sql from the sql/ folder

Set up Ngrok (for Dialogflow)

bash
Copy
Edit
ngrok http 80
Copy the HTTPS URL shown by ngrok

Configure Webhook in Dialogflow

Go to Dialogflow Console

Enable Webhook in Fulfillment tab

Paste your https://your-ngrok-url/webhook.php

Train & Test Intents

Use Dialogflow's test panel or your integrated chatbot UI

 Users & Roles:-
Admin: Can manage courses, students, teachers

Student: Can ask questions, see quiz schedule, register

Teacher: Can manage quizzes and students under them


 Note:-
Dialogflow webhook must be live using ngrok

Internet is needed to test chatbot with Dialogflow

Check db.php for DB credentials before running

 Developer:-
Imtanan Ahnaf
BS Software Engineering
Virtual University of Pakistan
Email: BC200401263@vu.edu.pk