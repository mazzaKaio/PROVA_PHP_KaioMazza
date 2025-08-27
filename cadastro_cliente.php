<?php
    session_start();

    require_once 'conexao.php';

    if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

        $query = "INSERT INTO cliente (nome_cliente, endereco, telefone, email) VALUES (:nome, :endereco, :telefone, :email)";

        $stmt = $pdo -> prepare($query);

        $stmt -> bindParam('nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam('endereco', $endereco, PDO::PARAM_STR);
        $stmt -> bindParam('telefone', $telefone, PDO::PARAM_STR);
        $stmt -> bindParam('email', $email, PDO::PARAM_STR);

        try {
            $stmt -> execute();
            echo "<script> alert('Cliente cadastrado com sucesso!'); </script>";
        } catch (PDOException $e) {
            echo "<script> alert('Erro ao cadastrar cliente!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cliente</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php include_once 'menu_navbar.php'; ?>

    <h2>Cadastro Cliente</h2>

    <form action="cadastro_cliente.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required onkeypress="mascara(this, somentetexto)">

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required onkeypress="mascara(this, celular)" maxlength="13">

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a class="btn-voltar" href="principal.php">Voltar</a>

    <?php include_once 'rodape.php'; ?>
    
    <script src="validacoes.js"></script>
</body>
</html>