<?php
require_once('../config/conn.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Buscar os dados do usuário no banco de dados
$sql = "SELECT * FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.min.js"></script>
    <script>
        $(function () {
            $('#formulario').ajaxForm({
                dataType: 'json',
                success: function (retorno) {
                    if (retorno.sucesso) {
                        $('#mensagem').attr('class', 'alert alert-success').html(retorno.mensagem);
                        $('#fotoPerfil').attr('src', 'imagem.php?id=' + <?= $user_id ?> + '&nocache=' + new Date().getTime());
                    } else {
                        $('#mensagem').attr('class', 'alert alert-danger').html(retorno.mensagem);
                    }
                },
                error: function () {
                    $('#mensagem').attr('class', 'alert alert-danger').html('Erro ao enviar a imagem.');
                }
            });
        });
    </script>
</head>

<body>

<div class="perfil-container">
    <div class="perfil-foto">
        <form id="formulario" action="../ajax/salvar.php" method="post" enctype="multipart/form-data">
            <img id="fotoPerfil" src="imagem.php?id=<?= $user_id ?>" alt="Foto de Perfil">
            <br><br>
            <label for="foto">Inserir Foto</label>
            <input type="file" name="foto" class="form-control" />
            <button class="btn btn-primary btn-sm" style="margin-top:10px;" type="submit">Salvar Foto</button>
            <div id="mensagem"></div>
        </form>
    </div>

    <div class="perfil-formulario">
        <form action="salvar_perfil.php" method="POST">
            <label>Nome: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="text" name="nome" value="<?= htmlspecialchars($user['name'] ?? '') ?>">

            <label>Email: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">

            <label>Data de Nascimento: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="date" name="data_nascimento" value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>">

            <label>Senha: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="password" name="senha">

            <label style="margin-top:20px;">Sobre mim:</label>
            <textarea name="sobre_mim" placeholder="Escreva algo sobre você..."><?= htmlspecialchars($user['sobre_mim'] ?? '') ?></textarea>

            <button class="btn btn-primary btn-sm" style="margin-top:10px;" type="submit">Salvar Alterações</button>
            <br>
            <a href="index.php"><button class="btn btn-primary btn-sm" style="margin-top:10px;" type="button" >Voltar ao Início</button></a>
        </form>
    </div>
</div>

</body>
</html>
