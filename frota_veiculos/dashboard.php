<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);
include 'includes/header.php';
?>

<!-- ======= GRÁFICOS ======= -->
<div style="width: 50%; margin: 50px auto;">
    <h4 class="mb-4">Relatórios Financeiros da Frota</h4>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
        <div style="flex: 1 1 400px; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h5 class="text-center">Custo total de combustível (por mês)</h5>
            <canvas id="graficoCombustivel"></canvas>
        </div>

        <div style="flex: 1 1 400px; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h5 class="text-center">Custo total de manutenção (por mês)</h5>
            <canvas id="graficoManutencao"></canvas>
        </div>
    </div>
</div>

<?php
// ====== Consulta para gráfico de combustível ======
$sqlCombustivel = "
    SELECT DATE_FORMAT(data_abastecimento, '%Y-%m') AS mes, SUM(custo) AS total
    FROM registro_abastecimentos
    GROUP BY mes
    ORDER BY mes ASC";
$combustivelData = $pdo->query($sqlCombustivel)->fetchAll(PDO::FETCH_ASSOC);

// ====== Consulta para gráfico de manutenção ======
$sqlManutencao = "
    SELECT DATE_FORMAT(data_manutencao, '%Y-%m') AS mes, SUM(custo) AS total
    FROM registro_de_manutencoes_preventivas
    GROUP BY mes
    ORDER BY mes ASC";
$manutencaoData = $pdo->query($sqlManutencao)->fetchAll(PDO::FETCH_ASSOC);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados do gráfico de combustível
    const combustivelLabels = <?= json_encode(array_column($combustivelData, 'mes')) ?>;
    const combustivelValores = <?= json_encode(array_column($combustivelData, 'total')) ?>;

    const ctxComb = document.getElementById('graficoCombustivel').getContext('2d');
    new Chart(ctxComb, {
        type: 'bar',
        data: {
            labels: combustivelLabels,
            datasets: [{
                label: 'Custo (R$)',
                data: combustivelValores,
                borderWidth: 1,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'R$' } },
                x: { title: { display: true, text: 'Mês' } }
            }
        }
    });

    // Dados do gráfico de manutenção
    const manutencaoLabels = <?= json_encode(array_column($manutencaoData, 'mes')) ?>;
    const manutencaoValores = <?= json_encode(array_column($manutencaoData, 'total')) ?>;

    const ctxManut = document.getElementById('graficoManutencao').getContext('2d');
    new Chart(ctxManut, {
        type: 'bar',
        data: {
            labels: manutencaoLabels,
            datasets: [{
                label: 'Custo (R$)',
                data: manutencaoValores,
                borderWidth: 1,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'R$' } },
                x: { title: { display: true, text: 'Mês' } }
            }
        }
    });
</script>

<!-- ======= TABELAS EXISTENTES ======= -->
<div style="max-width: 85%; margin: 100px auto">
    <h5>Últimas viagens</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID viagem</th>
                <th>ID veiculo</th>
                <th>Data</th>
                <th>KM inicial</th>
                <th>KM final</th>
                <th>KM rodados</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlUltimas = "
                SELECT *, (quilometragem_final - quilometragem_inicial) AS km_rodados 
                FROM viagens ORDER BY data_hora DESC LIMIT 5";
            $resultUltimas = $pdo->query($sqlUltimas);
            while ($row = $resultUltimas->fetch(PDO::FETCH_ASSOC)):
            ?>
                <tr>
                    <td><?= $row['id_agendamento'] ?></td>
                    <td><?= $row['id_veiculo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_hora'])) ?></td>
                    <td><?= $row['quilometragem_inicial'] ?></td>
                    <td><?= $row['quilometragem_final'] ?></td>
                    <td><?= $row['km_rodados'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div style="max-width: 85%; margin: 100px auto">
    <h5>Últimos abastecimentos</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID abastecimento</th>
                <th>ID veiculo</th>
                <th>Data</th>
                <th>Quantidade de litros</th>
                <th>Custo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlUltimas = "SELECT * FROM registro_abastecimentos ORDER BY data_abastecimento DESC LIMIT 5";
            $resultUltimas = $pdo->query($sqlUltimas);
            while ($row = $resultUltimas->fetch(PDO::FETCH_ASSOC)):
            ?>
                <tr>
                    <td><?= $row['id_abastecimento'] ?></td>
                    <td><?= $row['id_veiculo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_abastecimento'])) ?></td>
                    <td><?= $row['quantidade_litros'] ?></td>
                    <td>R$ <?= number_format($row['custo'], 2, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div style="max-width: 85%; margin: 100px auto">
    <h5>Últimas manutenções</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID manutenção</th>
                <th>ID veiculo</th>
                <th>Data</th>
                <th>Tipo de serviço</th>
                <th>Custo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlUltimas = "SELECT * FROM registro_de_manutencoes_preventivas ORDER BY data_manutencao DESC LIMIT 5";
            $resultUltimas = $pdo->query($sqlUltimas);
            while ($row = $resultUltimas->fetch(PDO::FETCH_ASSOC)):
            ?>
                <tr>
                    <td><?= $row['id_manutencao'] ?></td>
                    <td><?= $row['id_veiculo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_manutencao'])) ?></td>
                    <td><?= $row['tipo_servico'] ?></td>
                    <td>R$ <?= number_format($row['custo'], 2, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
