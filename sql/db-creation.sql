DROP DATABASE IF EXISTS event_db;

CREATE DATABASE event_db;

USE event_db;

CREATE TABLE users(
        uid          CHAR(11)       NOT NULL,
        first_name   VARCHAR(20)    NOT NULL,
        last_name    VARCHAR(20)    NOT NULL,
        school_code  CHAR(11)       NOT NULL,
        Password     VARCHAR(11)    NOT NULL,
        PRIMARY KEY (uid)
);

CREATE TABLE university(
        school_code  CHAR(11)       NOT NULL,
        name         CHAR(11)       NOT NULL,
        description  VARCHAR(255),
        student_pop  INT,
        website      VARCHAR(40),
        PRIMARY KEY (school_code)
);

CREATE TABLE rso(
        rso_id        CHAR(11)      NOT NULL,
        uid           CHAR(11)      NOT NULL,
        name          VARCHAR(255)      NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (rso_id)
);

CREATE TABLE events(
        eid           VARCHAR(11)   NOT NULL,
        rso_id        CHAR(11)      NOT NULL,
        name          VARCHAR(255)  NOT NULL,
        visibility    INTEGER       NOT NULL,
        email         VARCHAR(255)  NOT NULL,
        type          VARCHAR(11)   NOT NULL,
        phone         VARCHAR(13)   NOT NULL,
        start_date    DATETIME      NOT NULL,
        end_date      DATETIME      NOT NULL,
        location      VARCHAR(255)  NOT NULL,
        room          VARCHAR(255)  NOT NULL,
        description   VARCHAR(255)  NOT NULL,
        /*FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE, commented out until rso table is used*/
        PRIMARY KEY (eid)
);

CREATE TABLE users_attends(
        uid          CHAR(11)       NOT NULL,
        school_code  CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        PRIMARY KEY (uid, school_code)
);

CREATE TABLE users_ratings(
        uid          CHAR(11)       NOT NULL,
        eid          CHAR(11)       NOT NULL,
        rating       INT            NOT NULL,
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

CREATE TABLE admin(
        uid          CHAR(11)       NOT NULL,
        rso_id       CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        FOREIGN KEY (rso_id) REFERENCES rso (rso_id) ON DELETE CASCADE,
        PRIMARY KEY (uid, rso_id)
);


CREATE TABLE super_admin(
        uid          CHAR(11)       NOT NULL,
        FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE,
        PRIMARY KEY (uid)
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
        school_code CHAR(11)        NOT NULL,
        FOREIGN KEY (school_code) REFERENCES university (school_code) ON DELETE CASCADE,
        FOREIGN KEY (lid) REFERENCES location (lid) ON DELETE CASCADE,
        PRIMARY KEY (school_code)
);
-- students
insert into users values('82498851236', 'John', 'Doe', '00000000001', 'pw');
insert into users values('46689825084', 'Frederica', 'Colbert', '00000000001', 'pw');
insert into users values('27440178157', 'Aime', 'Eads', '00000000001', 'pw');
insert into users values('36795473692', 'Sanjaya', 'Judd', '00000000001', 'pw');
insert into users values('01370325309', 'Nicole', 'Paulson', '00000000001', 'pw');
insert into users values('88968164998', 'Gavin', 'Brent', '00000000001', 'pw');
insert into users values('56692191669', 'Savannah', 'Brown', '00000000001', 'pw');
-- admins
insert into users values('39640152834', 'Samir', 'Linna', '00000000001', 'pw');
insert into users values('93068445139', 'Oliver', 'Mac', '00000000001', 'pw');
-- super_admin
insert into users values('00958079921', 'Marcelle', 'Travis', '00000000001', 'pw');

insert into rso values('33861964952', '39640152834', 'Chess Club');
insert into rso values('57285980110', '93068445139', 'Aviation Club');

insert into student values('82498851236');
insert into student values('46689825084');
insert into student values('27440178157');
insert into student values('36795473692');
insert into student values('01370325309');
insert into student values('88968164998');
insert into student values('56692191669');
-- both student and admins
insert into student values('39640152834');
insert into student values('93068445139');
insert into admin values('39640152834', '33861964952');
insert into admin values('93068445139', '57285980110');

insert into super_admin values('00958079921');

select * from users;
select * from student;
select * from rso;
