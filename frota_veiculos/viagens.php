<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);
include 'includes/header.php';
?>

<h1 style="margin-top:40px; text-align: center;">Viagens</h1>
<a class="btn btn-primary mb-2" href="nova_viagem.php" style="margin-left: 75px;">Nova Viagem</a>
<table class="table table-bordered table-striped" style="width:90%; margin-left:auto; margin-right:auto; margin-top:20px;">
    <thead>
        <tr>
            <th>ID Viagem</th>
            <th>ID Veiculo</th>
            <th>Data/Hora</th>
            <th>Destino</th>
            <th>KM Inicial</th>
            <th>KM Final</th>
            <th>Finalidade</th>
            <th>Colaborador</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM viagens");
        while ($viagens = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_viagens_formatada = date('d/m/Y', strtotime($viagens['data_hora']));
            echo "<tr>
                    <td>{$viagens['id_agendamento']}</td>
                    <td>{$viagens['id_veiculo']}</td>
                    <td>{$data_viagens_formatada}</td>
                    <td>{$viagens['destino']}</td>
                    <td>{$viagens['quilometragem_inicial']}</td>
                    <td>{$viagens['quilometragem_final']}</td>
                    <td>{$viagens['finalidade']}</td>
                    <td>{$viagens['colaborador_responsavel']}</td>
                    <td>{$viagens['status']}</td>
                    <td>
                        <a href='editar_viagem.php?id_agendamento={$viagens['id_agendamento']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='deletar_viagem.php?id_agendamento={$viagens['id_agendamento']}' class='btn btn-danger btn-sm'>Deletar</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>