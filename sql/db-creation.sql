DROP DATABASE IF EXISTS event_db;

CREATE DATABASE event_db;

USE event_db;

CREATE TABLE location(
        lid           INT           NOT NULL AUTO_INCREMENT,
        name          VARCHAR(255)  NOT NULL,
        address       VARCHAR(255)  NOT NULL,
        bldg          VARCHAR(255)  NOT NULL,
        room          VARCHAR(255)  NOT NULL,
        latitude      VARCHAR(255)  NOT NULL,
        longitude     VARCHAR(255)  NOT NULL,
        PRIMARY KEY (lid)
);

CREATE TABLE university(
        school_code  INT            NOT NULL,
        name         VARCHAR(255)   NOT NULL,
        abbrev       VARCHAR(15)    NOT NULL,
        description  TEXT           NOT NULL,
        student_pop  INT            NOT NULL,
        website      VARCHAR(255)   NOT NULL,
        lid          INT            NOT NULL,
        FOREIGN KEY (lid) REFERENCES location (lid),
        PRIMARY KEY (school_code)
);

CREATE TABLE users(
        uid          INT            NOT NULL AUTO_INCREMENT,
        first_name   VARCHAR(20)    NOT NULL,
        last_name    VARCHAR(20)    NOT NULL,
        school_code  INT            NOT NULL,
        username     VARCHAR(20)    NOT NULL,
        password     VARCHAR(11)    NOT NULL,
        email        VARCHAR(50)    NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE rso(
        rso_id        INT           NOT NULL AUTO_INCREMENT,
        uid           INT           NOT NULL,
        school_code   INT           NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        num_members   INT           NOT NULL,
        active        BOOLEAN       NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (rso_id)
);

CREATE TABLE events(
        eid           VARCHAR(11)   NOT NULL,
        rso_id        INT           NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        email         VARCHAR(255)  NOT NULL,
        type          VARCHAR(11)   NOT NULL,
        phone         VARCHAR(20)   NOT NULL,
        start_date    DATETIME      NOT NULL,
        end_date      DATETIME      NOT NULL,
        lid           INT           NOT NULL,
        description   TEXT          NOT NULL,
        approved      BOOLEAN               ,
        school_code   INT           NOT NULL,
        privacy       INT           NOT NULL,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        PRIMARY KEY (eid)
);

CREATE TABLE user_comments(
        uid          INT            NOT NULL,
        eid          CHAR(11)       NOT NULL,
        comment      VARCHAR(140)   NOT NULL,
        rating       INT            NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE
);

CREATE TABLE admin(
        uid          INT            NOT NULL,
        rso_id       INT            NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (rso_id)
);

CREATE TABLE super_admin(
        school_code   INT      NOT NULL,
        uid           INT      NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);

CREATE TABLE rso_member(
        uid             INT            NOT NULL,
        rso_id          INT            NOT NULL,
        PRIMARY KEY(uid , rso_id),
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE
);



-- Location CREATION --

INSERT INTO location (name, address, latitude, longitude)
VALUES('UCF Main Campus', '4000 Central Florida Blvd, Orlando, FL 32816', '28.6024', '-81.2001');
INSERT INTO location (name, address, latitude, longitude)
VALUES('UF Main Campus', 'Gainesville, FL 32611', '29.643632', '-82.35493');
INSERT INTO location (name, address, latitude, longitude)
VALUES('FSU Main Campus', '600 W College Ave, Tallahassee, FL 32306', '30.4419', '-84.2985');
INSERT INTO location (name, address, bldg, room)VALUES('Chess Event', 'UCF', 'ENG1', '103');
INSERT INTO location (name, address, bldg, room)VALUES('Aviation Flight', 'Airfield', 'Hangar', '1');
INSERT INTO location (name, address, latitude, longitude)
VALUES('Unaffiliated Campus', '123 Unaffiliated Way', '0', '0');


-- UNIVERSITY CREATION --
INSERT INTO university (school_code, name, abbrev, description, student_pop, website, lid)
VALUES('1', 'University of Central Florida', 'UCF', 'The University of Central Florida is a thriving preeminent research university located in metropolitan Orlando. With more than 64,000 students, UCF is one of the largest universities in the U.S. In addition to its impressive size and strength, UCF is ranked as a best-value university by The Princeton Review and Kiplinger’s, as well as one of the nation’s most affordable colleges by Forbes. The university benefits from a diverse faculty and staff who create a welcoming environment and opportunities for all students to grow, learn and succeed.', '64318', 'https://www.ucf.edu', '1');
INSERT INTO university (school_code, name, abbrev, description, student_pop, website, lid)
VALUES('2', 'University of Florida', 'UF', "At the University of Florida, we are a people of purpose. We're committed to challenging convention and ourselves. We see things not as they are, but as they could be. And we strive for a greater impact: one measured in people helped and lives improved.", '52286', 'http://www.ufl.edu/', '2');
INSERT INTO university (school_code, name, abbrev, description, student_pop, website, lid)
VALUES('3', 'Florida State University', 'FSU', "One of the nation's elite research universities, Florida State University preserves, expands, and disseminates knowledge in the sciences, technology, arts, humanities, and professions, while embracing a philosophy of learning strongly rooted in the traditions of the liberal arts and critical thinking.", '41867', 'http://www.fsu.edu/', '3');
INSERT INTO university (school_code, name, abbrev, description, student_pop, website, lid)
VALUES('999', 'Unaffiliated University', 'UU', 'Unaffiliated', '1', 'Unaffiliated.com', '4');

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

INSERT INTO super_admin VALUES('1' , '10');




-- For the events pulled from the ucf upcoming events xml
INSERT INTO rso (uid, school_code, name, num_members, active)
VALUES ('10', '1', 'UCF XML Events', '10', TRUE);
INSERT INTO rso (uid, school_code, name, num_members, active)
VALUES('8', '1', 'Chess Club', '5', TRUE);
INSERT INTO rso (uid, school_code, name, num_members, active)
VALUES('9', '1', 'Aviation Club', '5', TRUE);

INSERT INTO admin VALUES('10', '1');
INSERT INTO admin VALUES('8', '2');
INSERT INTO admin VALUES('9', '3');

INSERT INTO rso_member VALUES('1', '2');
INSERT INTO rso_member VALUES('2', '2');
INSERT INTO rso_member VALUES('3', '2');
INSERT INTO rso_member VALUES('4', '2');
INSERT INTO rso_member VALUES('8', '2');

INSERT INTO rso_member VALUES('5', '3');
INSERT INTO rso_member VALUES('6', '3');
INSERT INTO rso_member VALUES('7', '3');
INSERT INTO rso_member VALUES('9', '3');
INSERT INTO rso_member VALUES('8', '3');

INSERT INTO rso_member VALUES('1', '1');
INSERT INTO rso_member VALUES('2', '1');
INSERT INTO rso_member VALUES('3', '1');
INSERT INTO rso_member VALUES('4', '1');
INSERT INTO rso_member VALUES('5', '1');
INSERT INTO rso_member VALUES('6', '1');
INSERT INTO rso_member VALUES('7', '1');
INSERT INTO rso_member VALUES('8', '1');
INSERT INTO rso_member VALUES('9', '1');
INSERT INTO rso_member VALUES('10', '1');

INSERT INTO events(eid, rso_id, name, email, type, phone,
                    start_date, end_date, lid, description,
                    approved, school_code, privacy)
VALUES('1',  '2', 'First Chess Club Meeting', 'samLinnaUcf@knights.ucf.edu', 'Social', '202-555-0120',
                   '2017-07-30 13:30:00', '2017-07-30 14:00:00', '4', "The first chess club meeting of the semester, don't miss it!",
                   1, '1', '1');
INSERT INTO events(eid, rso_id, name, email, type, phone,
                   start_date, end_date, lid, description,
                  approved, school_code, privacy)
VALUES('2', '3', 'Aviation Club Test Flight', 'oliveMacUcf@knights.ucf.edu', 'Social', '630-446-8851',
                   '2017-08-02 10:30:00', '2017-08-02 12:00:00', '5', "The aviation club will be showing off the new drone they raised money for last semester",
                   1, '1', '1');



DROP TRIGGER IF EXISTS set_num_members_rso;

delimiter //
CREATE TRIGGER set_num_members_rso AFTER INSERT ON rso_member
FOR EACH ROW
BEGIN
    UPDATE rso SET num_members = num_members + 1 WHERE rso_id = NEW.rso_id;
END//
delimiter ;

DROP TRIGGER IF EXISTS reduce_num_members_rso;

delimiter //
CREATE TRIGGER reduce_num_members_rso AFTER DELETE ON rso_member
FOR EACH ROW
BEGIN
    UPDATE rso SET num_members = num_members - 1 WHERE rso_id = OLD.rso_id;
END//
delimiter ;


DROP TRIGGER IF EXISTS check_active_rso_update;

delimiter //
CREATE TRIGGER check_active_rso_update BEFORE UPDATE ON rso
FOR EACH ROW
BEGIN
    IF (NEW.num_members < 5) THEN
        SET NEW.active = FALSE;
    END IF;

    IF(NEW.num_members > 4) THEN
        SET NEW.active = TRUE;
    END IF;
END//
delimiter ;

DROP TRIGGER IF EXISTS check_active_rso_insert;

delimiter //
CREATE TRIGGER check_active_rso_insert BEFORE INSERT ON rso
FOR EACH ROW
BEGIN
    IF (NEW.num_members < 5) THEN
        SET NEW.active = FALSE;
    END IF;

    IF(NEW.num_members > 4) THEN
        SET NEW.active = TRUE;
    END IF;
END//
delimiter ;
