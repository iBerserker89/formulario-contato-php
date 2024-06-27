<?php
$sucesso = false;

if (isset($_POST['nome'])) {
    $aviso = '';

    $nome = test_input($_POST["nome"]);
    $email = test_input($_POST["email"]);
    $mensagem = test_input($_POST["mensagem"]);

    if (empty($_POST["nome"])) {
        $aviso = 'Por favor insira o nome';
    }

    if (!preg_match('/^[a-zA-Z" ]*$/', $nome)) {
        $aviso = 'Digite somente letras e espaços em branco';
    }

    if (empty($_POST["email"])) {
        $aviso = 'Por favor insira o email';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $aviso = 'Formato de email inválido';
    }


    if (empty($_POST["mensagem"])) {
        $aviso = 'Por favor, insira sua mensagem';
    }

    if (empty($aviso)) {
        $aviso .= 'Recebemos sua mensagem. Dados enviados. <br>';
        $aviso .= 'Nome: ' . $nome . '<br>';
        $aviso .= 'Email: ' . $email . '<br>';
        $aviso .= 'Mensagem: ' . $mensagem . '<br>';

        $aviso .= '<br><br> <a href="index.php">Voltar</a>';

        $sucesso = true;
    }
}


if (isset($_POST['nome'])) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "formulario_contato";

    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_error) {
        die("Falha na conexão" . $conn->connect_error);
    }

    $stmt = $conn->prepare('INSERT INTO contatos (nome, email, mensagem, data_envio) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
    $stmt->bind_param('sss', $nome, $email, $mensagem);

    $stmt->close();
    $conn->close();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="./public/styles.css">
    <title>Formulario de Contato</title>
</head>
<body>
<h1>Formulário de Contato</h1>

<?php if (!empty($aviso)) : ?>
    <h2><?php print $aviso; ?></h2>
<?php endif; ?>

<?php if (!$sucesso) : ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <input type="text" id="nome" name="nome" value="<?php if (isset($nome)) {
                echo $nome;
            } ?>" required>
            <label for="nome">Digite seu nome:</label>
            <div class="requirements">
                Deve contter somente letras e espaços.
            </div>
        </div>

        <div>
            <input type="email" id="email" name="email" value="<?php if (isset($email)) {
                echo $email;
            } ?>" required>
            <label for="email">Digite seu email:</label>
            <div class="requirements">
                Deve ser um endereço de email válido.
            </div>
        </div>

        <div>
            <textarea name="mensagem" id="mensagem" cols="40" rows="10" required><?php if (isset($mensagem)) {
                    echo $mensagem;
                } ?></textarea>
            <label for="mensagem">Digite sua mensagem: </label>
            <div class="requirements">
                Digite sua mensagem.
            </div>
        </div>

        <input class="submit" type="submit" value="Enviar">
    </form>
<?php endif; ?>
</body>
</html>



