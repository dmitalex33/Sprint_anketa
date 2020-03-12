CREATE DATABASE IF NOT EXISTS `anketa` DEFAULT CHARSET utf8;
USE `anketa`;


DROP TABLE IF EXISTS streets;

create table streets (
street_id int(10) not null auto_increment,
name varchar(512) not null,
primary key(street_id)
);


DROP TABLE IF EXISTS orders;

create table orders (
order_id int(10) not null auto_increment,
dt TIMESTAMP not null,
surname varchar(512) not null,
first_name varchar(512) not null,
second_name varchar(512),
street varchar(512) not null,
house varchar(512) not null,
room varchar(512),
phone varchar(512) not null,
email varchar(512) not null,
doc varchar(512) not null,
ser varchar(512),
num varchar(512) not null,
doc_date varchar(512),
inet_tariff varchar(512),
number_comp varchar(512),
phone_tariff varchar(512),
phone_number varchar(512),
wifiRouter varchar(512),
tvBox varchar(512),
summa int(15),
primary key(order_id)
);


LOCK TABLES streets WRITE;

INSERT INTO streets (name) VALUES 
("Дзержинского пр-т"),
("Ленина пр-т"),
("Ленская ул."),
("Московская ул."),
("Советов ул."),
("Видова ул."),
("Анапское шоссе"),
("Рубина ул."),
("Куникова ул."),
("Молодёжная ул.")
;

UNLOCK TABLES;