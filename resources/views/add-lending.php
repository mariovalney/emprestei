<?php include_template('templates/header'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Adicionar Empréstimo</h1>
</section>

<!-- Main content -->
<section class="content">
    <form action="<?php echo url('/adicionar'); ?>" method="POST">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="box box-primary" data-match-height="boxes">
                        <div class="box-header with-border">
                            <h3 class="box-title">O que está emprestando?</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="thing-name">Nome:</label>
                                <input type="text" class="form-control" id="thing-name" name="thing-name" placeholder="Nome/Descrição do Objeto">
                            </div>
                            <div class="form-group">
                                <label for="thing-type">Tipo:</label>
                                <select id="thing-type" name="thing-type" class="form-control select2-with-tags">
                                    <option disabled selected>-- Escolha ou adicione um novo tipo</option>
                                    <?php
                                        $types = App\Models\Thing::getAllTypes();
                                        foreach ($types as $type) :
                                    ?>
                                        <option value="<?php echo $type; ?>">
                                            <?php echo $type; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="thing-note">Notas:</label>
                                <textarea id="thing-note" name="thing-note" class="form-control" rows="4" placeholder="Observações"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="box box-primary" data-match-height="boxes">
                        <div class="box-header with-border">
                            <h3 class="box-title">Para quem está emprestando?</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="lender-name">Nome:</label>
                                <input type="text" class="form-control" id="lender-name" name="lender-name" placeholder="Nome">
                            </div>
                            <div class="form-group">
                                <label for="lender-email">E-mail:</label>
                                <input type="email" class="form-control" id="lender-email" name="lender-email" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <label for="lender-phone">Telefone:</label>
                                <input type="text" class="form-control mask-phone" id="lender-phone" name="lender-phone" placeholder="(99) 99999-9999">
                            </div>
                            <div class="form-group">
                                <label for="lending-date">Data do Emprestimo:</label>
                                <input type="text" class="form-control" id="lending-date" name="lending-date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <a href="<?php echo url('/'); ?>" type="submit" class="btn btn-danger">Voltar</a>
                    <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                </div>
            </div>
        </div>
    </form>
</section>

<?php include_template('templates/footer'); ?>
