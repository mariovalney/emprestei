<?php include_template('templates/header'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Empréstimo</h1>
</section>

<!-- Main content -->
<section class="content">
    <form action="<?php echo url('/salvar/' . $lending->ID); ?>" method="POST">
        <?php include_template('templates/form-lending', $this->getData()); ?>
    </form>
</section>

<?php include_template('templates/footer'); ?>
