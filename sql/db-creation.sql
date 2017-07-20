DROP DATABASE IF EXISTS event_db;

CREATE DATABASE event_db;

USE event_db;

CREATE TABLE users(
        uid          INT            NOT NULL AUTO_INCREMENT,
        first_name   VARCHAR(20)    NOT NULL,
        last_name    VARCHAR(20)    NOT NULL,
        school_code  VARCHAR(11)    NOT NULL,
        username     VARCHAR(20)    NOT NULL,
        password     VARCHAR(11)    NOT NULL,
        email        VARCHAR(50)    NOT NULL,
        PRIMARY KEY (uid)
);

CREATE TABLE university(
        school_code  INT            NOT NULL AUTO_INCREMENT,
        name         VARCHAR(255)   NOT NULL,
        abbrev       VARCHAR(15)    NOT NULL,
        description  TEXT           NOT NULL,
        student_pop  INT            NOT NULL,
        website      VARCHAR(255)   NOT NULL,
        PRIMARY KEY (school_code)
);

CREATE TABLE rso(
        rso_id        INT           NOT NULL AUTO_INCREMENT,
        uid           INT           NOT NULL,
        school_code   INT           NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (rso_id)
);

CREATE TABLE events(
        eid           VARCHAR(11)   NOT NULL,
        rso_id        INT           NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        visibility    INTEGER       NOT NULL,
        email         VARCHAR(255)  NOT NULL,
        type          VARCHAR(11)   NOT NULL,
        phone         VARCHAR(13)   NOT NULL,
        start_date    DATETIME      NOT NULL,
        end_date      DATETIME      NOT NULL,
        location      VARCHAR(255)  NOT NULL,
        room          VARCHAR(255)  NOT NULL,
        description   TEXT  NOT NULL,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (eid)
);

CREATE TABLE users_attends(
        uid          INT            NOT NULL,
        school_code  INT            NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        PRIMARY KEY (uid, school_code)
);

CREATE TABLE users_ratings(
        uid          INT       NOT NULL,
        eid          CHAR(11)       NOT NULL,
        rating       INT            NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
        PRIMARY KEY (uid, eid)
);

CREATE TABLE users_comments(
        uid          INT            NOT NULL,
        eid          CHAR(11)       NOT NULL,
        comment      VARCHAR(140)   NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
        PRIMARY KEY (uid, eid)
);

