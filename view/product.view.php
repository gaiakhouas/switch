<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12">
            <h1>Gestion des produits</h1>
        </div>
        <div class="col-12">
            <br>
            <table style="width:100%" class="datatable">
                <thead>
                    <tr>
                        <?= $admin->getColumnNames('produit'); ?>
                        <td width="10%" style="font-size:12px;padding:10px; background-color:#605f5f; color:#ffffff">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?= $admin->getAllData('produit'); ?>
                </tbody>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <br><br>
            <form method="post" name="product" id="product">
                <div class='row'>
                    <div class="col-12 col-md-4">
                        <label>Salle</label>
                        <select name='id_salle' class='form-control id_salle' id='id_salle'>
                            <option value=''>Sélectionnez une salle</option>
                            <?php
                            $r = $admin->executeQuery("SELECT DISTINCT id_salle, nom FROM salle  ");
                            while ($salle = $r->fetch(PDO::FETCH_ASSOC)) :
                                if (isset($_GET['id'])) :

                                    $p = $admin->executeQuery(" SELECT id_salle FROM produit 
                                        WHERE id_produit=$_GET[id]");
                                    $data = $p->fetch(PDO::FETCH_ASSOC);
                                    if ($data['id_salle'] == $salle['id_salle']) :
                                        $selected = 'selected';
                                    else :
                                        $selected = '';
                                    endif;
                                else :
                                    $selected = '';
                                endif;
                            ?>
                                <option <?= $selected ?> value='<?= $salle['id_salle']; ?>'><?= $salle['nom']; ?></option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                        <?= $admin->getFormElement('produit', 2, 4); ?>
                    </div>
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <?= $admin->getFormElement('produit', 4, 5); ?>
                       
                        <label>Etat</label>
                        <select name="etat" class="form-control">
                            <option value="">Sélectionnez un état</option>
                            <option value="reservation">reservation</option>
                            <option value="libre">libre</option>
                        </select>
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