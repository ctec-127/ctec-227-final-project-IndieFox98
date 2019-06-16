CREATE TABLE user (
    user_id int(11),
    first_name varchar(30),
    last_name varchar(30),
    user_name varchar(40),
    role varchar(20),
    email varchar(60),
    password varchar(128),
    profile_pic varchar(128),
    join_date date
);

CREATE TABLE image (
    image_id int(11),
    file_name varchar(128),
    file_size int(11),
    title varchar(60),
    description text,
    alt_text varchar(140),
    user_id int(11),
    category_id int(11),
    image_date date
);

CREATE TABLE comment (
    comment_id int(11),
    comment_string text,
    user_id int(11),
    image_id int(11),
    comment_date datetime
);

CREATE TABLE reaction (
    reaction_id int(11),
    reaction_name varchar(15)
);

CREATE TABLE category (
    category_id int(11),
    category_name varchar(60)
);

CREATE TABLE tag (
    tag_id int(11),
    tag_name varchar(60)
);

CREATE TABLE image_reaction (
    image_id int(11),
    reaction_id int(11),
    user_id int(11)
);

CREATE TABLE image_tag (
    image_id int(11),
    tag_id int(11)
);