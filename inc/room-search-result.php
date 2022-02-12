<?php
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
$search = new Room\Room();
if ($search->secureAjaxCall('searchroom')) :
    if ($_POST) :
        // securing the variables whathever the type of data (= || != array) : 
        $search->secureData();
        extract($_POST);
        if (isset($category, $city, $capacity, $cost, $arrival_date, $departure_date)) :
            $postNameArray = array("category", "city",  "capacity", "cost", "arrival_date", "departure_date");
            $output = "WHERE salle.id_salle>0 AND etat='libre'";
            for ($i = 0; $i < sizeof($postNameArray); $i++) :
                if (!empty($_POST[$postNameArray[$i]])) :
                    switch ($postNameArray[$i]):
                        case "category":
                            for ($j = 0; $j < sizeof($category); $j++) :
                                if ($category[$j] != "") :
                                    $output .= " AND categorie='" . $category[$j] . "' ";
                                endif;
                            endfor;
                            break;
                        case "city":
                            for ($j = 0; $j < sizeof($city); $j++) :
                                if ($city[$j] != "") :
                                    $output .= " AND ( ville='" . $city[$j] . "') ";
                                endif;
                            endfor;
                            break;
                        case "capacity":
                            $output .= " AND capacite>='" . $capacity . "' ";
                            break;
                        case "cost":
                            $output .= " AND prix<='" . $cost . "' ";
                            break;
                        case "arrival_date":
                            if ($arrival_date != "") :
                                $output .= " AND date_arrivee>='" . date('Y-m-d H:i:s', strtotime($search->dateChange($arrival_date, 'us'))) . "' ";
                            endif;
                            break;
                        case "departure_date":
                            if ($departure_date != "") :
                                $output .= " AND date_depart<='" . date('Y-m-d H:i:s', strtotime($search->dateChange($departure_date, 'us'))) . "' ";
                            endif;
                            break;
                    endswitch;
                endif;
            endfor;
            $r = $search->executeQuery(
                "SELECT * FROM salle 
                JOIN produit on(salle.id_salle=produit.id_salle)
                 $output
                 ORDER BY prix asc
                 
                "
            );
            $content = "<div class='row'><br>";
            $count = $r->rowCount();
            if ($count <= 0) : $content .= "<div class='xol-12 col-md-12' style='text-align:center  ' ><p class='animated fadeIn' style='text-align:left' >Aucun résultat n'a été trouvé pour cette sélection.</p></div>";
            endif;
            $nbr = 0;
            while ($salle = $r->fetch(PDO::FETCH_ASSOC)) :
                $nbr++;
                if ($nbr <= 6) :
                    $style = "";
                    $class = "";
                else :
                    $style = "display:none";
                    $class = "moreData";
                endif;
                $content .=
                    "<div class='xol-12 col-md-3 animated fadeInUp $class' style='border:0.3px solid #cccc; padding:0px 0px 20px 0px; margin-bottom:20px; margin-right:20px; $style' >
                        <a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "'><img class='img-fluid' src='src/img/" . $salle['photo'] . "' > </a>
                        <div style='padding:10px'>
                        <span><a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "'>" . $salle['nom'] . "</span></a> <span style='float:right'>" . $salle['prix'] . " €</span> 
                        <p style='font-size:12px;'>" . substr($salle['description'], 0, 20) . "...<br>
                        <span class='material-icons' style='font-size:12px; padding:2px;'>calendar_today</span>
                        " . $search->dateChange($salle['date_arrivee'], 'fr') . " au " . $search->dateChange($salle['date_depart'], 'fr') . "
                        <br><br>
                        " . $search->getStars('produit.id_salle', 'produit', 'salle', $salle['id_produit']) . "
                        <a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "' ><span style='float:right' >Voir</span><span style='float:right; font-size:15px' class='material-icons icon-nav'>search</span></a>
                        </div>
                     
                    </div>";
            endwhile;
            if ($count > 6) :
                $content .= "<div  class='xol-12 col-md-12' style='text-align:center'><button class='animated fadeInUp'  type='button' id='seeMore' style='background-color:white;border:0px; color:#04ade5;' >Voir plus</button></div>";
            endif;
            $content .= "</div>";
            echo json_encode($content);
        endif;
    endif;
endif;