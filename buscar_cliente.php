<?php
    session_start();

    require_once 'conexao.php';

    if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    $usuarios = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['busca'])) {
        $busca = trim($_POST['busca']);

        if (is_numeric($busca)) {
            $query = "SELECT * FROM cliente WHERE id_cliente = :id";

            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':id', $busca, PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM cliente WHERE nome_cliente LIKE :nome";

            $stmt = $pdo -> prepare($query);
            $stmt -> bindValue(':nome', "$busca%", PDO::PARAM_STR);
        }
    } else {
        $query = "SELECT * FROM cliente";

        $stmt = $pdo -> prepare($query);
    }

    $stmt -> execute();
    $usuarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php include_once 'menu_navbar.php'; ?>

    <h2>Buscar Cliente</h2>

    <form action="buscar_cliente.php" method="POST">
        <label for="buscar">Digite o ID ou NOME do cliente:</label>
        <input type="text" name="busca" id="busca">

        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($usuarios)): ?>
        <div class='tabela-container'>
            <table class="tabela">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
                
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id_cliente']); ?></td>
                        <td><?= htmlspecialchars($usuario['nome_cliente']); ?></td>
                        <td><?= htmlspecialchars($usuario['endereco']); ?></td>
                        <td><?= htmlspecialchars($usuario['telefone']); ?></td>
                        <td><?= htmlspecialchars($usuario['email']); ?></td>
                        <td>
                            <a class="btn-a" href="alterar_cliente.php?id=<?=$usuario['id_cliente'];?>">Alterar</a>
                            <a class="btn-excluir" href="excluir_cliente.php?id=<?= htmlspecialchars($usuario['id_cliente']); ?>" onclick="return confirm('Você tem certeza que deseja excluí-lo?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php else: ?>
        <p class="aviso">Nenhum cliente cadastrado!</p>
    <?php endif; ?>
</body>
</html>