create table email(
    id int not null auto_increment primary key,
    username varchar not null unique key,
    password varchar not null,
    expires int not null
);