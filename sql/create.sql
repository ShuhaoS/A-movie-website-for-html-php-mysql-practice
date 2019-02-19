CREATE TABLE Movie (
    id int,
    title varchar(100) NOT NULL,
    year int,
    rating varchar(10),
    company varchar(50),
    PRIMARY KEY(id) -- movie id should be unique and not null and should be primary key
) ENGINE = INNODB;

CREATE TABLE Actor (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    sex varchar(6),
    dob date NOT NULL,
    dod date,
    PRIMARY KEY(id), -- actor id should be primary
    CHECK (sex = 'Female' or sex = 'Male' or sex = 'Transgender') -- sex can only be male or female
) ENGINE = INNODB;

CREATE TABLE Sales (
    mid int,
    ticketsSold int,
    totalIncome int,
    PRIMARY KEY(mid), -- movie id should be also primary for sales table
    FOREIGN KEY (mid) REFERENCES Movie(id), -- movie id should exist in Movie
    CHECK (ticketsSold >= 0 and totalIncome >= 0) -- tickets number and income should be at least 0
) ENGINE = INNODB;

CREATE TABLE Director (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    dob date NOT NULL,
    dod date,
    PRIMARY KEY(id) -- director id should be primary
) ENGINE = INNODB;

CREATE TABLE MovieGenre(
    mid int,
    genre varchar(20),
    FOREIGN KEY (mid) REFERENCES Movie(id) -- movie id should exist in Movie
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
    mid int,
    did int,
    PRIMARY KEY (mid, did),
    FOREIGN KEY (mid) REFERENCES Movie(id), -- movie id should exist in Movie
    FOREIGN KEY (did) REFERENCES Director(id) -- director id should exist in Director
) ENGINE = INNODB;

CREATE TABLE MovieActor (
    mid int,
    aid int,
    role varchar(50),
    PRIMARY KEY (mid, aid),
    FOREIGN KEY (mid) REFERENCES Movie(id), -- movie id should exist in Movie
    FOREIGN KEY (aid) REFERENCES Actor(id)  -- actor id should exist in Actor
) ENGINE = INNODB;

CREATE TABLE MovieRating (
    mid int,
    imdb int,
    rot int,
    PRIMARY KEY (mid),
    FOREIGN KEY (mid) REFERENCES Movie(id), -- movie id should exist in Movie
    CHECK (imdb >=0 and imdb <= 100 and rot >= 0 and rot <= 100) -- ratings should be in [0, 100]
) ENGINE = INNODB;

CREATE TABLE Review (
    name varchar(20),
    time timestamp,
    mid int,
    rating int,
    comment varchar(500),
    FOREIGN KEY (mid) REFERENCES Movie(id)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id int
);

CREATE TABLE MaxMovieID (
    id int
);
