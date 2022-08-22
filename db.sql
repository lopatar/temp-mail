create table mail(
    id int not null auto_increment primary key,
    username varchar(12) not null unique key,
    password varchar(32) not null,
    expires int(10) not null
);