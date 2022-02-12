<?php

namespace Room;

class Admin extends Room
{
    /**
     * return column names of mysql table regarding the table name parameter
     */
    public function getColumnNames($table)
    {
        $r = $this->connect->query("SELECT * FROM $table  ");
        $content = '';
        for ($i = 0; $i < $r->columnCount(); $i++) :
            $column = $r->getColumnMeta($i);
            $content .= '<td style="font-size:12px;padding:10px; background-color:#605f5f; color:#ffffff">' . $column['name'] . '</td>';
        endfor;
        return $content;
    }

    /**
     * return elements of form regarding the table parameter
     */
    public function getFormElement($table, $start = null, $end = null)
    {
        $r = $this->connect->query("SELECT * FROM $table  ");
        $content = '';
        if (empty($management)) :
            $management = null;
        endif;
        for ($i = $start; $i < $end; $i++) :
            $column = $r->getColumnMeta($i);
            // return form element regarding the column name
            switch ($column['name']):
                case 'description':
                    $content .= "<td>" . $this->createTextArea($column['name'], $table) . "</td>";
                    break;
                case 'pays':
                    $content .= "<td>" . $this->createSelect($column['name'], 'pays', $table) . "</td>";
                    break;
                case 'ville':
                    $content .= "<td>" . $this->createSelect($column['name'], 'ville', $table) . "</td>";
                    break;
                case 'photo':
                    $content .= "<td>" . $this->createInput($column['name'], 'file', $table) . "</td>";
                    break;
                case 'capacite':
                    $content .= "<td>" . $this->createInput($column['name'], 'number', $table) . "</td>";
                    break;
                case 'categorie':
                    $content .= "<td>" . $this->createSelect($column['name'], 'categorie', $table) . "</td>";
                    break;
                case 'email':
                    $content .= "<td>" . $this->createInput($column['name'], 'email', $table) . "</td>";
                    break;
                case 'mdp':
                    $content .= "<td>" . $this->createInput($column['name'], 'password', $table) . "</td>";
                    break;
                default:
                    $content .= "<td>" . $this->createInput($column['name'], 'text', $table) . "</td>";
            endswitch;
        endfor;
        return $content;
    }

    /**
     * get data from $table parametter
     */
    public function getAllData($table)
    {
        if ($table == 'membre') :
            $statut = "WHERE statut=0";
        else :
            $statut = "";
        endif;
        $r = $this->connect->query("SELECT * FROM $table $statut ");
        $content = '';
        while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :
            $content .= '<tr>';
            foreach ($data as $key => $value) :
                if ($key == 'photo') :
                    $value = "<img style='width:50px' src='src/img/$data[$key]' >";
                else :
                    $value = $data[$key];
                endif;
                $content .= '<td style="font-size:12px; padding:10px;">' . $value . '</td>';
            endforeach;
            $style = "color:#605f5f; font-size:20px;";
            $content .= '
            <td>
                <a style="' . $style . '" href="' . URL . 'index.php?action=' . $table . '&id=' . $data['id_' . $table] . '&admin=show"><span  style="' . $style . '" class="material-icons">search</span></a>
                <a style="' . $style . '"  href="' . URL . 'index.php?action=' . $table . '&id=' . $data['id_' . $table] . '&admin=edit"><span style="' . $style . '" class="material-icons">edit</span></a>
                <a style="' . $style . '" href="' . URL . 'index.php?action=' . $table . '&id=' . $data['id_' . $table] . '&admin=delete"><span style="' . $style . '" class="material-icons">delete</span></a>
            </td>';
            $content .= '</tr>';
        endwhile;
        return $content;
    }

    /**
     * Create an input regarding the $name and $type parameters
     */
    public function createInput($name, $type, $table = null)
    {
        $output = "<label>" . ucfirst($name) . "</label>";
        if (!empty($table)) :
            $value = $this->fillDataFormEl($name, $table);
        else :
            $value = "";
        endif;
        //date
        if ($name == 'date_arrivee' || $name == 'date_depart' || $name == 'date_enregistrement') :
            $output .= "<div class='input-group mb-3' >
                                <div class='input-group-prepend'>
                                    <span class='input-group-text material-icons'>calendar_today</span>
                                </div>
                                <input type='text' name='" . $name . "' value='" . $value . "' id='" . $name . "' class='form-control datepicker'  pattern='(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d' placeholder='" . $name . "' aria-label='" . $name . "' aria-describedby='basic-addon1'>
                            </div>";
        else :
            $output .= "<input type='" . $type . "' class='form-control' id='" . $name . "' placeholder='" . $name . "' name='" . $name . "' value='" . $value . "' >";
        endif;

        //file
        if ($type == "file" && !empty($table)) :
            $output .= '<i>Vous pouvez uploader une nouvelle photo</i>';
            $output .= '<img src="' . URL . 'src/img/' . $this->fillDataFormEl($name, $table) . '" width="80" ><br><br>';
            $output .= '<input type="hidden"  name="current_file" value="' . URL . 'src/img/'  . $this->fillDataFormEl($name, $table) . '">';
        endif;

        return $output;
    }

