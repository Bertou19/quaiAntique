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
  nom VARCHAR(250) NOT NULL,
  email VARCHAR(50)NOT NULL,
  telephone VARCHAR(10) NOT NULL,
  password VARCHAR(255) NOT NULL,
  allergie_ble INT,
  allergie_arachides INT,
  allergie_oeufs INT,
  allergie_lait INT,
  allergie_crustaces INT,
  nb_convives INT,
  roles VARCHAR(50) NOT NULL,
  horaires_id INT(11),
  FOREIGN KEY(horaires_id) REFERENCES horaires(id)
  galerie_id INT(11),
  FOREIGN KEY(galerie_id) REFERENCES galerie(id)
  );
  
  CREATE TABLE galerie(
  id_galerie INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL,
  titre VARCHAR(250) NOT NULL,
  image VARCHAR(250) NOT NULL
  );
  
  CREATE TABLE horaires(
  id_horaires INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  jour VARCHAR(50) NOT NULL,
  heure_debut_midi VARCHAR(50) NOT NULL
  heure_fin_midi VARCHAR(50) NOT NULL,
  heure_debut_soir VARCHAR(50) NOT nULL,
  heure_fin_soir VARCHAR(50) NOT NULL,
  fermeture INT
);
  
 CREATE TABLE tableRestaurant(
  id_table INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nb_convives_max INT NOT NULL, 
  );
  
  CREATE TABLE reservation(
  id_reservation INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(250) NOT NULL,
  email VARCHAR(250) NOT NULL,
  telephone VARCHAR(10) NOT NULL,
  date DATE NOT NULL,
  service VARCHAR(250) NOT NULL,
  heure_midi VARCHAR(250),
  heure_soir VARCHAR(250),
  nb_convives INT NOT NULL,
  allergie_ble INT,
  allergie_arachides INT,
  allergie_crustaces INT,
  allergie_oeufs INT,
  allergie_lait INT,
  user_id INT(11),
  FOREIGN KEY(user_id) REFERENCES user(id_user)
  );
  
 CREATE TABLE carte(
  id_carte INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(250) NOT NULL,
  nom_fichier VARCHAR(250) NOT NULL
 );
  
 







