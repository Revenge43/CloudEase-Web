
-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Drop the child table `comments` first (depends on `assignments`)
DROP TABLE IF EXISTS comments;

-- Drop the next child table `assignments` (depends on `courses`)
DROP TABLE IF EXISTS assignments;

-- Drop the parent table `courses`
DROP TABLE IF EXISTS courses;

DROP TABLE IF EXISTS module_topics;

-- Enable foreign key checks again
SET FOREIGN_KEY_CHECKS = 1;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS modules;

CREATE TABLE users (
  user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  role enum('admin','student') NOT NULL DEFAULT 'student',
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE courses (
  course_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, -- Primary key
  title TEXT NOT NULL,
  description TEXT,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  teacher_id TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL
);

CREATE TABLE assignments (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, -- Primary key
  course_id INT NOT NULL, -- Foreign key column
  assignment_title TEXT NOT NULL,
  assignment_description TEXT,
  assignment_file TEXT,
  assignment_score VARCHAR(255),
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  assignment_status VARCHAR(255) DEFAULT NULL,
  CONSTRAINT fk_course FOREIGN KEY (course_id) REFERENCES courses (course_id) ON DELETE CASCADE
);

CREATE TABLE comments (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  text TEXT NOT NULL,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  assignment_id INT NOT NULL,
  timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  file VARCHAR(255) DEFAULT NULL,
  CONSTRAINT fk_assignment FOREIGN KEY (assignment_id) REFERENCES assignments (id) ON DELETE CASCADE
);

CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_title VARCHAR(255) NOT NULL,
    module_description TEXT NOT NULL,
    course_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE module_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    module_id INT NOT NULL,
    attachment VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

