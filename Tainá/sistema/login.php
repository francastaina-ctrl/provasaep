<?php
session_start();
require_once 'conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && isset($usuario['senha'])) {
        if ($usuario['senha'] === '123456' && $senha === '123456') { 
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: dashboard.php');
            exit;
        } else {
            $erro = "E-mail ou palavra-passe incorretos!";
        }
    } else {
        $erro = "E-mail ou palavra-passe incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Login - Clínica Veterinária</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); width: 100%; max-width: 360px; }
        h2 { color: #2c3e50; margin-bottom: 5px; font-size: 22px; }
        p { color: #7f8c8d; font-size: 13px; margin-bottom: 20px; }
        label { display: block; font-size: 13px; font-weight: bold; color: #34495e; margin-bottom: 5px; }
        input { width: 100%; padding: 10px; border: 1px solid #dcdde1; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box; }
        button { width: 100%; background: #3498db; color: #fff; border: none; padding: 10px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #2980b9; }
        .erro { background: #fadbd8; color: #78281f; padding: 8px; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Clínica Veterinária</h2>
        <p>Faça login para continuar</p>

        <?php if (!empty($erro)): ?>
            <div class="erro"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>E-mail:</label>
            <input type="email" name="email" placeholder="ana@clinica.com" required>

            <label>Palavra-passe:</label>
            <input type="password" name="senha" placeholder="******" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>