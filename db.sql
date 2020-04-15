create table orders
(
    id            int auto_increment
        primary key,
    order_code    varchar(255)                        not null,
    product_id    int                                 not null,
    quantity      int                                 not null,
    address       longtext                            not null,
    shipping_date date                                null,
    created_at    timestamp default CURRENT_TIMESTAMP not null,
    constraint UNIQ_E52FFDEE3AE40A8F
        unique (order_code)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO challenge.orders (id, order_code, product_id, quantity, address, shipping_date, created_at) VALUES (1, 'OR123', 12345, 3, 'address info', '2020-05-01', '2020-04-15 12:49:04');
create table users
(
    id       int auto_increment
        primary key,
    username varchar(25)  not null,
    email    varchar(255) not null,
    password varchar(500) not null,
    constraint UNIQ_1483A5E9E7927C74
        unique (email),
    constraint UNIQ_1483A5E9F85E0677
        unique (username)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO challenge.users (id, username, email, password) VALUES (5, 'yusufkenar', 'kenaryusuf@gmail.com', '$2y$13$AgSFXg1iagA5WdbLKtQXHucW0FbdIapUWZKzW72jb./qLgNtPWyjS');