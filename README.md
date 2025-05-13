# Meetings Laravel App

## Overview
The **Meetings Laravel App** is a web-based platform for scheduling, managing, and documenting meetings efficiently. It includes features such as meeting reminders, minute-taking, email notifications, and role-based access control.

## Features
- **Meeting Management**: Schedule and view meetings.
- **Reminders**: Automatic email reminders for upcoming meetings.
- **Minute Keeping**: Record and store meeting minutes.
- **Email Distribution**: Send meeting minutes via email to attendees.
- **Chairman Approval**: The chairman must approve meeting minutes before distribution.
- **Access Control**: Only attendees can view meeting details and minutes.
- **Meeting Links**: Shareable links to specific meetings.

## User Roles & Privileges
- **Admin**: Manages users, meetings, and settings.
- **Chairman**: Approves meeting minutes and oversees meetings.
- **Minutes Taker**: Records and uploads meeting minutes.
- **Attendee**: Views assigned meetings and minutes.

## Installation
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-repo/meetings-laravel.git
   cd meetings-laravel
   ```
2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```
3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Configure database** in `.env` file
   ```
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
5. **Run migrations**
   ```bash
   php artisan migrate --seed
   ```
6. **Start the application**
   ```bash
   php artisan serve
   ```

## Usage
- Log in as an **admin** to create users and manage roles.
- **Schedule meetings** with attendees.
- **Record minutes** as a Minutes Taker and submit for approval.
- **Chairman approves** or rejects minutes.
- **Attendees receive** meeting notifications and access approved minutes.

## Contributing
Feel free to submit issues and pull requests. Follow standard Laravel and GitHub contribution guidelines.

## License
This project is licensed under the MIT License.

## Contact
For support or inquiries, reach out via GitHub issues or email: `edwinkiuma@gmail.com`
To view the App: `https://meeting.betterglobeforestry.com`

