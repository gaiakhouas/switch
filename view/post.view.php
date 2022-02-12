<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12">
            <h1>Gestion des avis</h1>
        </div>
        <div class="col-12">
            <br>
            <table style="width:100%" class="datatable">
                <thead>
                    <tr>
                        <?= $admin->getColumnNames('avis'); ?>
                        <td width="10%" style="font-size:12px;padding:10px; background-color:#605f5f; color:#ffffff">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?= $admin->getAllData('avis'); ?>
                </tbody>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <br><br>
            <form  method="post" name="post" id="post" >
                <div class='row'>
                    <div class="col-12 col-md-4">
                        <?= $admin->getFormElement('avis', 1, 3); ?>
                    </div>
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <?= $admin->getFormElement('avis', 3, 6); ?>
                        <br>
                        <input type="hidden" id="token" value="<?= $token ?>">
                        <?= $admin->getBtn(); ?>
                        <br><br>
                        <div id='results' style="margin-top: 10px;"></div>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>