CREATE TABLE student(
        uid           INT           NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE admin(
        uid          INT            NOT NULL,
        rso_id       INT            NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (uid, rso_id)
);


CREATE TABLE super_admin(
        uid     INT                 NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE location(
        lid           INT           NOT NULL AUTO_INCREMENT,
        name          VARCHAR(255)  NOT NULL,
        address       VARCHAR(255)  NOT NULL,
        latitude      VARCHAR(255)  NOT NULL,
        longitude     VARCHAR(255)  NOT NULL,
        PRIMARY KEY (lid)
);

CREATE TABLE uni_location(
        school_code   INT           NOT NULL,
        lid           INT           NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);

CREATE TABLE event_location(
        eid            VARCHAR(11)   NOT NULL,
        lid            INT           NOT NULL,
        school_code    INT           NOT NULL,
        bldg           VARCHAR(255)  NOT NULL,
        room           VARCHAR(255)  NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);

-- UCF students
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('John', 'Doe', '1', 'johndUcf', 'pw', 'johndUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Frederica', 'Colbert', '1', 'fredcolbUcf', 'pw', 'fredcolbUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Aime', 'Eads', '1', 'aimeEadsUcf', 'pw', 'aimeEadsUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Sanjaya', 'Judd', '1', 'sanJuddUcf', 'pw', 'sanJuddUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Nicole', 'Paulson', '1', 'nicPaulUcf', 'pw', 'nicPaulUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Gavin', 'Brent', '1', 'gavBrentUcf', 'pw', 'gavBrentUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Savannah', 'Brown', '1', 'savBrownUcf', 'pw', 'savBrownUcf@knights.ucf.edu');
-- admins
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Samir', 'Linna', '1', 'samLinnaUcf', 'pw', 'samLinnaUcf@knights.ucf.edu');
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Oliver', 'Mac', '1', 'oliveMacUcf', 'pw', 'oliveMacUcf@knights.ucf.edu');
-- UCF super_admin
INSERT INTO users (first_name, last_name, school_code, username, password, email)
VALUES('Marcelle', 'Travis', '1', 'macTravisUcf', 'pw', 'macTravisUcf@knights.edu');

INSERT INTO student VALUES('1');
INSERT INTO student VALUES('2');
INSERT INTO student VALUES('3');
INSERT INTO student VALUES('4');
INSERT INTO student VALUES('5');
INSERT INTO student VALUES('6');
INSERT INTO student VALUES('7');
-- both student and admins
INSERT INTO student VALUES('8');
INSERT INTO student VALUES('9');

INSERT INTO super_admin VALUES('10');

INSERT INTO university (name, abbrev, description, student_pop, website)
VALUES('University of Central Florida', 'UCF', 'The University of Central Florida is a thriving preeminent research university located in metropolitan Orlando. With more than 64,000 students, UCF is one of the largest universities in the U.S. In addition to its impressive size and strength, UCF is ranked as a best-value university by The Princeton Review and Kiplinger’s, as well as one of the nation’s most affordable colleges by Forbes. The university benefits from a diverse faculty and staff who create a welcoming environment and opportunities for all students to grow, learn and succeed.', '64318', 'https://www.ucf.edu');
INSERT INTO university (name, abbrev, description, student_pop, website)
VALUES('University of Florida', 'UF', "At the University of Florida, we are a people of purpose. We're committed to challenging convention and ourselves. We see things not as they are, but as they could be. And we strive for a greater impact: one measured in people helped and lives improved.", '52286', 'http://www.ufl.edu/');
INSERT INTO university (name, abbrev, description, student_pop, website)
VALUES('Florida State University', 'FSU', "One of the nation's elite research universities, Florida State University preserves, expands, and disseminates knowledge in the sciences, technology, arts, humanities, and professions, while embracing a philosophy of learning strongly rooted in the traditions of the liberal arts and critical thinking.", '41867', 'http://www.fsu.edu/');

INSERT INTO location (name, address, latitude, longitude)
VALUES('UCF Main Campus', '4000 Central Florida Blvd, Orlando, FL 32816', '28.6024', '-81.2001');
INSERT INTO location (name, address, latitude, longitude)
VALUES('UF Main Campus', 'Gainesville, FL 32611', '29.643632', '-82.35493');
INSERT INTO location (name, address, latitude, longitude)
VALUES('FSU Main Campus', '600 W College Ave, Tallahassee, FL 32306', '30.4419', '-84.2985');

INSERT INTO uni_location VALUES('1', '1');
INSERT INTO uni_location VALUES('2', '2');
INSERT INTO uni_location VALUES('3', '3');

INSERT INTO users_attends VALUES('1', '1');
INSERT INTO users_attends VALUES('2', '1');
INSERT INTO users_attends VALUES('3', '1');
INSERT INTO users_attends VALUES('4', '1');
INSERT INTO users_attends VALUES('5', '1');
INSERT INTO users_attends VALUES('6', '1');
INSERT INTO users_attends VALUES('7', '1');
INSERT INTO users_attends VALUES('8', '1');
INSERT INTO users_attends VALUES('9', '1');

-- For the events pulled from the ucf upcoming events xml
INSERT INTO rso (uid, school_code, name)
VALUES ('10', '1', 'UCF XML Events');
INSERT INTO rso (uid, school_code, name)
VALUES('8', '1', 'Chess Club');
INSERT INTO rso (uid, school_code, name)
VALUES('9', '1', 'Aviation Club');

INSERT INTO admin VALUES('10', '1');
INSERT INTO admin VALUES('8', '2');
INSERT INTO admin VALUES('9', '3');

select * from users;
select * from student;
select * from rso;
select * from university;