    /**
     * Create a select and fill it with the data if $table parametter is not empty
     * $name = name of the select element 
     * $table1= $table to get all data
     * $table2= matched $table for getting the saved value 
     */
    public function createSelect($name, $table1 = null, $table2 = null)
    {

        $output = "<label>" . ucfirst($name) . "</label>";
        $output .= "<select  class='form-control' id='" . $name . "'  name='" . $name . "'  >";
        $output .= "<option value=''>Sélectionnez $name</option>";

        // query
        if (!empty($table1) && !empty($table2)) :
            $r = $this->executeQuery('SELECT * FROM ' . $table1 . ' ');
            while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :

                if ($data['nom'] == $this->fillDataFormEl($name, $table2)) :
                    $selected = 'selected';
                else :
                    $selected = '';
                endif;

                $output .= "<option $selected value=" . $data['nom'] . ">" . ucfirst($data['nom']) . "</option>";
            endwhile;
        endif;
        $output .= "</select>";
        return $output;
    }
    /**
     * 
     */


    /**
     * Create a textarea regarding the $name and $type parameters and fill it with data if $table is not null
     */
    public function createTextArea($name, $table = null)
    {
        $output = "<label>" . ucfirst($name) . "</label>";
        if (!empty($table)) :
            $value = $this->fillDataFormEl($name, $table);
        else :
            $value = "";
        endif;
        $output .= '<textarea name="' . $name . '" id="' . $name . '" class="form-control" placeholder="' . $name . '"  >' . $value . '</textarea>';
        return $output;
    }

