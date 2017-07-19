CREATE DATABASE IF NOT EXISTS energoprof_test CHARACTER SET utf8;

USE energoprof_test;

CREATE TABLE user(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор пользователя',
  name varchar(50) NOT NULL COMMENT 'Имя пользователя',
  password CHAR(32) NOT NULL COMMENT 'Пароль, MD5'
) ENGINE InnoDB COMMENT 'Пользователь';

CREATE TABLE user_session(
  user_id INT UNSIGNED NOT NULL COMMENT 'Идентификатор пользователя',
  session_id varchar(255) NOT NULL COMMENT 'Идентификатор сессии',
  data TEXT COMMENT 'Данные сессии',
  started DATETIME NOT NULL COMMENT 'Начало сессии',
  expires DATETIME NOT NULL COMMENT 'Истечение сессии',
  CONSTRAINT `PK_user_session_user_id_session_id` PRIMARY KEY (user_id, session_id),
  CONSTRAINT `FK_user_session_user_id` FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE InnoDB COMMENT 'Сессия пользователя';

CREATE TABLE page(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор страницы',
  user_id INT UNSIGNED NOT NULL COMMENT 'Идентификатор пользователя',
  title VARCHAR(255) COMMENT 'Заголовок страницы',
  header TEXT COMMENT 'Шапка страницы',
  general_content TEXT COMMENT 'Основное содержимое страницы',
  additional_content TEXT COMMENT 'Дополнительное содержимое страницы',
  created_at DATETIME COMMENT 'Когда странца создана',
  updated_at DATETIME COMMENT 'Когда страница обновлена',
  CONSTRAINT `FK_page_user_id` FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE InnoDB COMMENT 'Страница';
