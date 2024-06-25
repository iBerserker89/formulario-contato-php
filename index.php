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


        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "formulario_contato";

        $conn = new mysqli($hostname, $username, $password, $database);

        if ($conn -> connect_error) {
            die("Falha na conexão" . $conn -> connect_error);
        } else {
            $conexao_ok = "Conectado com sucesso";
        }

        $stmt = $conn -> prepare('INSERT INTO contatos (nome, email, mensagem, data_envio) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
        $stmt ->bind_param('sss', $nome, $email, $mensagem);

        if ($stmt -> execute()) {
            $mensagem_feedback = 'Dados inseridos com sucesso';
            header("Location: obrigado.php");
        } else {
            $mensagem_feedback = 'Erro ao inserir dados' . $stmt -> error;
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
    <script src="form_process.php"></script>
    <title>Formulario de Contato</title>
</head>
<body>
    <h1>Preencha os Campos Abaixo</h1>

    <?php if(isset($mensagem_feedback)): ?>
        <p><?php echo $mensagem_feedback; ?></p>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Digite seu nome:
            <input type="text" name="nome" value="<?php echo $nome; ?>" >
        </label>
        <span class="erro">* <?php echo $nomeErr; ?></span>
        <br><br>
        <label for="email">Digite seu email:
            <input type="email" name="email" value="<?php echo $email; ?>" >
        </label>
        <span class="erro">* <?php  echo $emailErr; ?></span>
        <br><br>
        <label for="mensagem">Digite sua mensagem: </label>
        <textarea name="mensagem" id="mensagem" cols="40" rows="5"><?php echo $mensagem; ?></textarea>
        <span class="erro">* <?php  echo $mensagemErr; ?></span>
        <br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>



