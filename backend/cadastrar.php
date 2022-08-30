<?php
@session_start();
if ($_POST) {
    if (isset($_POST['login']) && isset($_POST['senha']) && isset($_POST['nome'])) {
        include './conexao.php';

        $nome = trim($_POST['nome']);
        $login = trim($_POST['login']);
        $senha = md5($_POST['senha']);

        $insert = $pdo->prepare("INSERT INTO usuario (nome, login, senha) VALUES ('$nome', '$login', '$senha')");

        $id_user = $pdo->lastInsertId();
        if ($insert->execute()) {

            $_SESSION['UsuarioID'] = $id_user;
            $_SESSION['UsuarioLogin'] = $login
            $_SESSION['UsuarioNome'] = $nome
            $_SESSION['IS_LOGGED'] = true;


            return json_encode([
                "status"=> true,
                "message"=> "Login is Success",
                "data" => [
                    "nome"=> $nome,
                    "email"=> $login,
                    "id_user"=> $id_user
                ]
                ]);
        } else {
            return json_encode([
                "status"=> false,
                "message"=> "Login Error",
                "data" => []
                ]);
        }
    }
} else {
    header('location: ../index.php');
}
