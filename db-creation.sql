DROP DATABASE IF EXISTS school_db;

CREATE DATABASE school_db;

use schoolDb;

CREATE TABLE users(
        uid          CHAR(11)       NOT NULL,
        first_name   VARCHAR(20)    NOT NULL,
        last_name    VARCHAR(20)    NOT NULL,
        school_code  CHAR(11)       NOT NULL,
        Password     VARCHAR(11)    NOT NULL,
        PRIMARY KEY (uid)
);

CREATE TABLE users_attends(
        uid          CHAR(11)       NOT NULL,
        school_code  CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (school_code) REFERENCES (school_code) university ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE users_ratings(
        uid          CHAR(11)       NOT NULL,
        eid          CHAR(11)       NOT NULL,
        rating       INTEGER        NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
        PRIMARY KEY (uid, eid)
);

CREATE TABLE users_comments(
        uid          CHAR(11)       NOT NULL,
        eid          CHAR(11)       NOT NULL,
        comment      VARCHAR(140)   NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (eid) REFERENCES events (eid) ON DELETE CASCADE,
        PRIMARY KEY (uid, eid)
);

CREATE TABLE student(
        uid          CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE Admin(
        uid          CHAR(11)       NOT NULL,
        rso_id       CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (uid, rso_id)
);

CREATE TABLE rso(
        rso_id        CHAR(11)      NOT NULL,
        uid           CHAR(11)      NOT NULL,
        name          CHAR(11)      NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (rso_id)
);

CREATE TABLE SuperAdmin(
        uid          CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (uid)
);

CREATE TABLE university(
        school_code  CHAR(11)       NOT NULL,
        name         CHAR(11)       NOT NULL,
        description  VARCHAR(255),
        student_pop  INTEGER,
        website      VARCHAR(40),
        PRIMARY KEY (school_code)
);

CREATE TABLE events(
        eid           CHAR(11)      NOT NULL,
        rso_id        CHAR(11)      NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        visibility    INTEGER       NOT NULL,
        email         VARCHAR(40)   NOT NULL,
        type          CHAR(11)      NOT NULL,
        phone         CHAR(13)      NOT NULL,
        start_date    DATE          NOT NULL,
        end_date      DATE          NOT NULL,
        start_time    TIME          NOT NULL,
        end_time      TIME          NOT NULL,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (eid)
);

CREATE TABLE location(
        lid           CHAR(11)      NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        street        VARCHAR(255)  NOT NULL,
        city          VARCHAR(255)  NOT NULL,
        zip           VARCHAR(255)  NOT NULL,
        bldg          VARCHAR(255)  NOT NULL,
        room          VARCHAR(255)  NOT NULL,
        latitude      VARCHAR(255)  NOT NULL,
        longitude     VARCHAR(255)  NOT NULL,
        PRIMARY KEY (lid)
);

CREATE TABLE uni_location(
        school_code   CHAR(11)      NOT NULL,
        lid           CHAR(11)      NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);

CREATE TABLE event_location(
        eid         CHAR(11)        NOT NULL,
        lid         CHAR(11)        NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);
