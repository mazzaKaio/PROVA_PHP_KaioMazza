<?php
    session_start();

    require_once 'conexao.php';

    if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    $usuario = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['busca'])) {
            $busca = trim($_POST['busca']);

            if (is_numeric($busca)) {
                $query = "SELECT * FROM cliente WHERE id_cliente = :id";

                $stmt = $pdo -> prepare($query);
                $stmt -> bindParam(':id', $busca, PDO::PARAM_INT);
            } else {
                $query = "SELECT * FROM cliente WHERE nome_cliente LIKE :nome";

                $stmt = $pdo -> prepare($query);
                $stmt -> bindValue(":nome", "$busca%", PDO::PARAM_STR);
            }

            $stmt -> execute();
            $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                echo "<script> alert('Cliente não encontrado!'); </script>";
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!empty($_GET['id'])) {
            $id = trim($_GET['id']);
    
            $query = "SELECT * FROM cliente WHERE id_cliente = :id";
    
            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);

            $stmt -> execute();
            $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cliente</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php include_once 'menu_navbar.php'; ?>

    <h2>Alterar Cliente</h2>

    <form action="alterar_cliente.php" method="POST">
        <label for="busca">Digite o ID ou NOME do cliente para alteração:</label>
        <input type="text" name="busca" id="busca">

        <button type="submit">Buscar</button>
    </form>

    <?php if(!empty($usuario)): ?>
        <form action="processa_alteracao_cliente.php" method="POST">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?= htmlspecialchars($usuario['id_cliente']) ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome_cliente']) ?>" onkeypress="mascara(this, somentetexto)" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($usuario['endereco']) ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" onkeypress="mascara(this, celular)" maxlength="13" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <button type="submit">Atualizar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <a class="btn-voltar" href="principal.php">Voltar</a>

    <script src="validacoes.js"></script>
</body>
</html>