--========== Roles&Permisions ==========
CREATE TABLE roles (
		role_id INT NOT NULL AUTO_INCREMENT,
		role ENUM(
				'admin',
				'student',
				'teacher'
		),
		PRIMARY KEY (role_id)
);

CREATE TABLE permissions (
		permission_id INT NOT NULL AUTO_INCREMENT,
		permission ENUM(
				'view_self_attendance',
				'view_self_class_attendance',
				'view_class_attendance',
				'add_student_attendance',
				'add_self_attendance',
				'manage_users',
				'manage_classes',
				'view_all_attendance',
				'edit_attendance',
				'delete_logs'
		),
		primary key(permission_id)
);

CREATE TABLE role_permissions (
		role_id INT NOT NULL,
		permission_id INT NOT NULL,
		PRIMARY KEY(role_id, permission_id),
		FOREIGN KEY (role_id) REFERENCES roles(role_id),
		FOREIGN KEY (permission_id) REFERENCES permissions(permission_id)
);

--========== Reports ==========
CREATE TABLE reports (
		report_id INT NOT NULL AUTO_INCREMENT,
		report_url VARCHAR(100) NOT NULL DEFAULT 'missing url',
		PRIMARY KEY(report_id)
);

--========== Users ==========
CREATE TABLE users (
		user_id INT NOT NULL AUTO_INCREMENT,
		username VARCHAR(50) NOT NULL UNIQUE,
		email VARCHAR(50) NOT NULL UNIQUE,
		password VARCHAR(255) NOT NULL,
		user_role_id INT NOT NULL,
		PRIMARY KEY(user_id),
		FOREIGN KEY(user_role_id) REFERENCES roles(role_id)
);

--========== Classrooms ==========
CREATE TABLE grades (
		grade_id INT NOT NULL AUTO_INCREMENT,
		grade_name ENUM(
				'1',
				'2',
				'3',
				'4',
				'5',
				'6'
		) NOT NULL DEFAULT '1',
	   PRIMARY KEY(grade_id)	
);

CREATE TABLE sections (
		section_id INT NOT NULL AUTO_INCREMENT,
		section_name ENUM('A', 'B', 'C'),
		PRIMARY KEY(section_id)
);

CREATE TABLE classrooms (
		classroom_id INT NOT NULL AUTO_INCREMENT,
		classroom_grade_id INT NOT NULL,
		classroom_section_id INT NOT NULL,
		PRIMARY KEY (classroom_id),
		FOREIGN KEY (classroom_grade_id) REFERENCES grades(grade_id),
		FOREIGN KEY (classroom_section_id) REFERENCES sections(section_id)
);

--========== Classes ==========
CREATE TABLE classes (
		class_id INT NOT NULL AUTO_INCREMENT,
		class_name VARCHAR(30) NOT NULL,
		class_classroom_id INT NOT NULL,
		PRIMARY KEY (class_id),
		FOREIGN KEY (class_classroom_id) REFERENCES classrooms(classroom_id)
);

--========== Attendances ==========
CREATE TABLE students_attendances (
		attendance_id INT NOT NULL AUTO_INCREMENT,
		attendance_type ENUM('bad', 'delay', 'in-time') DEFAULT 'in-time' NOT NULL,
		student_id INT NOT NULL,
		student_class_id INT NOT NULL,
		attendance_date TIMESTAMP NOT NULL,
		PRIMARY KEY (attendance_id),
		FOREIGN KEY (student_id) REFERENCES users(user_id),
		FOREIGN KEY (student_class_id) REFERENCES classes(class_id)
);

CREATE TABLE teachers_attendances (
		attendance_id INT NOT NULL AUTO_INCREMENT,
		attendance_type ENUM('bad', 'delay', 'in-time') DEFAULT 'in-time' NOT NULL,
		teacher_id INT NOT NULL,
		teacher_class_id INT NOT NULL,
		attendance_date TIMESTAMP NOT NULL,
		PRIMARY KEY (attendance_id),
		FOREIGN KEY (teacher_id) REFERENCES users(user_id),
		FOREIGN KEY (teacher_class_id) REFERENCES classes(class_id)
);


--========== Schollar Cycle ==========
CREATE TABLE schollar_cycle (
		cycle_id INT NOT NULL AUTO_INCREMENT,
		begin_date DATE NOT NULL,
		end_date DATE NOT NULL,
		PRIMARY KEY (cycle_id)
);

CREATE TABLE schollar_cycle_classes (
		class_id INT NOT NULL,
		cycle_id INT NOT NULL,
		PRIMARY KEY (class_id, cycle_id),
		FOREIGN KEY (class_id) REFERENCES classes(class_id),
		FOREIGN KEY (cycle_id) REFERENCES schollar_cycle(cycle_id)
);


