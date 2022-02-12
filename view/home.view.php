<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<div class='container'>
    <br>
    <div class="row">
        <div class="col-12 col-md-3">
            <form method="post">
                <table>
                    <tr>
                        <td><label><b>Catégorie</b></label></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="custom-select form-control overflow-hidden" name="category" id="category" style="border:0px" multiple>
                                <option  value="réunion">Réunion</option>
                                <option value="bureau">Bureau</option>
                                <option value="formation">Formation</option>
                                <option value="" selected>Toute</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label><b>Ville</b></label></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="custom-select form-control overflow-hidden" name="city" id="city" style="border:0px" multiple>
                                <option value="paris"  >Paris</option>
                                <option value="lyon">Lyon</option>
                                <option value="marseille">Marseille</option>
                                <option value="" selected >Toute</option>
                            </select>
                        </td>
                    <tr>
                    <tr>
                        <td><label><b>Capacité</b></label></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control overflow-hidden" name="capacity" id="capacity" >
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                            </select>
                        </td>
                    <tr>
                    <tr>
                        <td><b><label for="amount">Prix</label></b></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="slider-range"></div>
                            <input type="text"  name="costText" id="costText" readonly style="border:0; font-size:12px; width:100%">
                            <input type="hidden"  name="cost" id="cost"  >
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <td><label><b>Période d'arrivée</b></label></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group mb-3" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text material-icons">calendar_today</span>
                                </div>
                                <input type="text" name="arrival_date" value="<?= date("d/m/Y") ?>" id="arrival_date" class="form-control datepicker"   pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="date d'arrivée" aria-label="lasting_date" aria-describedby="basic-addon1">
                            </div>
                        </td>
                    <tr>

                    <tr>
                        <td><label><b>Période de départ</b></label></td>
                    </tr>
                    <tr>
                        <td>
                        <div class="input-group mb-3" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text material-icons">calendar_today</span>
                                </div>
                                <input type="text" name="departure_date" value="" id="departure_date" class="form-control datepicker"  pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="date de départ" aria-label="departure_date" aria-describedby="basic-addon1">
                            </div>
                        </td>
                    <tr>
                </table>
                <input type="hidden" id="token" value="<?= $token ?>">
            </form>
        </div>
        <div class='xol-12 col-md-9' id='results'>
            <?= $room->searchRoom(); ?>
        </div>

    </div>

</div>
<?php include_once('inc/footer.inc.php'); ?>