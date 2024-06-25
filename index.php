<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Formulario de Contato</title>
</head>
<body>
    <h1>Preencha os Campos Abaixo</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Digite seu nome:
        <label for="nome">
            <input type="text" name="nome">
        </label>
        <span>* <?php global $nomeErr; echo $nomeErr; ?></span>
        <br><br>
        <label for="email">Digite seu email:
            <input type="email" name="email">
        </label>
        <span>* <?php global $emailErr; echo $emailErr; ?></span>
        <br><br>
        <label for="mensagem">Digite sua mensagem: </label>
        <br>
        <textarea name="mensagem" id="mensagem" cols="30" rows="10"></textarea>
        <span>* <?php global $mensagemErr; echo $mensagemErr; ?></span>

        <br><br>
        <input type="submit" value="Enviar">
    </form>

    <?php
        $nomeErr = $emailErr = $mensagemErr = "";
        $nome = $email = $mensagem = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = test_input($_POST["nome"]);
            $email = test_input($_POST["email"]);
            $mensagem = test_input($_POST["mensagem"]);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["nome"])) {
                $nomeErr = 'Por favor, insira seu nome';
            } else {
                $nome = test_input($_POST["nome"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = 'Por favor, insira seu email';
            } else {
                $email = test_input($_POST["email"]);
            }

            if (empty($_POST["mensagem"])) {
                $mensagemErr = 'Por favor, insira sua mensagem';
            } else {
                $mensagem = test_input($_POST["mensagem"]);
            }
        }
        
    ?>

</body>
</html>
