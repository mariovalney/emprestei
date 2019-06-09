<?php include_template('templates/header'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Adicionar Empréstimo</h1>
</section>

<!-- Main content -->
<section class="content">
    <form action="<?php echo url('/adicionar'); ?>" method="POST">
        <div class="box-body">
            <?php include_template('templates/messages'); ?>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="box box-primary" data-match-height="boxes">
                        <div class="box-header with-border">
                            <h3 class="box-title">O que está emprestando?</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <?php FormBuilder::label('Nome:', 'thing-name'); ?>
                                <?php FormBuilder::input('text', 'thing-name', 'name', true, ['class' => 'form-control', 'placeholder' => 'Nome/Descrição do Objeto']); ?>
                            </div>
                            <div class="form-group">
                                <?php FormBuilder::label('Tipo:', 'thing-type'); ?>
                                <?php FormBuilder::select(App\Models\Thing::getAllTypes(), 'thing-type', 'type', true, ['class' => 'form-control select2-with-tags', 'data-placeholder' => '-- Escolha ou adicione um novo tipo']); ?>
                            </div>
                            <div class="form-group">
                                <?php FormBuilder::label('Notas:', 'thing-note'); ?>
                                <?php FormBuilder::textarea('thing-note', 'note', true, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Observações']); ?>
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
                                <?php FormBuilder::label('Nome:', 'lender-name'); ?>
                                <?php FormBuilder::input('text', 'lender-name', 'name', true, ['class' => 'form-control', 'placeholder' => 'Nome']); ?>
                            </div>
                            <div class="form-group">
                                <?php FormBuilder::label('E-mail:', 'lender-email'); ?>
                                <?php FormBuilder::input('text', 'lender-email', 'email', false, ['class' => 'form-control', 'placeholder' => 'E-mail']); ?>
                            </div>
                            <div class="form-group">
                                <?php FormBuilder::label('Telefone:', 'lender-phone'); ?>
                                <?php FormBuilder::input('text', 'lender-phone', 'phone', false, ['class' => 'form-control mask-phone', 'placeholder' => '(99) 99999-9999']); ?>
                            </div>
                            <div class="form-group">
                                <?php FormBuilder::label('Data do Emprestimo:', 'lending-date'); ?>
                                <?php FormBuilder::input('text', 'lending-date', 'date', true, ['class' => 'form-control']); ?>
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
