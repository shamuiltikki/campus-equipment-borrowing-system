CREATE TABLE equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description VARCHAR(255) NOT NULL,
    availability ENUM('Available','Unavailable') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrowing_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    equipment_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    return_date DATE NOT NULL,
    purpose TEXT NOT NULL,
    status ENUM('Pending','Approved','Rejected','Issued','Returned') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipment_id) REFERENCES equipment(id)
);

INSERT INTO equipment
(name, category, description)
VALUES
('Dell Laptop', 'Computing', 'Portable laptop for academic work and presentations.'),
('Epson Projector', 'Presentation', 'Projector for classrooms, seminars and presentations.'),
('Canon Camera', 'Media', 'Digital camera for college events and documentation.'),
('Wireless Microphone', 'Audio', 'Wireless microphone for seminars and stage events.'),
('Portable Speaker', 'Audio', 'Portable speaker for campus activities and events.'),
('HDMI Adapter Kit', 'Accessories', 'Adapters and cables for connecting presentation devices.');