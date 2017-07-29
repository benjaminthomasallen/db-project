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
        PRIMARY KEY (lid, room)
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
