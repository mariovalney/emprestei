<div class="box-body">
    <?php include_template('templates/messages'); ?>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="box box-primary" data-match-height="boxes">
                <div class="box-header with-border">
                    <h3 class="box-title">O que está emprestando?</h3>
                </div>
                <?php
                    if (! empty($lending) && ! empty($lending->thing_id)) {
                        $model = App\Models\Thing::find($lending->thing_id);
                        FormBuilder::model($model);
                    }
                ?>
                <div class="box-body">
                    <div class="form-group">
                        <?php FormBuilder::label('Nome:', 'thing-name'); ?>
                        <?php FormBuilder::input('text', 'thing-name', 'name', true, ['class' => 'form-control', 'placeholder' => 'Nome/Descrição do Objeto']); ?>
                    </div>
                    <div class="form-group">
                        <?php FormBuilder::label('Tipo:', 'thing-type'); ?>
                        <?php
                            $selected = Request::input('thing-type');
                            $options = App\Models\Thing::getAllTypes();

                            if (! empty($selected) && ! in_array($selected, array_keys($options))) {
                                array_unshift($options, $selected);
                            }

                            FormBuilder::select($options, 'thing-type', 'type', false, ['class' => 'form-control select2-with-tags', 'data-placeholder' => '-- Escolha ou adicione um novo tipo']);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php FormBuilder::label('Notas:', 'thing-note'); ?>
                        <?php FormBuilder::textarea('thing-note', 'note', false, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Observações']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="box box-primary" data-match-height="boxes">
                <div class="box-header with-border">
                    <h3 class="box-title">Para quem está emprestando?</h3>
                </div>
                <?php
                    if (! empty($lending) && ! empty($lending->lender_id)) {
                        $model = App\Models\Lender::find($lending->lender_id);
                        FormBuilder::model($model);
                    }
                ?>
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
                    <?php
                        $date = date('d-m-Y');
                        $date = $date . ' - ' . $date;

                        if (! empty($lending) && ! empty($lending->date_start)) {
                            FormBuilder::model(null);

                            $start = date('d-m-Y', strtotime($lending->date_start));
                            $end = date('d-m-Y', strtotime($lending->date_end ?? $lending->date_start));

                            $date = $start . ' - ' . $end;
                        }
                    ?>
                    <div class="form-group">
                        <?php FormBuilder::label('Data do Emprestimo:', 'lending-date'); ?>
                        <?php FormBuilder::input('text', 'lending-date', 'date', true, ['class' => 'form-control', 'value' => $date]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <a href="<?php echo url('/'); ?>" type="submit" class="btn btn-danger">Voltar</a>
            <button type="submit" class="btn btn-primary pull-right">Salvar</button>
        </div>
    </div>
</div>