    /**
     * return data from column mysql table 
     * name=name of input or select
     */
    public function fillDataFormEl($name, $table)
    {
        if ($_GET) :
            $this->secureData("get");
            if (isset($_GET['id'])) :
                // get the first Column of the table
                $r = $this->executeQuery("SELECT * FROM $table ");
                $column = $r->getColumnMeta(0);
                // we assume that the id is the first column of the mysql table
                $columnId = $column['name'];
                $p = $this->executeQuery("SELECT $name FROM $table 
                WHERE $columnId= $_GET[id] ");
                $data = $p->fetch(\PDO::FETCH_ASSOC);
                return $data[$name];
            endif;
        endif;
    }
    /**
     * get last id from table parameter
     */
    public function getLastId($table)
    {
        if ($table) :
            $r = $this->executeQuery("SELECT id_" . $table . " FROM $table ORDER BY id_" . $table . " DESC LIMIT 1 ");
            if ($r->rowCount() > 0) :
                $get = $r->fetch();
                return $get["id_" . $table];
            else :
                return false;
            endif;
        else :
            return false;
        endif;
    }
    /**
     * return needed button(s) for the submiting the form 
     */
    public function getBtn()
    {
        $content = "";
        if ($_GET) :
            if (isset($_GET['id'])) :
                if (isset($_GET['admin'])) :
                    if ($_GET['admin'] == 'edit') :
                        $content .=
                            "<button type='button' id='update' name='update' class='btn btn-warning update' >Mettre à jour</button>
                 <button style='float:right' type='button' id='save' name='save' class='btn btn-primary save' >Enregistrer</button>";
                    elseif ($_GET['admin'] == 'delete') :
                        $content .=
                            "<button type='button' id='delete' name='delete' class='btn btn-danger delete' >Supprimer</button>";

                    endif;
                else :
                    $content .=
                        "<button style='float:right' type='button' id='save' name='save' class='btn btn-primary save' >Enregistrer</button>";

                endif;
            else :
                $content .= "<button style='float:right'  type='button' id='save' name='save' class='btn btn-primary save' >Enregistrer</button>";
            endif;
        endif;
        return $content;
    }

    /**
     * Insert data inside table and return notification 
     */
    public function insertNewData($table)
    {
        $this->secureData();
        $postVal = "";
        $columns = "";
        $notif = "";
        $i = 1;
        $p = $this->executeQuery("SELECT * FROM $table");
        foreach ($_POST as $key => $value) :
            $i++;
            if (!empty($_POST[$key])) :
                for ($j = 1; $j < $p->columnCount(); $j++) :
                    $mysqlCol = $p->getColumnMeta($j);
                    if ($i < sizeof($_POST)) :
                        $coma = ",";
                    else :
                        $coma = "";
                    endif;
                    // we change temporary the value of key for teating the file properly
                    ($key == "current_file") ? $key = "photo" :  $key = $key;
                    // we compare the column name with the curent input name
                    if ($mysqlCol['name'] == $key) :
                        if ($mysqlCol['name'] == "photo") :
                            if (!empty($_FILES['photo']['name'])) :
                                //Rename the photo :
                                $photo_name = (($this->getLastId($table)) + 1) . '_' . $_FILES['photo']['name'];
                                //path to access to the file in the database :
                                $value = $photo_name;
                                // folder where the photo is registered
                                $photo_folder = $_SERVER['DOCUMENT_ROOT'] . "/switch/src/img/$photo_name";
                                copy($_FILES['photo']['tmp_name'], $photo_folder);
                            else :
                                $value = $_POST["current_file"];
                            endif;
                        endif;
                        if (
                            $mysqlCol['name'] == "date_arrivee"
                            || $mysqlCol['name'] == "date_depart"
                            || $mysqlCol['name'] == "date_enregistrement"
                        ) {
                            $current_date = $this->dateChange($value, 'us');
                            $value = date("Y-m-d H:i:s", strtotime($current_date));
                        }
                        $columns .= $key . $coma;
                        $postVal .= "'$value'" . $coma;
                        if ($j == ($p->columnCount() - 1)) :
                            $r = $this->executeQuery("INSERT INTO $table($columns) VALUES($postVal)");
                            $notif = '<p style="padding:10px" class="alert-success animated fadeIn" >Enregistrement réussi.<br> <a href="index.php?action=' . $table . '">Actualiser les données.</a></p>';
                        endif;
                    endif;
                endfor;
            else :
                $notif = '<p style="padding:10px" class="alert-danger animated fadeIn" >Veuillez renseigner tous les champs demandés.</p>';
                break;
            endif;
        endforeach;
        //debug return $columns."<br><br>".$postVal;
        return $notif;
    }
    /**
     * Update data of the table and return a notification
     */
    public function updateData($table)
    {
        $this->secureData();
        $postVal = "";
        $columns = "";
        $notif = "";
        $i = 1;
        $p = $this->executeQuery("SELECT * FROM $table");
        foreach ($_POST as $key => $value) :
            $i++;
            if (!empty($_POST[$key])) :
                for ($j = 1; $j < $p->columnCount(); $j++) :
                    $mysqlCol = $p->getColumnMeta($j);
                    if ($i < sizeof($_POST)) :
                        $coma = ",";
                    else :
                        $coma = "";
                    endif;
                    // we change temporary the value of key for teating the file properly
                    ($key == "current_file") ? $key = "photo" :  $key = $key;
                    // we compare the column name with the curent input name
                    if ($mysqlCol['name'] == $key) :
                        if ($mysqlCol['name'] == "photo") :
                            if (!empty($_FILES['photo']['name'])) :
                                //Rename the photo :
                                $photo_name = (($this->getLastId($table)) + 1) . '_' . $_FILES['photo']['name'];
                                //path to access to the file in the database :
                                $value = $photo_name;
                                // folder where the photo is registered
                                $photo_folder = $_SERVER['DOCUMENT_ROOT'] . "/switch/src/img/$photo_name";
                                copy($_FILES['photo']['tmp_name'], $photo_folder);
                                $filetodelete = str_replace("http://localhost:81", $_SERVER['DOCUMENT_ROOT'], $_POST["current_file"]);

                            else :
                                $value = $_POST["current_file"];
                            endif;
                        endif;
                        if ($mysqlCol['name'] == "date_arrivee" || $mysqlCol['name'] == "date_depart") {
                            $current_date = $this->dateChange($value, 'us');
                            $value = date("Y-m-d H:i:s", strtotime($current_date));
                        }
                        $columns .= $key . '=' . "'$value'" . $coma;
                        if ($j == ($p->columnCount() - 1)) :
                            if ($table == 'membre') :
                                $statut = "AND statut=0";
                            else :
                                $statut = "";
                            endif;
                            $r =  $this->executeQuery("UPDATE $table SET $columns WHERE id_$table=" . $_SESSION['id'] . " $statut  ");
                            if ($r->rowCount()>0) :
                             $notif = '<p style="padding:10px" class="alert-success animated fadeIn" >Enregistrement réussi.<br> <a href="index.php?action=' . $table . '&id=' . $_SESSION['id'] . '&admin=edit">Actualiser les données.</a></p>';
                            else:
                                $notif = '<p style="padding:10px" class="alert-danger animated fadeIn" >Enregistrement non autorisé.<br> <a href="index.php?action=' . $table . '>Actualiser les données.</a></p>';   
                        endif;
                        endif;
                    endif;
                endfor;
            else :
                $notif = '<p style="padding:10px" class="alert-danger animated fadeIn" >Veuillez renseigner tous les champs demandés.</p>';
                break;
            endif;
        endforeach;
        //debug return $columns."<br><br>".$postVal;
        //return $_POST['current_file'];
        return $notif;
    }
    /**
     * 
     */
    public function confirm()
    {
        $this->secureData();
        $notif = "<div style='padding:10px' class='animated fadeInRight' >";
        $notif .= "<p >Vous en êtes sûr ?</p>";
        $notif .= "<button class='btn btn-danger confirm' name='confirm' id='confirm' type='button'  >Oui</button>&nbsp;";
        $notif .= "<button class='btn btn-warning' nama='deny' >Non</button>";
        $notif .= "</div>";
        return $notif;
    }
    /**
     * delete data from table parameter
     */
    public function deleteData($table)
    {
        $this->secureData();
        if ($_POST['action'] != 'confirm') :
            $notif = $this->confirm();
        else :
            if ($_POST['action'] == 'confirm') :
                if ($table == 'membre') :
                    $statut = "AND statut=0";
                else :
                    $statut = "";
                endif;
                $this->executeQuery("DELETE FROM $table WHERE id_$table=" . $_SESSION['id'] . "  $statut ");
                 if ($r->rowCount()==1) :
                    $notif = '<p style="padding:10px" class="alert-success animated fadeIn" >Suppréssion réussi.<br> <a href="index.php?action=' . $table . '">Actualiser les données.</a></p>';
                else :
                    $notif = '<p style="padding:10px" class="alert-danger animated fadeIn" >Suppréssion non autorisée.<br> <a href="index.php?action=' . $table . '">Actualiser les données.</a></p>';
                endif;
            endif;
        endif;
        return $notif;
    }

    public function getTop5BestRate()
    {
        // récupérer les salles qui ont une note
        $r = $this->executeQuery("SELECT DISTINCT id_salle, AVG(note) as avg_note FROM avis GROUP BY id_salle  ORDER BY avg_note DESC LIMIT 5");
        $content = "";
        while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :
            $content .= $this->getInfoTable('nom', 'salle', null, $data['id_salle']) . " (" . number_format($data['avg_note'], 1) . ")<br>";
        endwhile;
        return $content;
    }

    public function getTop5Order()
    {
        $r = $this->executeQuery(
            "SELECT DISTINCT id_salle, COUNT(id_commande) as nb_cmd 
              FROM commande JOIN produit 
              on(commande.id_produit=produit.id_produit)
              GROUP BY id_salle 
              ORDER BY nb_cmd DESC LIMIT 5"
        );
        $content = "";
        while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :
            $content .= $this->getInfoTable('nom', 'salle', null, $data['id_salle']) . " (" . $data['nb_cmd'] . ")<br>";
        endwhile;
        return $content;
    }

    public function getTop5Orders()
    {
        $r = $this->executeQuery(
            "SELECT DISTINCT id_membre, COUNT(id_commande) as nb_cmd 
            FROM commande JOIN produit 
            on(commande.id_produit=produit.id_produit)
            GROUP BY id_membre 
            ORDER BY nb_cmd DESC LIMIT 5 "
        );

        $content = "";
        while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :
            $content .= $this->getInfoTable('pseudo', 'membre', null, $data['id_membre']) . " (" . $data['nb_cmd'] . ")<br>";
        endwhile;
        return $content;
    }

    public function getTop5Buyers(){
        $r = $this->executeQuery(
            "SELECT DISTINCT id_membre, SUM(prix) as total_price 
            FROM commande JOIN produit 
            on(commande.id_produit=produit.id_produit)
            GROUP BY id_membre 
            ORDER BY total_price DESC LIMIT 5 "
        );

        $content = "";
        while ($data = $r->fetch(\PDO::FETCH_ASSOC)) :
            $content .= $this->getInfoTable('pseudo', 'membre', null, $data['id_membre']) . " (" . number_format($data['total_price'], 0, '', ' ') . " €)<br>";
        endwhile;
        return $content;
        
    }

    
}
