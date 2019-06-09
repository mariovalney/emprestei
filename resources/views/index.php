<?php include_template('templates/header'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Empréstimos</h1>
</section>

<!-- Main content -->
<section class="content">
    <?php include_template('templates/messages'); ?>

    <div class="box">
        <div class="box-body">
            <table id="lendings" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Objeto</th>
                        <th>Quem pegou?</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th class="actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $lendings = App\Models\Lending::all();
                        foreach ($lendings as $lending) {
                            echo '<tr>';
                            echo '<td>' . $lending->ID . '</td>';
                            echo '<td>' . $lending->getThing()->name ?? '-' . '</td>';
                            echo '<td>' . $lending->getLender()->name ?? '-' . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($lending->date_start)) . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($lending->date_end)) . '</td>';
                            echo '<td class="actions"><a href="' . url('emprestimo/' . $lending->ID) . '" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            echo '<a class="confirm-before btn btn-danger" href="#" data-href="' . url('emprestimo/' . $lending->ID) . '/remover"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include_template('templates/footer'); ?>
