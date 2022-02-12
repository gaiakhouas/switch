<?php

namespace Room;

class Room extends Account
{
    public  $connect;
    /**
     * @var string
     */
    private $host = "add_the_host_name";
    private $database = "add_database_name";
    private $user = 'add_user_name';
    private $pass = 'add_user_password';

    function __construct()
    {
        $this->database_connect();
    }
    // @param string $query - connection to the database
    public function database_connect()
    {
        try {
            $this->connect = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->pass, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function executeQuery($query)
    {
        $r = $this->connect->query($query);
        return $r;
    }

    public function searchRoom()
    {
        $r = $this->executeQuery(
            "SELECT * 
            FROM salle JOIN produit 
            on(salle.id_salle=produit.id_salle) 
            WHERE etat='libre'
            "
        );
        $content = "<div class='row'><br>";
        $count = $r->rowCount();
        if ($count <= 0) : $content .= "<div class='xol-12 col-md-12' ><p class='animated fadeIn' style='text-align:left' >Aucun résultat n'a été trouvé pour cette sélection.</p></div>";
        endif;
        $nbr = 0;
        while ($salle = $r->fetch(\PDO::FETCH_ASSOC)) :
            $nbr++;
            if ($nbr <= 6) :
                $style = "";
                $class = "";
            else :
                $style = "display:none";
                $class = "moreData";
            endif;
            $content .=
                "<div  class='xol-12 col-md-3 animated fadeInUp $class' style='border:0.3px solid #cccc; padding:0px 0px 20px 0px; margin-bottom:20px; margin-right:20px; $style' >
                        <a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "'><img  class='img-fluid' style='height:150px' src='src/img/" . $salle['photo'] . "' ></a>
                        <div style='padding:10px'>
                            <span><a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "'>" . $salle['nom'] . "</span></a> <span style='float:right'>" . $salle['prix'] . " €</span> 
                            <p style='font-size:12px;'>" . substr($salle['description'], 0, 20) . "...<br>
                            <span class='material-icons' style='font-size:12px; padding:2px;'>calendar_today</span>
                            " . $this->dateChange($salle['date_arrivee'], 'fr') . " au " . $this->dateChange($salle['date_depart'], 'fr') . "
                            <br><br>
                            " . $this->getStars('produit.id_salle', 'produit', 'salle', $salle['id_produit']) . "
                            <a href='index.php?action=ficheproduit&id=" . $salle['id_produit'] . "' ><span style='float:right' >Voir</span><span style='float:right; font-size:15px' class='material-icons icon-nav'>search</span></a>
                        </div>

                </div>";
        endwhile;
        if ($count > 6) :
            $content .= "<div  class='xol-12 col-md-12' style='text-align:center'><button class='animated fadeInUp'  type='button' id='seeMore' style='background-color:white;border:0px; color:#04ade5;' >Voir plus</button></div>";
        endif;
        $content .= "</div>";
        return $content;
    }

    public function dateChange($date, $format = null)
    {
        switch ($format) {
            case "fr":
                $date = str_replace('/', '-', $date);
                $newformat = "d/m/Y";
                break;
            case "us":
                $date = str_replace('/', '-', $date);
                $newformat = "Y-m-d";
        }
        $result = date($newformat, strtotime($date));
        return $result;
    }

    public function secureData()
    {
        foreach ($_POST as $key => $value) :
            if (gettype($_POST[$key]) == "array") :
                // case array
                for ($i = 0; $i < sizeof($_POST[$key]); $i++) :
                    $_POST[$key][$i] =  htmlspecialchars($_POST[$key][$i]);
                    $_POST[$key][$i] = strip_tags($_POST[$key][$i]);
                    $_POST[$key][$i] =  addslashes($_POST[$key][$i]);
                endfor;
            else :
                // case != array
                $_POST[$key] = htmlspecialchars($value);
                $_POST[$key] = strip_tags($value);
                $_POST[$key] = addslashes($value);
            endif;
        endforeach;
    }

    public function secureAjaxCall($action)
    {
        /**
         * * http_referer 
         * * local : http://localhost:81/switch/index.php
         * * Prod : to define
         * * $_SERVER['SERVER_NAME']
         * */

         if (!empty($_SERVER['HTTP_REFERER']) ):
         return true;
        else:
            return false;
        endif;
    }
    /**
     * return an array of data from the selected tables though parameters
     * or redirect the user though the index page.
     */
    public function getInfoTable($name, $table1, $table2 = null, $id = null)
    {
        if (!empty($_GET['id'])) :
            $getId = htmlspecialchars($_GET['id']);
            $where = "WHERE $table1.id_$table1=$getId ";
        else :
            if (!empty($id)) :
                $where = "WHERE $table1.id_$table1=$id ";
            else :
                $where = "";
            endif;
        endif;
        if (!empty($table2)) :
            $join = "JOIN $table2 on($table1.id_$table2=$table2.id_$table2) ";
        else :
            $join = "";
        endif;

        $r = $this->executeQuery("SELECT  $name as 'data' FROM $table1 $join $where  ");
        if ($r->rowCount() == 1) :
            $infoTable = $r->fetch(\PDO::FETCH_ASSOC);
            return $infoTable['data'];
        else :
            header("Location:index.php");
        endif;
    }


    /**
     * Return 4 differents values of product from $_GET['id']
     */
    public function getOtherProducts($name, $table1, $table2 = null, $type = null)
    {
        if (!empty($_GET['id'])) :
            $getId = htmlspecialchars($_GET['id']);
            $where = "WHERE $table1.id_$table1!=$getId 
            ";
        else :
            $where = "";
        endif;
        if (!empty($table2)) :
            $join = "JOIN $table2 on($table1.id_$table2=$table2.id_$table2) ";
        else :
            $join = "";
        endif;
        $r = $this->executeQuery("SELECT  $name, id_$table1 FROM $table1 $join $where  LIMIT 4  ");
        $content = "";
        while ($infoTable = $r->fetch(\PDO::FETCH_ASSOC)) :
            if ($type == 'img') :
                $addType = "<a href='index.php?action=ficheproduit&id=" . $infoTable['id_' . $table1] . "'><img style='height:100px;' class='img-fluid' src=src/img/";
                $endType = "></a>";
            else :
                $addType = "<p>";
                $endType = "</p>";
            endif;
            $content .= " <div class='xol-12 col-md-3' style='text-align:center'>";
            $content .= $addType . $infoTable[$name] . $endType;
            $content .= " </div>";
        endwhile;
        return $content;
    }

    /**
     * return the average of customers grade
     */
    public function calcAvg($name, $table, $table2, $id)
    {
        $r = $this->executeQuery("SELECT AVG($name) as 'avg' FROM $table WHERE id_$table2=$id GROUP BY id_$table2 ");
        if ($r->rowCount() > 0) :
            $avg = $r->fetch(\PDO::FETCH_ASSOC);
            return number_format($avg['avg'], 0);
        endif;
    }

    /**
     * return grade in html format (stars)
     * 4 parameters : $name of the field table, $table1 as referent table, $table2 as linked table, $id of the current product (optional)
     */
    public function getStars($name, $table1, $table2, $id = null)
    {
        $id_salle = $this->getInfoTable($name, $table1, $table2, $id);
        $note = $this->calcAvg('note', 'avis', 'salle', $id_salle);
        $content = "";
        for ($i = 0; $i < $note; $i++) :
            $content .= "<span style='font-size:100%; color:#ff9900' class='material-icons'>star_rate</span>";
        endfor;
        return $content;
    }

    /**
     * check if the product is available or not
     */
    public function checkProduct($table, $id)
    {
        $this->secureData();
        $getEtat = $this->executeQuery("SELECT etat FROM $table WHERE id_$table=$id AND etat='libre' ");
        if ($getEtat->rowCount() == 1) :
            return true;
        else :
            return false;
        endif;
    }

    /**
     * return the id value of room from the product id or false if not found
     */
    public function getRoomId($idprod)
    {
        $searchId = $this->executeQuery("SELECT id_salle FROM produit WHERE id_produit=$idprod LIMIT 1 ");
        if ($searchId->rowCount() == 1) :
            $data = $searchId->fetch();
            return  $data['id_salle'];
        else :
            return false;
        endif;
    }


    /**
     * return true if no post has been inserted already by the current user for the current room
     */
    public function checkPost($table, $idprod, $id_user)
    {
        $this->secureData();
        $getPost = $this->executeQuery("SELECT note FROM $table WHERE id_salle=" . $this->getRoomId($idprod) . " AND id_membre=$id_user ");
        if ($getPost->rowCount() < 1) :
            return true;
        else :
            return false;
        endif;
    }

    /**
     * return a specific activity btn on client side or an explained message
     */
    public function getBookBtn()
    {
        $user = $this->getAccountName();
        $content = "";
        if ($this->checkProduct('produit', $_GET['id'])) :
            if ($user == "client") :
                // btn booking
                $content .= "<button style='float :right; ' type='submit' class='btn btn-success booking' name='book' >Réserver</button>";
            else :
                //btn connexion
                $content .= "<button style='float :right; ' type='button' class='btn btn-success' data-toggle='modal' data-target='#signIn'  >Réserver</button>";
            endif;
        else :
            $content .= '<span style="float:right; padding:20px; color:#ff0000">Déjà réservée</span>';
        endif;
        return $content;
    }

    /**
     * return a stand btn
     */
    public function getMyBtn($name, $placeholder)
    {
        $user = $this->getAccountName();
        $content = "";
        if ($user == "client") :
            // btn booking
            $content .= "<button type='submit' class='btn btn-primary $name' name='$name' >$placeholder</button>";
        else :
            //btn connexion
            $content .= "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#signIn'  >$placeholder</button>";
        endif;

        return $content;
    }

    public function contact($lastname, $firstname, $msg)
    {
        $mail_to = 'contact@gaia-kh.com';
        $mail_subject = 'Switch : nouveau message ! ';
        $mail_message = "<html lang='fr' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
        <head>
            <meta charset='utf-8'> <!-- utf-8 works for most cases -->
            <meta name='viewport' content='width=device-width, initial-scale=1'><!-- Forcing initial-scale shouldn't be necessary -->
            <meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- Use the latest (edge) version of IE rendering engine -->
            <meta name='x-apple-disable-message-reformatting'>  <!-- Disable auto-scale in iOS 10 Mail entirely -->
            <meta name='format-detection' content='telephone=no,address=no,email=no,date=no,url=no'> <!-- Tell iOS not to automatically link certain text strings. -->
            <title>Switch Administrator</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
            <!-- Web Font / @font-face : BEGIN -->
            <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
    
            <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
            <!--[if mso]>
                <style>
                    * {
                        font-family: sans-serif !important;
                    }
                </style>
            <![endif]-->
    
            <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
            <!--[if !mso]><!-->
            <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
            <!--<![endif]-->
    
            <!-- Web Font / @font-face : END -->
            <style>
            /* What it does: Remove spaces around the email design added by some email clients. */
            /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
            .ReadMsgBody { width:100%; }
            /* Force hotmail/outlook.com to display at full width (outer div) */
            .ExternalClass { width:100%;line-height: 100%; } 
            /* Force hotmail/outlook.com to display at full width (inner div) */
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height:100%; }
            /* Fix the line-height bug in hotmail/outlook.com */
            #wrappertable { margin:0; padding:0; width:100% !important; line-height:100% !important; }
            /* In case the body tag is removed (Gmail etc..)*/
            html,
            body {
                margin: 0 auto !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
                -webkit-text-size-adjust:100%; 
                -webkit-nbsp-mode: space;
                -webkit-line-break: after-white-space;
                -ms-text-size-adjust:100%;
                word-wrap: break-word;
                line-height: normal;
                color: #000000;
                font-size: 12px;
                font-family: Arial, sans-serif;
                background-color: #FFFFFF;
                
            }
    
            /* What it does: Stops email clients resizing small text. */
            * {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
    
            /* What it does: Centers email on Android 4.4 */
            div[style*='margin: 16px 0'] {
                margin: 0 !important;
            }
            /* What it does: forces Samsung Android mail clients to use the entire viewport */
            #MessageViewBody, #MessageWebViewDiv{
                width: 100% !important;
            }
    
            td, a, font, p, strong, i, br, div, h1, h2, h3, h4, h5, h6 {
                line-height: normal;
            }
    
            /* What it does: Stops Outlook from adding extra spacing to tables. */
            table,
            td {
                mso-table-lspace: 0pt !important;
                mso-table-rspace: 0pt !important;
                border-spacing: 0;
            }
    
            /* What it does: Fixes webkit padding issue. */
            table {
                border-spacing: 0 !important;
                border-collapse: collapse !important;
                table-layout: fixed !important;
                margin: 0 auto !important;
            }
    
            /* What it does: Uses a better rendering method when resizing images in IE. */
            img {
                -ms-interpolation-mode:bicubic;
            }
    
            /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
            a {
                text-decoration: none;
                color: inherit;
            }
    
            /* What it does: A work-around for email clients meddling in triggered links. */
            a[x-apple-data-detectors],  /* iOS */
            .unstyle-auto-detected-links a,
            .aBn {
                border-bottom: 0 !important;
                cursor: default !important;
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
    
            /* What it does: Prevents Gmail from changing the text color in conversation threads. */
            .im {
                color: inherit !important;
            }
    
            /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
            .a6S {
                display: none !important;
                opacity: 0.01 !important;
            }
            /* If the above doesn't work, add a .g-img class to any image in question. */
            img.g-img + div {
                display: none !important;
            }
    
            /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
            /* Create one of these media queries for each additional viewport size you'd like to fix */
    
            /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
            @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                u ~ div .email-container {
                    min-width: 320px !important;
                }
            }
            /* iPhone 6, 6S, 7, 8, and X */
            @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                u ~ div .email-container {
                    min-width: 375px !important;
                }
            }
            /* iPhone 6+, 7+, and 8+ */
            @media only screen and (min-device-width: 414px) {
                u ~ div .email-container {
                    min-width: 414px !important;
                }
            }
            /* Media Queries */
            @media screen and (max-width : 620px ){
                
                
                .hide{
                    display:none !important;
                }
                [class=w280] {
                    width: 280px !important;
                }
                [class=w140] {
                    width: 140px !important;
                }
                /* What it does: Forces table cells into full-width rows. */
                .stack-column,
                .stack-column-center {
                    display: block !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    direction: ltr !important;
                }
                /* And center justify these ones. */
                .stack-column-center {
                    text-align: center !important;
                }
    
                /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
                .center-on-narrow {
                    text-align: center !important;
                    display: block !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                    float: none !important;
                }
                table.center-on-narrow {
                    display: inline-block !important;
                }
    
                /* What it does: Adjust typography on small screens to improve readability */
                .email-container p {
                    font-size: 17px !important;
                }
            }
            .center-on-narrow {	            
                    text-align: center !important;
                    display: block !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                    float: none !important;
    }
    
    
            </style>
        <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
         <!--[if mso]>
            <xml>
            <o:OfficeDocumentSettings>
              <o:AllowPNG/>
              <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
            </xml>
        <![endif]-->
          <!--[if lte mso 11]>
            <style type='text/css'>
              .mj-outlook-group-fix { width:100% !important; }
            </style>
        <![endif]-->
    
        </head>
        <body style='word-wrap:break-word; -webkit-nbsp-mode:space;-webkit-line-break:after-white-space;color:#000000;font-size:12px;font-family:Arial,sans-serif;width: 100% !important; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; background-color: #FFFFFF; line-height:normal;mso-line-height-rule: exactly;' >
        <center style='width: 100%; background-color: #FFFFFF;'>
        <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:500px; margin: auto;'>
        <tr>
            <td>Nom : $lastname</td>
        </tr>
        <tr>
            <td>Prénom : $firstname</td>
        </tr>
        <tr>
            <td>Message : $msg</td>
        </tr>
        </table>
        </center>
        </body>
    </html>";
        $headers  = "From: Switch < contact@gaia-kh.com >\n";
        $headers .= "X-Sender: Switch < contact@gaia-kh.com  >\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        $headers .= "X-Priority: 1\n"; // Urgent message!
        $headers .= "Return-Path: contact@gaia-kh.com \n"; // Return path for errors
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
        // Send mail
        if(mail($mail_to, $mail_subject, $mail_message, $headers)):    
        else:
            exit();
        endif;
    }
}
