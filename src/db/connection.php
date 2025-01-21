<?php
$dsn = '';
$username = null;  
$password = null;  

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("
    CREATE TABLE IF NOT EXISTS companies (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        store_name VARCHAR(255) NOT NULL,
        cnpj VARCHAR(18) NOT NULL,
        email VARCHAR(255) NOT NULL,
        contact VARCHAR(15),
        cep VARCHAR(10),
        street VARCHAR(255),
        number VARCHAR(10),
        complement VARCHAR(255),
        neighborhood VARCHAR(255),
        city VARCHAR(255),
        state CHAR(2),
        logo BLOB,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("
    INSERT INTO companies (store_name, cnpj, email, contact, cep, street, number, complement, neighborhood, city, state, logo)
    VALUES 
    ('Loja', '12.345.678/0000-11', 'contato@loja.com', '(11) 12345-6789', '12345-678', 'Rua, 123', '100', 'Apto 101', 'Bairro', 'São Paulo', 'SP', NULL)
    ");

} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
