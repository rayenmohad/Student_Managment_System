# Student Management System

A powerful PHP-based Student Management System designed to simplify the management of student records, classes, and attendance. This project demonstrates advanced PHP techniques, seamless database integration, and clean UI development using Bootstrap.

## Table of Contents

1. Features
2. Technologies Used
3. Installation
4. Usage
5. Screenshots
6. Contributing
7. License

## Features

* Add, edit, and delete student records.
* Manage class schedules and student enrollments.
* Attendance tracking system for students.
* User-friendly interface with Bootstrap integration.
* Built-in error handling for smooth operations.

## **Technologies Used**
- **PHP 8.x** <i class="fab fa-php"></i>: Core back-end logic.
- **MySQL** <i class="fas fa-database"></i>: Database for managing student data.
- **Bootstrap 5** <i class="fab fa-bootstrap"></i>: Responsive and modern UI.
- **JavaScript** <i class="fab fa-js-square"></i>: Enhances interactivity and form validation.
- **XAMPP** <i class="fab fa-xampp"></i>: Local server environment for testing.
- **Git** <i class="fab fa-git-alt"></i>: Version control system.

## Installation

1. **Clone the repository:**
  ``` bash
   git clone [https://github.com/your-username/your-repository.git](https://github.com/your-username/your-repository.git)
   cd your-repository
```

2.  **Set up the database:**

      - Import the `project_etudiant.sql` file into your MySQL database.

3.  **Update the database configuration:**

      - Open the `config.php` file and set your database credentials:
        ```php
        define('DB_HOST', 'your_host');
        define('DB_NAME', 'your_database_name');
        define('DB_USER', 'your_username');
        define('DB_PASS', 'your_password');
        ```

4.  **Start your local server:**

      - Use XAMPP or any other PHP server to host the project locally.

5.  **Access the project:**

      - Open your browser and navigate to:
        ```
        http://localhost/your-project-folder/
        ```

## Usage

1.  Navigate to the home page to view the student dashboard.
2.  Use the **Add Student** form to register a new student.
3.  Manage classes and attendance using the respective pages.
4.  Edit or delete student records from the list.
5.  Secure login ensures only authorized users can access the system.

## Screenshots

### Student Management

  - **Student Dashboard**
    ![Student Dashboard](studentscreen3.png)
  - **Add New Student**
    ![Add Student Screen](studentscreen2.png)
  - **Student Details**
    ![Student Details](studentscreen1.png)

### Professor Management

  - **Professor Overview**
    ![Professor Management](professor.png)

###  Material Management

  - **Add New Material**
    ![Add Material](meterial3.png)
  - **Material Details**
    ![Material Details](material1.png)

## Contributing

Contributions are welcome\! Follow these steps to contribute:

1.  Fork the repository.
2.  Create a new branch:
    ```bash
    git checkout -b feature/your-feature
    ```
3.  Commit your changes:
    ```bash
    git commit -m "Add your feature"
    ```
4.  Push to your branch:
    ```bash
    git push origin feature/your-feature
    ```
5.  Open a Pull Request.

## License

This project is licensed under the MIT License.


