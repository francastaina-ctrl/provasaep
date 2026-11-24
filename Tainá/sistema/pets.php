<?php
require_once 'conexao.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $tutor_id = $_POST['tutor_id'];

    $sql = "INSERT INTO pets (nome, especie, raca, idade, tutor_id) VALUES (:nome, :especie, :raca, :idade, :tutor_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'especie' => $especie, 'raca' => $raca, 'idade' => $idade, 'tutor_id' => $tutor_id]);
    $msg = "Pet cadastrado com sucesso!";
}

$tutores = $pdo->query("SELECT id, nome FROM tutores")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pet</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; margin: 0; padding: 30px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; font-size: 20px; margin-bottom: 15px; }
        .voltar { color: #3498db; text-decoration: none; font-size: 14px; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        .voltar:hover { text-decoration: underline; }
        label { display: block; font-size: 13px; font-weight: bold; color: #34495e; margin-bottom: 5px; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #dcdde1; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: #2ecc71; color: #fff; border: none; padding: 10px; border-radius: 4px; font-weight: bold; cursor: pointer; margin-top: 20px; }
        button:hover { background: #27ae60; }
        .sucesso { background: #d4efdf; color: #145a32; padding: 8px; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Novo Pet</h2>

        <?php if (!empty($msg)): ?>
            <div class="sucesso"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Espécie:</label>
            <input type="text" name="especie" placeholder="Ex: Cão, Gato" required>

            <label>Raça:</label>
            <input type="text" name="raca">

            <label>Idade:</label>
            <input type="number" name="idade">

            <label>Tutor:</label>
            <select name="tutor_id" required>
                <option value="">Selecione um tutor</option>
                <?php foreach ($tutores as $t): ?>
                    <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['nome']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>