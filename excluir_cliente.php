<?php
    session_start();

    require_once 'conexao.php';

    if ($_SESSION['perfil'] != 1) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    $usuarios = [];

    $query = "SELECT * FROM cliente";

    $stmt = $pdo -> prepare($query);
    $stmt -> execute();
    $usuarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // EXCLUI O USUARIO DO BANCO DE DADOS
        $query = "DELETE FROM cliente WHERE id_cliente = :id";

        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        
        if($stmt -> execute()) {
            echo "<script> alert('Cliente excluido com sucesso!'); window.location.href='buscar_cliente.php'; </script>";
        } else {
            echo "<script> alert('Erro ao excluir cliente!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php include_once 'menu_navbar.php'; ?>

    <h2>Excluir Cliente</h2>

    <?php if(!empty($usuarios)): ?>
        <div class="tabela-container">
            <table class="tabela">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereco</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id_cliente']) ?></td>
                        <td><?= htmlspecialchars($usuario['nome_cliente']) ?></td>
                        <td><?= htmlspecialchars($usuario['endereco']) ?></td>
                        <td><?= htmlspecialchars($usuario['telefone']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td>
                            <a class="btn-excluir" href="excluir_cliente.php?id=<?= htmlspecialchars($usuario['id_cliente']) ?>" onclick="return confirm('Você tem certeza que deseja excluir este cliente?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <a class="btn-voltar" href="principal.php">Voltar</a>

    <?php include_once 'rodape.php'; ?>
</body>
</html>