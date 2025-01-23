<?php
try {
    $dbPath = ''; // adicionar caminho do arquivo.db 
    $dsn = 'sqlite:' . $dbPath;

    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $store_name = $_POST['store_name'];
        $cnpj = $_POST['cnpj'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $cep = $_POST['cep'];
        $street = $_POST['street'];
        $number = $_POST['number'];
        $complement = $_POST['complement'];
        $neighborhood = $_POST['neighborhood'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $toastClass = 'toast-info';
            $toastMessage = "E-mail inválido.";
        }

        $cepPattern = '/^\d{5}-\d{3}$/';
        if (!preg_match($cepPattern, $cep)) {
            $toastClass = 'toast-info';
            $toastMessage = "CEP inválido. O formato correto é xxxxx-xxx.";
        }

        $logo = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
        }

        $sql_check = "SELECT COUNT(*) FROM companies WHERE store_name = :store_name";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':store_name', $store_name);
        $stmt_check->execute();
        $store_count = $stmt_check->fetchColumn();

        if ($store_count > 0 || $store_name === '' && $cnpj === '' && $email === '' && $contact === '' && $cep === '' && $street === '' && $number === '' && $complement === '' && $neighborhood === '' && $city === '' && $state === '') {
            $toastClass = 'toast-info';
            $toastMessage = 'Empresa já está cadastrada.';
        } else {
            $sql = "INSERT INTO companies (store_name, cnpj, email, contact, cep, street, number, complement, neighborhood, city, state, logo) 
                    VALUES (:store_name, :cnpj, :email, :contact, :cep, :street, :number, :complement, :neighborhood, :city, :state, :logo)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':store_name', $store_name);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':complement', $complement);
            $stmt->bindParam(':neighborhood', $neighborhood);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':logo', $logo, PDO::PARAM_LOB);

            if ($stmt->execute()) {
                $toastClass = 'toast-success';
                $toastMessage = 'Empresa cadastrada com sucesso!';
                
                $lastInsertId = $pdo->lastInsertId();
                $sql_select = "SELECT * FROM companies WHERE id = :id";
                $stmt_select = $pdo->prepare($sql_select);
                $stmt_select->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
                $stmt_select->execute();
                $company = $stmt_select->fetch(PDO::FETCH_ASSOC);
            } else {
                $toastClass = 'toast-error';
                $toastMessage = 'Falha ao cadastrar a empresa. Tente novamente.';
            }
        }
    }
} catch (PDOException $e) {
    $toastClass = 'toast-error';
    $toastMessage = 'Ocorreu um erro! Tente novamente.';
}
?><!DOCTYPE html>
<html lang="pt-br" data-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="src/styles/global.css">

</head>
<body>
    <div class="content">
        <h2>Cadastro de Empresa</h2>
        <div id="theme-toggle" class="theme-toggle-btn">
            <i id="theme-icon" class="fas fa-sun"></i>
        </div>    
    </div>
        
    <div id="container">
    <form id="form" method="POST" enctype="multipart/form-data">
            <div class="input-container">
                <input
                    id="name"
                    type="text"
                    name="store_name"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="name">Nome da Loja</label>
            </div>
            <div class="input-container">
                <input
                    id="cnpj"
                    type="text"
                    name="cnpj"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="cnpj">CNPJ</label>
            </div>
            <div class="input-container">
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="email">E-mail</label>
            </div>
            <div class="input-container">
                <input
                    id="contact"
                    type="text"
                    name="contact"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="contact">Contato</label>
            </div>
            <div class="input-container">
                <input
                    id="street"
                    type="text"
                    name="street"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="street">Rua</label>
            </div>
            <div class="input-container">
                <input
                    id="number"
                    type="text"
                    name="number"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="number">Número</label>
            </div>
            <div class="input-container">
            <input
                id="cep"
                type="text"
                name="cep"
                class="input"
                placeholder=""
                size="9"
                required
                pattern="^\d{5}-\d{3}$"
                title="Formato do CEP inválido. O formato correto é 12345-678."
            />

                <label for="cep">CEP</label>
            </div>
            
            <div class="input-container">
                <input
                    id="complement"
                    type="text"
                    name="complement"
                    class="input"
                    placeholder=""
                    required
                />
                <label for="complement">Complemento</label>
            </div>
            
            <div class="input-container">
                <input
                    id="neighborhood"
                    type="text"
                    name="neighborhood"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="bairro">Bairro</label>
            </div>
            
            <div class="input-container">
                <input
                    id="city"
                    type="text"
                    name="city"  
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="city">Cidade</label>
            </div>
            
            <div class="input-container">
                <input
                    id="state"
                    type="text"
                    name="state"
                    class="input"
                    placeholder=" "
                    required
                    
                />
                <label for="state">Estado</label>
            </div>
            
            <div class="input-container">
                <label for="logo" class="custom-file-label">Escolher arquivo</label>
                <input id="logo" type="file" name="logo" class="input-file" />
            </div>


            
            <input id="show" type="submit" value="Cadastrar">
            
        </div>

        </form>

    </div>
    <?php if (isset($toastMessage)): ?>
        <div id="toast" class="toast <?php echo $toastClass; ?>">
            <?php echo $toastMessage; ?>
        </div>
    <?php endif; ?>
   
    <?php if (isset($company)): ?>
        <script>
        Swal.fire({
            title: 'Dados da Empresa Cadastrada',
            html: `
                <p><strong>Nome da Loja:</strong> <?php echo htmlspecialchars($company['store_name']); ?></p>
                <p><strong>CNPJ:</strong> <?php echo htmlspecialchars($company['cnpj']); ?></p>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($company['email']); ?></p>
                <p><strong>Contato:</strong> <?php echo htmlspecialchars($company['contact']); ?></p>
                <p><strong>CEP:</strong> <?php echo htmlspecialchars($company['cep']); ?></p>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($company['street']); ?>, 
                <?php echo htmlspecialchars($company['number']); ?>
                - <?php echo htmlspecialchars($company['complement']); ?>
                - <?php echo htmlspecialchars($company['neighborhood']); ?>
                - <?php echo htmlspecialchars($company['city']); ?> - <?php echo htmlspecialchars($company['state']); ?></p>
            `,
            icon: 'success',
            confirmButtonText: 'OK',  
            confirmButtonColor: '#28a745',  
            background: '#f7f7f7',          
            customClass: {
                popup: 'popup',          
                title: 'title',          
                confirmButton: 'style-button',  
            }
        });
    </script>
    <?php endif; ?>

    <script src="src/js/script.js">
       
    </script>
</body>
</html>
 