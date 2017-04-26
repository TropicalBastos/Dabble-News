
DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
  id smallint unsigned NOT NULL AUTO_INCREMENT,
  publicationDate date NOT NULL,
  title varchar(255) NOT NULL,
  summary text NOT NULL,
  content mediumtext NOT NULL,
  PRIMARY KEY (id)
);
