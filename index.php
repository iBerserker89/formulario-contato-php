<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de Contato</title>
</head>
<body>
    <h1>Preencha os Campos Abaixo</h1>
    <form action="form_process.php" method="post">
        <label for="nome">Digite seu nome: </label>
        <input type="text" name="nome"><br>
        <label for="email">Digite seu email: </label>
        <input type="email" name="email"><br>
        <label for="mensagem">Digite sua mensagem: </label><br>
        <textarea name="mensagem" id="mensagem" cols="30" rows="10"></textarea><br>
        <input type="submit" value="Enviar">
    </form>

</body>
</html>
