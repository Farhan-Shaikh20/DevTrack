# DevTrack — Client Project Management System

A professional PHP-based Client Project Management System designed to simplify and streamline client, project, and task management. DevTrack demonstrates full-stack PHP development with authentication, role-based access control, and responsive web design.

---

## 📋 Overview

DevTrack is a **database-driven web application** built with PHP, MySQL, and vanilla JavaScript. The system enables administrators to manage clients and projects, while allowing clients to securely log in and view their assigned projects and tasks.

**Key Capabilities:**
- **Admin Portal:** Manage clients, projects, and monitor project progress
- **Client Portal:** View assigned projects, track status, and access project details
- **Role-Based Access:** Separate authentication for admins and clients
- **Real-Time Dashboard:** Live statistics and project status overview
- **Responsive UI:** Modern, clean interface optimized for desktop and mobile

---

## 🚀 Key Features

✅ **Client Management**
- Add, edit, and delete client records
- Store company information and contact details
- Client-to-project association

✅ **Project Management**
- Create and organize projects by client
- Define project timelines (start/end dates)
- Track project status (Planning, In Progress, Testing, Completed)
- Manage project descriptions and deliverables

✅ **Task Management**
- Organize tasks within projects
- Link tasks to project workflows

✅ **Authentication & Security**
- Secure user login with password hashing (bcrypt)
- Session-based authentication
- Role-based access control (Admin/Client)
- Prepared statements for SQL injection prevention

✅ **Admin Dashboard**
- Real-time project statistics
- Visual project status breakdown
- Quick access to client and project management

✅ **Client Dashboard**
- Personalized project overview
- Profile management
- Project tracking and details

✅ **Database-Driven**
- MySQL with foreign key relationships
- Normalized table structure (users, clients, projects)
- Cascading delete for referential integrity

✅ **CRUD Operations**
- Full Create, Read, Update, Delete functionality
- Form validation and error handling

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Backend** | PHP 8.2+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla) |
| **Development Server** | XAMPP (Apache + MySQL) |
| **Version Control** | Git & GitHub |
| **UI Framework** | Custom CSS (No external frameworks) |
| **Icons** | Font Awesome 6.4.0 |

---

## 📂 Project Structure

```
DevTrack/
├── admin/
│   ├── dashboard.php           # Admin dashboard with statistics
│   ├── clients/
│   │   ├── index.php          # List all clients
│   │   ├── add.php            # Add new client form
│   │   ├── edit.php           # Edit client details
│   │   └── delete.php         # Delete client record
│   └── projects/
│       ├── index.php          # List all projects
│       ├── add.php            # Add new project form
│       ├── edit.php           # Edit project details
│       └── delete.php         # Delete project record
│
├── client/
│   ├── dashboard.php          # Client dashboard with profile & project count
│   ├── projects.php           # List client's assigned projects
│   └── project-details.php    # View individual project details
│
├── config/
│   └── database.php           # Database connection configuration
│
├── includes/
│   ├── auth.php               # Admin authentication middleware
│   └── client_auth.php        # Client authentication middleware
│
├── database/
│   ├── devtrack.sql           # Complete database schema and sample data
│   ├── create_admin.php       # Setup script: Create admin account
│   ├── create_client.php      # Setup script: Create sample client account
│   └── pas_reset.php          # Utility: Reset password (development only)
│
├── assets/
│   └── css/
│       └── style.css          # Complete application stylesheet
│
├── index.php                  # Login page (entry point)
├── login.php                  # Login processing
├── logout.php                 # Logout and session termination
└── README.md                  # Documentation
```

---

## ⚙️ Installation & Setup

### Prerequisites
- **XAMPP** (Apache + MySQL) or equivalent PHP/MySQL environment
- **PHP 7.4+** (PHP 8.0+ recommended)
- **MySQL 5.7+** or **MariaDB 10.4+**
- **Git** for version control

### Step 1: Clone the Repository
```bash
git clone https://github.com/Farhan-Shaikh20/DevTrack.git
cd DevTrack
```

### Step 2: Move to XAMPP
```bash
# On Windows:
cp -r DevTrack C:\xampp\htdocs\

# On macOS/Linux:
cp -r DevTrack /Applications/XAMPP/xamppfiles/htdocs/
```

### Step 3: Start XAMPP Services
- Open **XAMPP Control Panel**
- Click **Start** next to Apache
- Click **Start** next to MySQL

### Step 4: Create Database
1. Open **phpMyAdmin**: `http://localhost/phpmyadmin/`
2. Create a new database named `devtrack`
3. Select the `devtrack` database
4. Go to **Import** tab
5. Select and import the file: `database/devtrack.sql`

### Step 5: Verify Configuration
The database configuration is set in `config/database.php`:
```php
$host = "localhost";
$username = "root";          // Default XAMPP username
$password = "";              // Default XAMPP (empty password)
$database = "devtrack";
```

If your setup uses different credentials, update this file accordingly.

### Step 6: Access the Application
Open your browser and navigate to:
```
http://localhost/DevTrack/
```

---

## 🔐 Default Credentials (For Testing Only)

> ⚠️ **Important:** These are default credentials for the pre-populated database. Change them immediately in a production environment.

