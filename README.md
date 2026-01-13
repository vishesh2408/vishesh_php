# Online Examination System

A robust Online Examination System built with PHP, following a modern MVC architecture.

## ✨ Key Features

### 👨‍🎓 User Module
The Student/User panel is designed for a seamless examination experience.

*   **Secure Authentication**:
    *   **Registration**: New users can create an account with their name, username, email, and password.
    *   **Login**: Secure access to the dashboard.
    *   **Profile Management**: Users can view and update their personal details.

*   **Examination System**:
    *   **Start Test**: A dedicated instruction page before beginning the exam.
    *   **Interactive Test Interface**: Question-by-question format with radio button selection for answers.
    *   **Real-time Processing**: Answers are processed instantly and securely.
    *   **Instant Results**: Immediate score display upon completion of the exam.
    *   **Answer Review**: Comprehensive breakdown of the test showing correct answers compared to user selection.

### 👨‍💼 Admin Module
The Admin panel provides full control over the examination system and user base.

*   **Access Control**:
    *   **Admin Login**: Separate, secure login portal for administrators.

*   **User Management**:
    *   **User List**: View a complete list of all registered students.
    *   **Account Control**: Ability to enable or disable specific user accounts to restrict access.
    *   **Delete Users**: Remove user accounts from the system efficiently.

*   **Question Bank Management**:
    *   **Add Questions**: Intuitive form to add new multiple-choice questions with 4 options and the correct answer index.
    *   **Manage Questions**: View all questions currently in the test database.
    *   **Remove Questions**: Delete outdated or incorrect questions from the exam.

### 🎨 UI & Technical Highlights

*   **Modern User Interface**:
    *   **Glassmorphism Design**: cutting-edge visual aesthetic with semi-transparent elements and vibrant blurs.
    *   **Responsive Layout**: Fully optimized for Desktops, Tablets, and Mobile devices.
    *   **Dynamic Interactions**: Smooth fade-in animations and AJAX-powered form submissions for a seamless user experience.

*   **Robust Architecture**:
    *   **MVC Pattern**: Clean separation of logic (Controllers), data (Models), and presentation (Views).
    *   **Composer Autoloading**: Utilizes PSR-4 standards for efficient class loading.
    *   **Secure Routing**: Centralized Front Controller pattern handling all requests through a single entry point.
    *   **Portability**: Environment-based configuration (`.env`) allows the application to run easily on any server setup.

### 🌟 Uniqueness
Why choose this system over others?

*   **Architectural Excellence**: Unlike typical spaghetti-code PHP projects, this system employs a **professional, storage-agnostic MVC pattern**. It bridges the gap between raw PHP and complex frameworks like Laravel, making it the perfect middle-ground for maintainable code.
*   **Visual Sophistication**: It abandons generic templates for a **custom-designed, vibrant Glassmorphism interface**. The design uses semi-transparent layers and blur effects to create a premium, deep visual experience that stands out.
*   **Zero-Dependency Core**: The core logic runs on pure PHP without heavy framework bloat, ensuring **blazing fast performance** even on minimal hosting environments.
*   **Security-First Approach**: Input sanitization, prepared statements (via custom wrappers), and secure session management are baked into the core, not added as afterthoughts.

## 🎯 Implementation & Use Cases
This system is versatile enough for various professional and educational settings.

*   **🏫 Educational Institutions**:
    *   **Schools & Colleges**: Conduct secure, internal continuous assessments (CA) and quizzes without paper waste.
    *   **Coaching Centers**: Offer practice tests for competitive exams (JEE, NEET, SAT) to students.

*   **🏢 Corporate & Recruitment**:
    *   **Employee Training**: Verify knowledge retention after corporate training workshops.
    *   **Pre-Screening**: Use as a first-round technical screening tool for job applicants to test domain knowledge.

*   **💻 Developer Education**:
    *   **Learning Resource**: A gold-standard reference for students mastering **PHP MVC Architecture**, **Composer Autoloading**, and **Refactoring** legacy codebases.

## 🚀 Advanced Features (New)

### 👨‍🏫 Teacher Module
A dedicated role for educators to manage exams, students, and evaluation.

*   **Exam Management**:
    *   **Create Exams**: Custom exams with specific names, time limits, and descriptions.
    *   **Publish Results**: Manually release results for exams when ready.
    *   **Question Bank**: Reuse questions across multiple exams.
    *   **CSV Download**: Export comprehensive exam results to CSV for external analysis.

*   **Student Monitoring & Groups**:
    *   **Group Management**: Create student groups (batches) and assign specific exams to them.
    *   **Bulk Import**: Add students to groups via CSV upload.
    *   **Live Monitoring**: Track active students and ongoing exam sessions.

*   **Communication**:
    *   **Announcements**: Post updates or instructions that are emailed directly to students (All or Group-wise).

*   **Detailed Analytics & Evaluation**:
    *   **Detailed Report Cards**: View individual student attempts with a printable "Report Card" view.
    *   **Question Level Analysis**: See exactly which options a student selected, with correct/incorrect indicators.
    *   **Performance Analytics**: Visual charts and stats (Average Score, Pass Rate, Top Performers) filtered by specific exams.

### 🖨️ Reporting functionality
*   **Printable Reports**: One-click printing of student result cards with branding.
*   **Answer Key Generation**: Automatically generates a review sheet of the exam with correct answers highlighted.

## 📂 Project Structure
- `public/` - Web entry point and assets.
- `src/` - Application logic (Controllers, Models, Lib).
- `views/` - HTML Templates.
- `config/` - Configuration.
- `database/` - Database schema.

## 🛠 Setup & Installation

1.  **Prerequisites**:
    - PHP 8.0+
    - MySQL
    - Composer

2.  **Install Dependencies**:
    ```bash
    composer install
    ```

3.  **Database Configuration**:
    - Create a MySQL database named `mcqexamination` (or update `.env`).
    - Import the schema from `database/mcqexamination.sql`.
    - Configure your `.env` file with database credentials.

4.  **Run the Application**:
    ```bash
    php -S localhost:8000 -t public public/index.php
    ```

5.  **Access**:
    - User Interface: [http://localhost:8000](http://localhost:8000)
    - Admin Panel: [http://localhost:8000/admin](http://localhost:8000/admin)
