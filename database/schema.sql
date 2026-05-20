create table if not exists categories (
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    title varchar(255) NOT NULL unique,
    description text NULL,
    created_at DATETIME NOT NULL default current_timestamp,
    updated_at DATETIME NOT NULL default current_timestamp on update current_timestamp
);

create table if not exists articles (
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    image varchar(255) NULL,
    title varchar(255) NOT NULL UNIQUE,
    description text NULL,
    content text NOT NULL,
    view_count int unsigned NOT NULL default 0,
    published_at DATETIME NULL default NULL,
    created_at DATETIME NOT NULL default current_timestamp,
    updated_at DATETIME NOT NULL default current_timestamp on update current_timestamp
);

create table if not exists article_category (
    article_id int unsigned NOT NULL,
    category_id int unsigned NOT NULL,

    primary key (article_id, category_id),
    index idx_article_category_category_id (category_id),

    constraint fk_article_category_article
        foreign key (article_id) references articles(id)
        on delete cascade,

    constraint fk_article_category_category
        foreign key (category_id) references categories(id)
        on delete cascade
);