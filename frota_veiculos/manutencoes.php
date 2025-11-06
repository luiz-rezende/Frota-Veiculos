<?php
require 'includes/config.php';
require 'includes/functions.php';
check_login($pdo);
include 'includes/header.php';
?>

<h1 style="margin-left: 230px; margin-top:40px;">Registro de Manutenções</h1>
<a class="btn btn-primary mb-2" href="nova_manutencao.php" style="margin-left: 230px;">Nova Manutenção</a>
<table class="table table-bordered table-striped" style="width:70%; margin-left:auto; margin-right:auto;">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Veiculo</th>
            <th>Data</th>
            <th>Tipo de Serviço</th>
            <th>Custo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM registro_de_manutencoes_preventivas");
        while ($registro_de_manutencoes_preventivas = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_manutencao_formatada = date('d/m/Y', strtotime($registro_de_manutencoes_preventivas['data_manutencao']));
            echo "<tr>
                    <td>{$registro_de_manutencoes_preventivas['id_manutencao']}</td>
                    <td>{$registro_de_manutencoes_preventivas['id_veiculo']}</td>
                    <td>{$data_manutencao_formatada}</td>
                    <td>{$registro_de_manutencoes_preventivas['tipo_servico']}</td>
                    <td>{$registro_de_manutencoes_preventivas['custo']}</td>
                    <td>
                        <a href='editar_manutencao.php?id={$registro_de_manutencoes_preventivas['id_manutencao']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='deletar_manutencao.php?id={$registro_de_manutencoes_preventivas['id_manutencao']}' class='btn btn-danger btn-sm'>Deletar</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>