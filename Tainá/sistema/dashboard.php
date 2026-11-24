<?php
session_start();
if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Painel - Clínica Veterinária</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; margin: 0; padding: 30px; }
        .container { max-width: 700px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h1 { color: #2c3e50; font-size: 24px; margin-bottom: 5px; }
        p { color: #7f8c8d; margin-bottom: 25px; }
        .menu { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px; margin-bottom: 25px; }
        .menu li a { display: block; background: #ecf0f1; color: #2c3e50; padding: 12px 15px; border-radius: 4px; text-decoration: none; font-weight: bold; transition: 0.2s; }
        .menu li a:hover { background: #3498db; color: #fff; }
        .sair { color: #e74c3c; text-decoration: none; font-size: 14px; font-weight: bold; }
        .sair:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></h1>
        <p>Escolha uma das opções abaixo:</p>

        <ul class="menu">
            <li><a href="tutores.php">Gerenciar Tutores</a></li>
            <li><a href="pets.php">Cadastrar Pets</a></li>
            <li><a href="agendamentos.php">Gerenciar Agendamentos</a></li>
        </ul>

        <a href="logout.php" class="sair">&larr; Terminar Sessão</a>
    </div>
</body>
</html>