DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
  id            INTEGER     NOT NULL PRIMARY KEY AUTOINCREMENT,
  name          VARCHAR(50) NOT NULL,
  email         VARCHAR(50) NOT NULL,
  phone         VARCHAR(11) NOT NULL,
  file_name     VARCHAR(7)                       DEFAULT NULL,
  creation_date TIMESTAMP   NOT NULL,
  status        TINYINT     NOT NULL             DEFAULT 0
);

CREATE UNIQUE INDEX user_email_uindex  ON user (email);
CREATE UNIQUE INDEX user_phone_uindex  ON user (phone);