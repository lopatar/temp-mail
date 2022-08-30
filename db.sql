create table mail
(
    id       int      not null auto_increment primary key,
    username char(12) not null unique key,
    password char(32) not null,
    expires  int(10) not null
);
