create table tasks
(
    id         int AUTO_INCREMENT PRIMARY KEY,
    title      varchar(255),
    created_at timestamp default CURRENT_TIMESTAMP
);