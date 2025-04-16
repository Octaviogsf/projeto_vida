<?php
require_once('../config/conn.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // ID do usuário logado

// Buscar os dados do usuário no banco de dados
$sql = "SELECT * FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

// Verificar se o usuário foi encontrado
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.min.js"></script>

    <style>
        body {
            background-color: #f4f4f4;
        }

        .perfil-container {
            display: flex;
            max-width: 960px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .perfil-foto {
            width: 250px;
            background-color: #162136;
            color: white;
            text-align: center;
            padding: 30px 20px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .perfil-foto img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            background-color: white;
        }

        .perfil-formulario {
            flex: 1;
            background-color: #162136;
            color: white;
            padding: 30px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .perfil-formulario label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        .perfil-formulario input[type="text"],
        .perfil-formulario input[type="email"],
        .perfil-formulario input[type="date"],
        .perfil-formulario input[type="password"],
        .perfil-formulario textarea {
            width: 100%;
            background: white;
            color: black;
            border: none;
            padding: 8px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .perfil-formulario textarea {
            height: 150px;
            resize: none;
        }

        .icone-editar {
            float: right;
            cursor: pointer;
            color: white;
        }

        .alert {
            margin-top: 10px;
        }
    </style>

    <script>
        $(function () {
            $('#formulario').ajaxForm({
                dataType: 'json',
                success: function (retorno) {
                    if (retorno.sucesso) {
                        $('#mensagem').attr('class', 'alert alert-success').html(retorno.mensagem);
                        $('#fotoPerfil').attr('src', 'imagem.php?nocache=' + new Date().getTime()); // Força o recarregamento da imagem
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
            <!-- Foto de perfil -->
            <img id="fotoPerfil" src="imagem.php?user_id=<?= $user_id ?>" alt="Foto de Perfil">
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
            <input type="text" name="nome" value="<?= htmlspecialchars($user['name']) ?>">

            <label>Email: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

            <label>Data de Nascimento: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="date" name="data_nascimento" value="<?= htmlspecialchars($user['birthdate']) ?>">

            <label>Senha: <span class="glyphicon glyphicon-edit icone-editar"></span></label>
            <input type="password" name="senha">

            <label style="margin-top:20px;">Sobre mim:</label>
            <textarea name="sobre_mim" placeholder="Escreva algo sobre você..."><?= htmlspecialchars($user['sobre_mim']) ?></textarea>

            <button class="btn btn-primary btn-sm" style="margin-top:10px;" type="submit">Salvar Alterações</button>
        </form>
    </div>
</div>

</body>
</html>

