<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$periodo = $_GET['p'] ?? 'semana';

//User
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$nomeUsuario = $stmt->fetchColumn() ?? 'Usuário';

//actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Registrar horas
    if (isset($_POST['study_hours'])) {
        $stmt = $pdo->prepare("
            INSERT INTO study_logs (user_id, subject, hours, study_date)
            VALUES (?, 'Estudo Geral', ?, ?)
        ");
        $stmt->execute([$user_id, $_POST['study_hours'], $_POST['study_date']]);
    }

    // Salvar meta
    if (isset($_POST['new_goal'])) {
        $stmt = $pdo->prepare("
            INSERT INTO goals (user_id, period, hours)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE hours = VALUES(hours)
        ");
        $stmt->execute([$user_id, $_POST['goal_period'], $_POST['new_goal']]);
    }

    // Novo objetivo
    if (isset($_POST['plan_title'])) {
        $stmt = $pdo->prepare("
            INSERT INTO plans (user_id, description, status)
            VALUES (?, ?, 'pendente')
        ");
        $stmt->execute([$user_id, $_POST['plan_title']]);
    }

    header("Location: dashboard.php?p=$periodo");
    exit;
}

// filtro de periodo
$whereData = match ($periodo) {
    'mes' => "MONTH(study_date) = MONTH(CURDATE()) AND YEAR(study_date)=YEAR(CURDATE())",
    'ano' => "YEAR(study_date)=YEAR(CURDATE())",
    default => "study_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"
};


// grafico
$stmt = $pdo->prepare("
    SELECT DATE(study_date) as rotulo, SUM(hours) total
    FROM study_logs
    WHERE user_id = ? AND $whereData
    GROUP BY DATE(study_date)
    ORDER BY study_date
");
$stmt->execute([$user_id]);
$grafico = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = array_column($grafico, 'rotulo');
$values = array_column($grafico, 'total');

// relatorio
$stmt = $pdo->prepare("
    SELECT SUM(hours) total
    FROM study_logs
    WHERE user_id = ? AND $whereData
");
$stmt->execute([$user_id]);
$totalHoras = round($stmt->fetchColumn() ?? 0, 1);

// meta
$stmt = $pdo->prepare("
    SELECT hours FROM goals
    WHERE user_id = ? AND period = ?
");
$stmt->execute([$user_id, $periodo]);
$metaDefinida = $stmt->fetchColumn() ?? 0;

$progresso = $metaDefinida > 0 ? min(($totalHoras / $metaDefinida) * 100, 100) : 0;

// planejamento
if (isset($_GET['completar'])) {
    $pdo->prepare("UPDATE plans SET status='concluido' WHERE id=? AND user_id=?")
        ->execute([(int)$_GET['completar'], $user_id]);
    header("Location: dashboard.php?p=$periodo");
    exit;
}

if (isset($_GET['excluir_plano'])) {
    $pdo->prepare("DELETE FROM plans WHERE id=? AND user_id=?")
        ->execute([(int)$_GET['excluir_plano'], $user_id]);
    header("Location: dashboard.php?p=$periodo");
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, description, status
    FROM plans
    WHERE user_id = ?
    ORDER BY id DESC
");
$stmt->execute([$user_id]);
$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronos Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
     <link rel="icon" href="../assets/img/image.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="<?= ($_COOKIE['theme'] ?? '') === 'light' ? 'light-theme' : '' ?>">
<header>
    <h2>CRONOS <span>DASHBOARD</span></h2>
    <div class="user-menu">
        <button id="theme-toggle" class="btn-secondary">Mudar Tema</button>
        <span>Olá, <strong><?= htmlspecialchars($nomeUsuario) ?></strong></span>
        <a href="logout.php" class="btn-secondary">Sair</a>
    </div>
</header>

<div class="main-grid">
    <section class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Produtividade</h3>
            <div class="filter-group">
                <a href="?p=semana" class="btn-mini <?= $periodo=='semana'?'active':'' ?>">Semana</a>
                <a href="?p=mes" class="btn-mini <?= $periodo=='mes'?'active':'' ?>">Mês</a>
                <a href="?p=ano" class="btn-mini <?= $periodo=='ano'?'active':'' ?>">Ano</a>
            </div>
        </div>
        <div style="height:250px;"><canvas id="weeklyChart"></canvas></div>
        <button class="btn-action" onclick="abrirModal('modalHoras')" style="margin-top:15px;">+ REGISTRAR ESTUDO</button>
    </section>

    <section class="card">
        <h3>Relatório & Metas</h3>
        <div class="report-item"><span>Total Estudado:</span> <strong><?= $totalHoras ?>h</strong></div>
        
        <div style="margin-top:20px;">
            <div style="display:flex; justify-content:space-between; font-size:13px;">
                <span>Meta (<?= ucfirst($periodo) ?>):</span>
                <strong><?= $totalHoras ?>/<?= $metaDefinida ?>h</strong>
            </div>
            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:<?= $progresso ?>%"></div></div>
            <small style="color:var(--text-sub)">Progresso: <?= round($progresso) ?>%</small>
        </div>
        
        <button class="btn-secondary" onclick="abrirModal('modalMeta')" style="width:100%; margin-top:15px;">DEFINIR META</button>
    </section>

  <section class="card">
    <h3>Planejamento</h3>
    <ul style="list-style:none; margin-bottom:15px;">
        <?php if(empty($plans)): ?>
            <li style="color:var(--text-sub);">Nenhum objetivo cadastrado.</li>
        <?php else: ?>
            <?php foreach($plans as $p): ?>
                <li style="padding:10px 0; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                    <span style="<?= $p['status'] === 'concluido' ? 'text-decoration: line-through; color: var(--text-sub);' : '' ?>">
                        <?= htmlspecialchars($p['description']) ?>
                    </span>

                    <div style="display:flex; gap:10px;">
                        <?php if($p['status'] !== 'concluido'): ?>
                            <a href="?completar=<?= $p['id'] ?>" title="Concluir" style="color:#00ff88; text-decoration:none;">✓</a>
                        <?php endif; ?>
                        <a href="?excluir_plano=<?= $p['id'] ?>" title="Excluir" style="color:#ff4d4d; text-decoration:none;">✕</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <button class="btn-action" onclick="abrirModal('modalPlan')">NOVO OBJETIVO</button>
</section>

</div>

<div id="modalHoras" class="modal"><div class="modal-content card">
    <h3>Registrar Estudo</h3>
    <form method="POST">
        <input type="date" name="study_date" class="dark-input" value="<?= date('Y-m-d') ?>" required>
        <input type="number" name="study_hours" step="0.5" class="dark-input" placeholder="Horas" required>
        <button type="submit" class="btn-action">Salvar</button>
        <button type="button" class="btn-secondary" onclick="fecharModal('modalHoras')">Cancelar</button>
    </form>
</div></div>

<div id="modalMeta" class="modal"><div class="modal-content card">
    <h3>Definir Meta (<?= ucfirst($periodo) ?>)</h3>
    <form method="POST">
        <input type="number" name="new_goal" class="dark-input" placeholder="Horas desejadas" required>
        <input type="hidden" name="goal_period" value="<?= $periodo ?>">
        <button type="submit" class="btn-action">Definir</button>
        <button type="button" class="btn-secondary" onclick="fecharModal('modalMeta')">Cancelar</button>
    </form>
</div></div>

<div id="modalPlan" class="modal"><div class="modal-content card">
    <h3>Novo Objetivo</h3>
    <form method="POST">
        <input type="text" name="plan_title" class="dark-input" placeholder="Ex: Terminar curso de PHP" required>
        <button type="submit" class="btn-action">Adicionar</button>
        <button type="button" class="btn-secondary" onclick="fecharModal('modalPlan')">Cancelar</button>
    </form>
</div></div>

<script>
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{ label: 'Horas', data: <?= json_encode($values) ?>, backgroundColor: '#00d4ff', borderRadius: 5 }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

</script>
<script src="../assets/js/dashboard.js"></script>
</body>
</html>