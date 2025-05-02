CREATE DATABASE IF NOT EXISTS ReceptKucko CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;

-- Adatbázis használata
USE ReceptKucko;

-- receptek tábla létrehozása
CREATE TABLE receptek (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nev VARCHAR(255) NOT NULL,
    hozzavalok TEXT NOT NULL,
    lepesek TEXT NOT NULL,
    kep VARCHAR(255) DEFAULT NULL
);

-- felhasznalok tábla létrehozása
CREATE TABLE felhasznalok (
    id INT AUTO_INCREMENT PRIMARY KEY,
    felhasznalonev VARCHAR(100) NOT NULL UNIQUE,
    jelszo VARCHAR(255) NOT NULL,
    csaladi_nev VARCHAR(100) NOT NULL,
    uto_nev VARCHAR(100) NOT NULL
);

-- kapcsolatfelvetel tábla létrehozása
CREATE TABLE kapcsolatfelvetel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    felhasznalo_id INT NOT NULL,
    kuldes_ideje DATETIME DEFAULT CURRENT_TIMESTAMP,
    uzenet TEXT NOT NULL,
    FOREIGN KEY (felhasznalo_id) REFERENCES felhasznalok(id) ON DELETE CASCADE
);

-- kepek tábla létrehozása
CREATE TABLE kepek (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fajlnev VARCHAR(255) NOT NULL,
    feltoltes_ideje DATETIME DEFAULT CURRENT_TIMESTAMP
);