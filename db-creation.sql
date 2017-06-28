CREATE TABLE Users(
        uid          CHAR(11),
        name         CHAR(20),
        school_code  CHAR(11),
        Password     CHAR(11),
        PRIMARY KEY (uid),
)

CREATE TABLE User_Attends(
        uid          CHAR(11),
        school_code  CHAR(11),
        PRIMARY KEY (uid),
        FOREIGN KEY (uid) REFERENCES Users,
        FOREIGN KEY (school_code) REFERENCES University
)

CREATE TABLE User_Ratings(
        uid          CHAR(11),
        eid          CHAR(11),
        rating       INTEGER,
        PRIMARY KEY (uid, eid)
        FOREIGN KEY (uid) REFERENCES Users
        FOREIGN KEY (eid) REFERENCES Events
)

CREATE TABLE User_Comments(
        uid          CHAR(11),
        eid          CHAR(11),
        comment      CHAR(140),
        PRIMARY KEY (uid, eid)
        FOREIGN KEY (uid) REFERENCES Users
        FOREIGN KEY (eid) REFERENCES Events
)

CREATE TABLE Student(
        uid          CHAR(11),
        PRIMARY KEY (uid),
        FOREIGN KEY (uid) REFERENCES Users
)

CREATE TABLE Admin(
        uid          CHAR(11),
        rso_id       CHAR(11)
        PRIMARY KEY (uid, rso_id),
        FOREIGN KEY (uid) REFERENCES Users,
        FOREIGN KEY (rso_id) REFERENCES RSO
)

CREATE TABLE RSO(
        rso_id        CHAR(11),
        uid           CHAR(11)
        name          CHAR(11),
        PRIMARY KEY (rso_id),
        FOREIGN KEY (uid) REFERENCES User
)

CREATE TABLE SuperAdmin(
        uid          CHAR(11),
        PRIMARY KEY (uid),
        FOREIGN KEY (uid) REFERENCES Users
)

CREATE TABLE University(
        school_code  CHAR(11),
        name         CHAR(11),
        description  CHAR(140),
        student_pop  INTEGER,
        website      CHAR(40)
        PRIMARY KEY (school_code)
)
CREATE TABLE Events(
        eid           CHAR(11),
        rso_id        CHAR(11),
        name          CHAR(11),
        visibility    INTEGER,
        email         CHAR(40),
        type          CHAR(11),
        phone         CHAR(13),
        start_date    DATE(),
        end_date      DATE(),
        start_time    TIME(),
        end_time      TIME()
        PRIMARY KEY (eid)
        FOREIGN KEY (rso_id) REFERENCES RSO
)

CREATE TABLE Location(
        lid           CHAR(11),
        name          CHAR(11),
        street        VARCHAR(255),
        city          VARCHAR(255),
        zip           VARCHAR(255),
        bldg          VARCHAR(255),
        room          VARCHAR(255),
        latitude      VARCHAR(255),
        longitude     VARCHAR(255),
        PRIMARY KEY (lid)
)
CREATE TABLE Uni_Location(
        school_code   CHAR(11),
        lid           CHAR(11),
        PRIMARY KEY (school_code),
        FOREIGN KEY (school_code) REFERENCES University
        FOREIGN KEY (lid) REFERENCES Location
)

CREATE TABLE Event_Location(
        eid         CHAR(255),
        lid         CHAR(11),
        PRIMARY KEY (school_code),
        FOREIGN KEY (school_code) REFERENCES University,
        FOREIGN KEY (lid) REFERENCES Location
)