**Admin Account:**
- Email: `admin@devtrack.com`
- Password: `devtrack065`

**Sample Client Account:**
- Email: `client1@gmail.com`
- Password: `client1065`

**Additional Test Accounts:** See `database/devtrack.sql` for other pre-populated accounts.

---

## 🎯 How to Use

### For Administrators
1. **Login** with admin credentials
2. **Admin Dashboard:** View system overview and project statistics
3. **Manage Clients:** Add, edit, or delete client accounts
4. **Manage Projects:** Create projects, assign clients, track status

### For Clients
1. **Login** with client credentials
2. **Client Dashboard:** View profile and total assigned projects
3. **View Projects:** See all assigned projects with statuses
4. **Project Details:** Click on any project to see full details and tasks

---

## 🔒 Security Features

✅ **Password Security**
- Passwords hashed using PHP's `password_hash()` (bcrypt)
- Verified using `password_verify()` during login

✅ **SQL Injection Prevention**
- Prepared statements used throughout
- User input binding with parameter types

✅ **XSS Prevention**
- Output escaped using `htmlspecialchars()`
- User-supplied content sanitized before display

✅ **Session Management**
- Secure session-based authentication
- Role-based middleware (`auth.php`, `client_auth.php`)
- Automatic redirect for unauthorized access

✅ **Database Integrity**
- Foreign key constraints enforce data relationships
- Cascading deletes prevent orphaned records

---

## 🎓 Technical Concepts Demonstrated

This project showcases understanding of:

- **Backend Development:** Server-side PHP logic and flow control
- **Database Design:** Normalized schema, relationships, constraints
- **Authentication:** Secure login, session management, password hashing
- **Access Control:** Role-based permissions and authorization
- **SQL Queries:** SELECT, INSERT, UPDATE, DELETE with JOINs
- **Prepared Statements:** Protection against SQL injection
- **Web Security:** XSS prevention, input validation
- **RESTful Patterns:** URL-based navigation and CRUD operations
- **Form Handling:** POST requests, validation, error handling
- **Responsive Design:** CSS Grid/Flexbox for modern layouts
- **User Experience:** Intuitive navigation, visual feedback, accessibility
- **Version Control:** Git workflow and GitHub collaboration

---

## 🚀 Usage Examples

### Login Flow
```
User visits: http://localhost/DevTrack/
↓
Enters credentials in login form (index.php)
↓
Form posts to: login.php
↓
Password verified against hashed password in database
↓
Session created with user_id, name, and role
↓
Redirected to appropriate dashboard (admin or client)
```

### Admin Adds a Project
```
1. Navigate to: Admin Dashboard → Manage Projects
2. Click "Add New Project"
3. Select client, enter project name, dates, description
4. Set initial status (Planning, In Progress, etc.)
5. Form submits to: admin/projects/add.php
6. Data inserted into projects table
7. Redirect to projects list with confirmation
```

### Client Views Project Details
```
1. Login as client
2. Navigate to: Client Dashboard → View My Projects
3. Click on a project
4. Project details displayed from: client/project-details.php
5. See client's own project data only (secure query with user_id)
```

---

## 📊 Database Schema

### `users` Table
- Stores login credentials for both admins and clients
- Password hashing with bcrypt

### `client` Table
- Client company information
- Links to users table (one user = one client account)
- Company name, phone, timestamps

### `projects` Table
- Project information and timeline
- Links to client table (one client can have many projects)
- Status tracking: planning, in progress, testing, completed

---

## 🔧 Development & Maintenance

### Database Utilities (in `/database/`)

**`create_admin.php`** - Setup script to create an admin account
```bash
Visit: http://localhost/DevTrack/database/create_admin.php
```

**`create_client.php`** - Setup script to create a sample client
```bash
Visit: http://localhost/DevTrack/database/create_client.php
```

**`pas_reset.php`** - Utility to reset passwords (development only)
- Modify the `$email` variable before running
- Visit the file in browser to execute

---

## 📝 Future Improvements

🔄 **Planned Enhancements:**
- Task management system with subtasks
- Email notifications for project status updates
- Advanced project analytics and reporting
- File/document upload and management
- Project timeline visualization (Gantt charts)
- User profile management and settings
- Password reset via email
- REST API endpoints for external integration
- Admin activity logging and audit trail
- Multi-language support
- Production deployment guide

---

## 🤝 Contributing

This is a portfolio project. However, suggestions and feedback are welcome!

If you'd like to contribute:
1. Fork the repository
2. Create a feature branch
3. Make improvements
4. Submit a pull request

---

## 📄 License

This project is open source and available for educational purposes.

---

## 👨‍💻 Developer

**Farhan Shaikh**

- Full-Stack Web Development Enthusiast
- Focused on PHP, MySQL, and Modern Web Design
- Computer Science Engineering Student
- Available for collaboration and opportunities

**Connect:**
- GitHub: [@Farhan-Shaikh20](https://github.com/Farhan-Shaikh20)
- Email: farhan@gmail.com

---

## 🙏 Acknowledgments

- **Font Awesome** for beautiful icons
- **XAMPP** community for excellent local development environment
- PHP documentation and best practices community
- Inspired by real-world project management systems

---

**Made with ❤️ as a portfolio demonstration of full-stack PHP development**
