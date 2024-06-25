<?php

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    $php_errormsg = "Preencha todos os campos!";

    if ($nome == "" || $email == "" || $mensagem == "") {
        echo $php_errormsg;
    }

    if ($email != '') {}