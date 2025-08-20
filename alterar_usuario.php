<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSAO DE adm
    if($_SESSION['perfil'] != 1) {
        echo "<script> alert('Acesso Negado!'); window.location.href=principal.php; </script>";
        exit();
    }

    // INCIALIZA AS VARIAVEIS
    $usuario = null;

    // SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO id OU PELO nome
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['busca_usuario'])) {
            $busca = trim($_POST['busca_usuario']);

            // VERIFICA SE A BUSCA É UM id OU UM nome
            if(is_numeric($busca)) {
                $query = "SELECT * FROM usuario WHERE id_usuario = :busca";

                $stmt = $pdo -> prepare($query);
                $stmt -> bindParam(":busca", $busca, PDO::PARAM_INT);
            } else {
                $query = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";

                $stmt = $pdo -> prepare($query);
                $stmt -> bindValue(":busca_nome", $busca, PDO::PARAM_STR);
            }

            $stmt -> execute();
            $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

            // SE O USUARIO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
            if(!$usuario) {
                echo "<script> alert('Usuário não encontrado!'); </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>