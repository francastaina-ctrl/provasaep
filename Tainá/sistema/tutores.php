<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tutor'])) {
    $id = $_POST['id_tutor'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    
    $sql = "UPDATE tutores SET nome = :nome, telefone = :telefone WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'id' => $id]);
    $msg = "Atualizado com sucesso!";
}

$termo = $_GET['busca'] ?? '';
$sql = "SELECT id, nome, CAST(AES_DECRYPT(cpf, 'chave_secreta_lgpd') AS CHAR) AS cpf, telefone FROM tutores WHERE nome LIKE :termo";
$stmt = $pdo->prepare($sql);
$stmt->execute(['termo' => "%$termo%"]);
$tutores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Tutores</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; margin: 0; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; font-size: 20px; margin-bottom: 15px; }
        .voltar { color: #3498db; text-decoration: none; font-size: 14px; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        .voltar:hover { text-decoration: underline; }
        form.busca { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 8px; border: 1px solid #dcdde1; border-radius: 4px; }
        button { background: #2ecc71; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #27ae60; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f8f9fa; color: #2c3e50; text-align: left; padding: 10px; font-size: 13px; border-bottom: 2px solid #dcdde1; }
        td { padding: 10px; border-bottom: 1px solid #ecf0f1; font-size: 13px; }
        td input[type="text"] { width: 100%; padding: 5px; }
        .sucesso { background: #d4efdf; color: #145a32; padding: 8px; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Lista de Tutores</h2>

        <?php if (!empty($msg)): ?>
            <div class="sucesso"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="GET" class="busca">
            <input type="text" name="busca" placeholder="Pesquisar por nome..." value="<?php echo htmlspecialchars($termo); ?>">
            <button type="submit" style="background: #3498db;">Buscar</button>
        </form>

        <table>
            <tr>
                <th>Nome</th>
                <th>CPF (LGPD)</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($tutores as $t): ?>
            <tr>
                <form method="POST">
                    <input type="hidden" name="id_tutor" value="<?php echo $t['id']; ?>">
                    <td><input type="text" name="nome" value="<?php echo htmlspecialchars($t['nome']); ?>"></td>
                    <td><?php echo htmlspecialchars($t['cpf']); ?></td>
                    <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($t['telefone']); ?>"></td>
                    <td><button type="submit">Salvar</button></td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>