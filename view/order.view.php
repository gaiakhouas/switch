<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12">
            <h1>Gestion des commandes</h1>
        </div>
        <div class="col-12">
            <br>
            <table style="width:100%" class="datatable">
                <thead>
                    <tr>
                        <?= $admin->getColumnNames('commande'); ?>
                        <td width="10%" style="font-size:12px;padding:10px; background-color:#605f5f; color:#ffffff">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?= $admin->getAllData('commande'); ?>
                </tbody>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <br><br>
            <form  method="post" name="member" id="member" enctype="multipart/form-data">
                <div class='row'>
                    <div class="col-12 col-md-4">
                        <?= $admin->getFormElement('commande', 1, 3); ?>
                    </div>
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <?= $admin->getFormElement('commande', 3, 4); ?>
                        <br>
                        <input type="hidden" id="token" value="<?= $token ?>">
                        <?= $admin->getBtn(); ?>
                        <div id='results' style="margin-top: 10px;"></div>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>