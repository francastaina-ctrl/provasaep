<?php
require_once 'conexao.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agendamento_id'])) {
    $id = $_POST['agendamento_id'];
    $nova_data = $_POST['nova_data'];

    $sql = "UPDATE agendamentos SET data_agendamento = :nova_data WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nova_data' => $nova_data, 'id' => $id]);
    $msg = "Data atualizada!";
}

$sql = "SELECT 
            a.id AS agendamento_id,
            a.data_agendamento,
            a.horario,
            a.motivo,
            p.nome AS nome_pet,
            p.especie,
            t.nome AS nome_tutor,
            t.telefone
        FROM agendamentos a
        INNER JOIN pets p ON a.pet_id = p.id
        INNER JOIN tutores t ON p.tutor_id = t.id
        ORDER BY a.data_agendamento ASC, a.horario ASC";
$stmt = $pdo->query($sql);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; margin: 0; padding: 30px; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; font-size: 20px; margin-bottom: 15px; }
        .voltar { color: #3498db; text-decoration: none; font-size: 14px; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        .voltar:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f8f9fa; color: #2c3e50; text-align: left; padding: 10px; font-size: 13px; border-bottom: 2px solid #dcdde1; }
        td { padding: 10px; border-bottom: 1px solid #ecf0f1; font-size: 13px; }
        input[type="date"] { padding: 5px; border: 1px solid #dcdde1; border-radius: 4px; }
        button { background: #2ecc71; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #27ae60; }
        .sucesso { background: #d4efdf; color: #145a32; padding: 8px; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="voltar">&larr; Voltar ao Menu</a>
        <h2>Agendamentos</h2>

        <?php if (!empty($msg)): ?>
            <div class="sucesso"><?php echo $msg; ?></div>
        <?php endif; ?>

        <table>
            <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Motivo</th>
                <th>Pet</th>
                <th>Tutor</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($agendamentos as $ag): ?>
            <tr>
                <form method="POST">
                    <input type="hidden" name="agendamento_id" value="<?php echo $ag['agendamento_id']; ?>">
                    <td><input type="date" name="nova_data" value="<?php echo $ag['data_agendamento']; ?>"></td>
                    <td><?php echo $ag['horario']; ?></td>
                    <td><?php echo htmlspecialchars($ag['motivo']); ?></td>
                    <td><?php echo htmlspecialchars($ag['nome_pet'] . " (" . $ag['especie'] . ")"); ?></td>
                    <td><?php echo htmlspecialchars($ag['nome_tutor'] . " - " . $ag['telefone']); ?></td>
                    <td><button type="submit">Salvar</button></td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>