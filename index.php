<?php
    $nomeErr = $emailErr = $mensagemErr = "";
    $nome = $email = $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nome = test_input($_POST["nome"]);
        $email = test_input($_POST["email"]);
        $mensagem = test_input($_POST["mensagem"]);

        if (empty($_POST["nome"])) {
            $nomeErr = 'Por favor, insira seu nome';
        } else {
            $nome = test_input($_POST["nome"]);
            if (!preg_match("/^[a-zA-Z' ]*$/",$nome)) {
                $nomeErr = 'Digite somente letras e espaços em branco';
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = 'Por favor, insira seu email';
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = 'Formato de email inválido';
            }
        }

        if (empty($_POST["mensagem"])) {
            $mensagemErr = 'Por favor, insira sua mensagem';
        } else {
            $mensagem = test_input($_POST["mensagem"]);
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "formulario_contato";

        $conn = new mysqli($hostname, $username, $password, $database);

        if ($conn -> connect_error) {
            die("Falha na conexão" . $conn -> connect_error);
        }

        $stmt = $conn -> prepare('INSERT INTO contatos (nome, email, mensagem, data_envio) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
        $stmt ->bind_param('sss', $nome, $email, $mensagem);

        if ($stmt -> execute() && !empty($_POST['nome']) && !empty($_POST["email"]) && !empty($_POST["mensagem"])) {
            $mensagem_feedback = 'Dados inseridos com sucesso';
            header("Location: finished.php");
        } else {
            $mensagem_feedback = "Erro ao enviar dados";
        }

        $stmt -> close();
        $conn -> close();
    }


    function test_input($data) {
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
    <h1>Formulário Básico de contato</h1>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required >
            <label for="nome">Digite seu nome:</label>
            <div class="requirements">
                Deve conter apenas letras e espaços.
            </div>
        </div>

        <div>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required placeholder=" ">
            <label for="email">Digite seu email:</label>
            <div class="requirements">
                Deve ser um endereço de email válido.
            </div>
        </div>

        <div>
            <textarea name="mensagem" id="mensagem" cols="40" rows="6" required><?php echo $mensagem; ?></textarea>
            <label for="mensagem">Digite sua mensagem: </label>
        </div>

        <input class="submit" type="submit" value="Enviar">

        <?php if (isset($mensagem_feedback)): ?>
            <p><?php echo $mensagem_feedback; ?></p>
        <?php endif; ?>

    </form>
</body>
</html>



