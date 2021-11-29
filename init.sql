# create database 'quizz';
# use quizz;

CREATE TABLE `student_test` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `start_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `end_time` datetime,
  `questions_total` int,
  `questions_correct` int,
  `pass` BOOLEAN,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `answers` (
  `test_id` varchar(50) NOT NULL,
  `question_id` MEDIUMINT NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `unit` varchar(255) NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `questions` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `question_number` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `unit` varchar(255) NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO questions(question_number, question, answer, unit, category) VALUES (1,'2+2', '4',NULL, 'basic');
INSERT INTO questions(question_number, question, answer, unit, category) VALUES (2,'3*4', '12',NULL, 'basic');
INSERT INTO questions(question_number, question, answer, unit, category) VALUES (1,'8.3l', '8300','ml', 'units');
INSERT INTO questions(question_number, question, answer, unit, category) VALUES (2,'0.75l', '750','ml', 'units');

CREATE TABLE `users` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Matti', 'Heikkonen','opettaja1', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'uitto@kettu.fi', 'teacher');
INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Tytti', 'Terävä','oppilas1', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'tytti@saareke.fi', 'student');
INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Kalle', 'Vetelä','oppilas2', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'kalle@saareke.fi', 'student');
INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Jaakko', 'Juppi','oppilas3', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'jaakko@saareke.fi', 'student');
INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Pekka', 'Tynnyri','oppilas4', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'pekka@saareke.fi', 'student');
INSERT INTO users(firstname, lastname, username, password, email, role) VALUES ('Viivi', 'Vanilla','oppilas5', '$2y$10$0.NMisuz78c7NKvfGCTG4eKI8ypl6Jv90EI5aQ93VxbDyn0YrDH1W', 'viivi@saareke.fi', 'student');
