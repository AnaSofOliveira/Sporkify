# Create data base
CREATE DATABASE IF NOT EXISTS `sporkify` CHARACTER SET utf8 COLLATE utf8_unicode_ci;

# Create user accessing from localhost
DROP USER IF EXISTS 'admin'@'localhost';
FLUSH PRIVILEGES;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'administrator';

# Create user accessing from remote hosts
DROP USER IF EXISTS 'admin'@'%';
FLUSH PRIVILEGES;
CREATE USER 'admin'@'%' IDENTIFIED BY 'administrator';

# Grant usages
GRANT USAGE ON * . * TO 'admin'@'localhost' IDENTIFIED BY 'administrator' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
GRANT USAGE ON * . * TO 'admin'@'%' IDENTIFIED BY 'administrator' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

# Grant privileges
GRANT ALL PRIVILEGES ON `sporkify` . * TO 'admin'@'localhost';
GRANT ALL PRIVILEGES ON `sporkify` . * TO 'admin'@'%';