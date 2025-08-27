<?php
    session_start();

    require_once 'conexao.php';

    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id_cliente'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
    
        $query = "UPDATE cliente SET nome_cliente = :nome, endereco = :endereco, telefone = :telefone, email = :email WHERE id_cliente = :id";

        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $stmt -> bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt -> execute();
            echo "<script> alert('Cliente alterado com sucesso!'); window.location.href='buscar_cliente.php'; </script>";
            exit();
        } catch (PDOException $e) {
            echo "<script> alert('Falha ao alterar cliente!'); window.location.href='alterar_cliente.php'; </script>";
            exit();
        }
    }

?>