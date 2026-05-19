create table if not exists categories (
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    title varchar(255) not null unique,
    description text null,
    created_at DATETIME not null default current_timestamp,
    updated_at DATETIME not null default current_timestamp on update current_timestamp
);

create table if not exists articles (
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    image varchar(255) null,
    title varchar(255) not null unique,
    description text null,
    content text not null,
    view_count int unsigned not null default 0,
    published_at DATETIME NOT NULL default current_timestamp,
    created_at DATETIME NOT NULL default current_timestamp,
    updated_at DATETIME not null default current_timestamp on update current_timestamp
);

create table if not exists article_category (
    article_id int unsigned not null,
    category_id int unsigned not null,

    primary key (article_id, category_id),
    index idx_article_category_category_id (category_id),

    constraint fk_article_category_article
        foreign key (article_id) references articles(id)
        on delete cascade,

    constraint fk_article_category_category
        foreign key (category_id) references categories(id)
        on delete cascade
);