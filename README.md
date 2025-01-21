# task-mistercheff

Clonar repositório:
> `git clone https://github.com/brendaAndersen/task-mistercheff.git`

Criar a tabela:
>`CREATE TABLE IF NOT EXISTS companies (
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
);`

> Adicionar caminho do arquivo .db no arquivo index.php na variável $dbPath

Subir o servidor
> `php -S localhost:5000`