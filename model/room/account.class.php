<?php

namespace Room;

class Account
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
        $this->autoLogOut();
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

    /**
     * check the user email/pseudo exists contact/admin table
     */
    public function logIn($signup = null)
    {
        if (isset($_POST["login"]) || $signup == "ok") {
            $email_pseudo = htmlspecialchars($_POST["email"]);
            $password = sha1($_POST["password"]);
            if (filter_var($email_pseudo, FILTER_VALIDATE_EMAIL)) {
                $field = "email";
            } else {
                $field = "pseudo";
            }
            // check the user email/pseudo exists contact/admin table
            $getData = $this->connect->query("SELECT * FROM membre 
        WHERE " . $field . "='" . $email_pseudo . "' AND mdp='" . $password . "' ");
            $countClt = $getData->rowCount();
            if ($countClt > 0) {
                $userInfo = $getData->fetch();
                return $userInfo;
            } else {
                $getData = $this->connect->query("SELECT * FROM admin 
            WHERE " . $field . "='" . $email_pseudo . "' AND mdp='" . $password . "' ");
                $countAdm = $getData->rowCount();
                if ($countAdm > 0) {
                    $userInfo = $getData->fetch();
                    return $userInfo;
                    header('location:index.php');
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function autoLogOut()
    {
        if (isset($_POST["login"])) :
            $_SESSION["timestamp"] = time();
        elseif (isset($_SESSION["timestamp"])) :
            if (time() - $_SESSION["timestamp"] > 900) :
                header("Location: inc/logout.inc.php");
            else :
                $_SESSION["timestamp"] = time();
            endif;
        endif;
    }

    public function checkEmailPseudo($email_pseudo, $password = null)
    {
        if (filter_var($email_pseudo, FILTER_VALIDATE_EMAIL)) {
            $field = "email";
        } else {
            $field = "pseudo";
        }
        $addWhere = "";
        if (!empty($password)) :
            $addWhere = " AND mdp='" . $password . "'";
        endif;


        // check the user email/pseudo exists membre/admin table
        $getData = $this->connect->query("SELECT * FROM membre 
           WHERE " . $field . "='" . $email_pseudo . "' " . $addWhere . " AND statut='0' ");
        $countClt = $getData->rowCount();
        if ($countClt > 0) :
            return 1;
        else :
            $getData = $this->connect->query("SELECT * FROM membre 
            WHERE " . $field . "='" . $email_pseudo . "' " . $addWhere . " AND statut='1' ");
            $countAdmin = $getData->rowCount();
            if ($countAdmin > 0) :
                return 1;
            else :
                return 0;
            /* code to add for better security 
            $getData = $this->connect->query("SELECT * FROM admin 
            WHERE " . $field . "='" . $email_pseudo . "' $addWhere  ");
            $countAdm = $getData->rowCount();
            if ($countAdm > 0) :
                return 1;
            else :
                return 0;
                 */
            endif;
        endif;
    }
    // handle the signup of the user at any page
    public function signUp()
    {
        if (isset($_POST["signup"])) {
            $pseudo = htmlspecialchars($_POST["pseudo"]);
            $email = htmlspecialchars($_POST["email"]);
            $password = sha1($_POST["password"]);
            $firstName = htmlspecialchars($_POST["firstName"]);
            $lastName = htmlspecialchars($_POST["lastName"]);
            $sexe = htmlspecialchars($_POST["sexe"]);

            $checkPseudo = $this->checkEmailPseudo($pseudo);
            $checkEmail = $this->checkEmailPseudo($email);

            if ($checkPseudo == 0 && $checkEmail == 0) {
                if (
                    strlen($email) <= 50
                    && strlen($password) >= 10
                    && strlen($password) <= 128
                    && strlen($firstName) >= 2
                    && strlen($firstName) <= 50
                    && strlen($lastName) >= 2
                ) {
                    // validation of email
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        // mysql insert 
                        try {
                            $insert = $this->connect->prepare("INSERT INTO 
                        membre(pseudo, mdp, nom, prenom, email, civilite, statut) 
                        VALUES(?, ?, ?, ?, ?, ?, ?) ");
                            $insertSet = $insert->execute(array($pseudo, $password, $lastName, $firstName, $email, $sexe, 0));
                            return "ok";
                        } catch (\Exception $e) {
                            echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
                        }
                    } else {
                        return "ko";
                    }
                }
            } else {
                $error = "Cette email est déjà utilisée";
                return $error;
            }
        }
    }

    /**
     * Return name of the current user type (client || admin || visitor)
     */
    public function getAccountName()
    {
        if (isset($_SESSION["userInfo"])) :
            $seachClt = array_key_exists('id_membre', $_SESSION["userInfo"]);
            $searchAdm = array_key_exists('id_admin', $_SESSION["userInfo"]);
            if ($seachClt > 0 && $_SESSION["userInfo"]['statut'] == 0) :
                $name = "client";
            elseif ($searchAdm > 0 || $_SESSION["userInfo"]['statut'] == 1) :
                $name = "admin";
            else :
                $name = "visitor";
            endif;
            return $name;
        endif;
    }
    /**
     * return the header in html format regarding the value of current user type
     */
    public function headerChange()
    {
        $user = $this->getAccountName();
        switch ($user) {
            case "client":
                $header =
                    '<div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                    <a class="nav-link" href="' . URL . 'index.php?action=searchroom">Rechercher une salle</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">  
                    <span class="material-icons icon-nav" >search</span>
                    <button  style="padding:0px"  type="button" class="btn" data-toggle="modal" data-target="#account">
                    <span  class="styled-colored-el">Bonjour ' . $_SESSION["userInfo"]["prenom"] . '</span>
                    </button>
                    <span  class="material-icons styled-colored-el" style="padding-bottom:4px;">perm_identity</span>
                </form>
                </div>';
                break;
            case "admin":
                $header =
                    '<div class="collapse navbar-collapse" id="menu">
                        <ul class="navbar-nav mr-auto">
                            <div class="collapse navbar-collapse" id="menu">
                            <li class="nav-item ">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" style="background-color:#fffff;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         Gestion
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=salle">Salle</a>
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=produit">produit</a>
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=membre">Membre</a>
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=avis">Avis</a>
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=commande">Commandes</a>
                                        <a class="dropdown-item" href="' . URL . 'index.php?action=stats">Stats</a>
                                    </div>
                                </div>
                            </li>  
                        </ul>
                        <form class="form-inline my-2 my-lg-0">  
                            <span class="material-icons icon-nav" >search</span>
                            <button  style="padding:0px"  type="button" class="btn" data-toggle="modal" data-target="#account">
                            <span  class="styled-colored-el account">Bonjour ' . $_SESSION["userInfo"]["prenom"] . '</span>
                            </button>
                            <span  class="material-icons styled-colored-el" style="padding-bottom:4px;">perm_identity</span>
                        </form>
                    </div>';
                break;
            default:
                $header =
                    '<div class="collapse navbar-collapse" id="menu">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                            <a class="nav-link" href="' . URL . 'index.php?action=searchroom">Rechercher une salle</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">  
                            <span class="material-icons icon-nav" >search</span>
                            <button  style="padding:0px"  type="button" class="btn" data-toggle="modal" data-target="#signIn">
                            <span  class="styled-colored-el signin">Me connecter</span>
                            </button>
                            <span  class="material-icons styled-colored-el" style="padding-bottom:4px;">perm_identity</span>
                        </form>
                    </div>';
                break;
        }
        return $header;
    }

    /**
     * return js file regarding the value of action and user
     */
    public function loadJs()
    {
        $output = "";
        $user = $this->getAccountName();
        if ($user == "client") :
            $output .= '';
        elseif ($user == "admin") :
            if (isset($_GET['action'])) :
                $output .= '<script src="dist/js/datatable.ini.js" ></script>';
                switch ($_GET['action']):
                    case 'salle':
                        $output .=
                            '<script src="dist/js/room.handler.js" ></script>';
                        break;
                    case 'produit':
                        $output .= '<script src="dist/js/product.handler.js" ></script> ';
                        break;
                    case 'membre':
                        $output .= '<script src="dist/js/member.handler.js" ></script> ';
                        break;
                    case 'avis':
                        $output .= '<script src="dist/js/post.handler.js" ></script> ';
                        break;
                    case 'commandes':
                        $output .= '<script src="dist/js/order.handler.js" ></script> ';
                        break;
                    case 'stats':
                        $output .= '<script src="dist/js/stats.handler.js" ></script> ';
                        break;
                endswitch;
            endif;
        else :
            $output .=
                '<script src="dist/js/control-fields-form.js" ></script> 
                <script src="dist/js/signin-signup.js" ></script>';
        endif;

        return $output;
    }
}
