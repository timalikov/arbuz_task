create table categories
(
    categoryid   integer default nextval('category_categoryid_seq'::regclass) not null
        constraint category_pkey
            primary key,
    categoryname varchar(255)                                                 not null
);


create table products
(
    id           serial
        primary key,
    name         varchar(100)   not null,
    description  varchar(255)   not null,
    price        numeric(10, 2) not null,
    availability boolean,
    category_id  integer
        constraint products_categorys
            references categories,
    weight       numeric(10, 2) not null
);


create table inventory
(
    product_id        integer not null
        primary key
        references products,
    quantity          integer,
    reorder_threshold integer
);


create table customers
(
    id      serial
        primary key,
    name    varchar(100) not null,
    email   varchar(100) not null,
    address varchar(255) not null,
    phone   varchar(20)  not null
);


create table cart
(
    id          integer default nextval('cart_cart_id_seq'::regclass) not null
        primary key,
    customer_id integer                                               not null
        references customers,
    product_id  integer                                               not null
        references products,
    quantity    integer default 1                                     not null
);


create table subscriptions
(
    id                    serial
        primary key,
    customer_id           integer     not null
        references customers,
    delivery_day          varchar(50) not null,
    delivery_period       varchar(50) not null,
    subscription_duration integer     not null,
    delivery_frequency    varchar(50) not null,
    address               varchar(50) not null,
    phone_number          varchar(15) not null
);


create table subscription_products
(
    id              serial
        primary key,
    subscription_id integer not null
        references subscriptions,
    product_id      integer not null
        references products
);
