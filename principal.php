<?php
    session_start();

    require_once 'conexao.php';

    if(!isset($_SESSION['usuario'])) {
        header ("Location: index.php");
        exit();
    }

    // OBTENDO O NOME DO PERFIL DO USUÁRIO LOGADO
    $id_perfil = $_SESSION['perfil'];

    $query_perfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";

    $stmt_perfil = $pdo -> prepare($query_perfil);
    $stmt_perfil -> bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);

    $stmt_perfil -> execute();

    $perfil = $stmt_perfil -> fetch(PDO::FETCH_ASSOC);
    $nome_perfil = $perfil['nome_perfil'];

    // DEFINIÇÃO DAS PERMISSÕES POR PERFIL
    $permissoes = [
        1 => ["Cadastrar" => ["cadastro_usuario.php", "cadastro_perfil.php", "cadastro_cliente.php", "cadastro_fornecedor.php", "cadastro_produto.php", "cadastro_funcionário.php"],
              "Buscar" => ["buscar_usuario.php", "buscar_perfil.php", "buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php", "buscar_funcionário.php"],
              "Alterar" => ["alterar_usuario.php", "alterar_perfil.php", "alterar_cliente.php", "alterar_fornecedor.php", "alterar_produto.php", "alterar_funcionário.php"],
              "Excluir" => ["excluir_usuario.php", "excluir_perfil.php", "excluir_cliente.php", "excluir_fornecedor.php", "excluir_produto.php", "excluir_funcionário.php"]
        ],

        2 => ["Cadastrar" => ["cadastro_cliente.php"],
            "Buscar" => ["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],
            "Alterar" => ["alterar_cliente.php", "alterar_fornecedor.php"]
        ],

        3 => ["Cadastrar" => ["cadastro_fornecedor.php", "cadastro_produto.php"],
            "Buscar" => ["buscar_fornecedor.php", "buscar_produto.php"],
            "Alterar" => ["alterar_fornecedor.php", "alterar_produto.php"],
            "Excluir" => ["excluir_produto.php"]
        ],

        4 => ["Cadastrar" => ["cadastro_cliente.php"],
            "Buscar" => ["buscar_produto.php"],
            "Alterar" => ["alterar_cliente.php"]
        ]
    ];

    // OBTENDO AS OPÇÕES DISPONÍVEIS PARA O PERFIL LOGADO
    $opcoes_menu = $permissoes[$id_perfil];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>

    <link rel="stylesheet" href="estilo.css">

    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <div class="saudacao">
            <h2>Seja bem-vindo(a), <?php echo $_SESSION['usuario']; ?> | Perfil: <?php echo $nome_perfil; ?></h2>
        </div>

        <div class="logout">
            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <nav>
        <ul class='menu'>
            <?php foreach ($opcoes_menu as $categoria => $arquivos): ?>
                <li class='dropdown'>
                    <a href='#'><?= $categoria ?></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($arquivos as $arquivo): ?>
                            <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_", " ", basename($arquivo, ".php"))) ?></a>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php include_once 'rodape.php'; ?>
</body>
</html>