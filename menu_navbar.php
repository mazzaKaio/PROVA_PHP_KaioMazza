<?php
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
            "Buscar" => ["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],
            "Alterar" => ["alterar_fornecedor.php", "alterar_produto.php"],
            "Excluir" => ["excluir_produto.php"]
        ],

        4 => ["Cadastrar" => ["cadastro_cliente.php"],
            "Buscar" => ["buscar_produto.php"],
            "Alterar" => ["alterar_cliente.php"]
        ]
    ];

    $id_perfil = $_SESSION['perfil'];

    // OBTENDO AS OPÇÕES DISPONÍVEIS PARA O PERFIL LOGADO
    $opcoes_menu = $permissoes[$id_perfil];

    ?>
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

            <li>
                <a href="principal.php">Menu Principal</a>
            </li>

            <li>
                <a href="logout.php" onclick="return confirm('Você tem certeza que deseja SAIR da página?')">Logout</a>
            </li>
        </ul>
    </nav>
    <?php
?>