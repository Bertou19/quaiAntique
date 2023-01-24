/* 
OUVRIR LE SERVEUR
  
CREER LA BASE :
*/

CREATE DATABASE quai_antique;

ALTER DATABASE quai_antique CHARSET=utf8; 

SHOW DATABASES;               
USE quai_antique;

/*Creer les tables*/


 CREATE TABLE user(
  id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50)NOT NULL,
  password VARCHAR(255) NOT NULL,
  horaires_id INT(11),
  FOREIGN KEY(horaires_id) REFERENCES horaires(id)
  galerie_id INT(11),
  FOREIGN KEY(galerie_id) REFERENCES galerie(id)
  );
  
  
  CREATE TABLE client(
  id_client INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  allergie_blé INT,
  allergie_arachides INT,
  allergie_oeufs INT,
  allergie_lait INT,
  nb_convives INT,
  reservation_id INT(11),
  FOREIGN KEY(reservation_id) REFERENCES reservation(id)
  );
  
  CREATE TABLE galerie(
  id_galerie INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(250) NOT NULL,
  image VARCHAR(250 NOT NULL,
  );
  
  CREATE TABLE horaires(
  id_horaires INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  jour VARCHAR(50) NOT NULL,
  heure VARCHAR(50) NOT NULL
  );
  
  CREATE TABLE plat(
  id_plat INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(50) NOT NULL,
  description TEXT NOT NULL,
  prix INT NOT NULL,
  categorie_id INT(11),
  FOREIGN KEY(categorie_id) REFERENCES categorie(id)
  );
  
  CREATE TABLE menu(
  id_menu INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(50) NOT NULL
  prix INT NOT NULL,
  plat_id INT(11),
  FOREIGN KEY(plat_id) REFERENCES plat(id)
  );
  
  CREATE TABLE categorie(
  id_categorie INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR (50) NOT NULL,
  );
  
  CREATE TABLE table(
  id_table INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nb_convives_max INT NOT NULL,
  reservation_id INT(11),
  FOREIGN KEY(reservation_id) REFERENCES reservation(id)
  );
  
  CREATE TABLE reservation(
  id_reservation INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  heure VARCHAR(50) NOT NULL,
  nb_convives INT NOT NULL
  );
  
  
  /*RESTREINDRE LES AUTORISATIONS */

/*creation des autorisations pour un client en lecture seule*/
CREATE USER 'readUser'@'localhost' IDENTIFIED BY 'P@ssw0rd';
GRANT SELECT ON quai_antique.reservation TO 'readUser'@'localhost';

/*creation des autorisations pour un administrateur qui a vue sur tout*/
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'P@ssw0rd';
GRANT ALL ON quai_antique.* TO 'admin'@'localhost';

  
