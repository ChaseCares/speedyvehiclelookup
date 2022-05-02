CREATE DATABASE IF NOT EXISTS speedyvehiclelookup_db;
USE speedyvehiclelookup_db;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Vehicle;
DROP TABLE IF EXISTS Brand;
DROP TABLE IF EXISTS Type;

CREATE TABLE Brand(
    make varchar(255),
    primary key (make)
);

CREATE TABLE Type(
    model varchar(255),
    primary key (model)
);

CREATE TABLE Vehicle(
    vehicle_condition varchar(20),
    VIN char(17) NOT NULL,
    color varchar(20),
    year YEAR,
    make varchar(255),
    model varchar(255),
    primary key (VIN),
    foreign key (make) references Brand(make),
    foreign key (model) references Type(model)
);

SET FOREIGN_KEY_CHECKS=1;
