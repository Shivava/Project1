<!--Gemaakt door furkan ucar OITAOO8B -->
  <?php
  //class database aan gemaakt
  class database{
    // class met allemaal private variables aangemaakt (property)
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    // maakt class constants (admin en user)
    const ADMIN = 1; // these are the values from the db
    const USER = 2;

    public function __construct($host, $user, $pass, $db, $charset){
      $this->host = $host;
      $this->user = $user;
      $this->pass = $pass;
      $this->charset = $charset;

      try {
          $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
          $options = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES   => false,
          ];

          $this->pdo = new PDO($dsn, $user, $pass, $options);
      } catch (\PDOException $e) {
          echo $e->getMessage();
          throw $e;
          // throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    // helper functie om te kijken of al een account bestaad zodat er geen twee accounts kunnen aangemaakt worden
    // private function is_new_account($username){
    //     //controlleerd of de naam al erin is
    //     $stmt = $this->db->prepare('SELECT * FROM account WHERE username=:username');
    //     $stmt->execute(['username'=>$username]);
    //     $result = $stmt->fetch();
    //
    //     if(is_array($result) && count($result) > 0){
    //         return false;
    //     }
    //     //als het true result betekent dat een account al bestaat
    //     return true;
    // }

    private function create_or_update_account($username, $email, $pass){
      // todo: fixme: add usertype_id to the account table (bij de insert fk ref)
      // maak een sql statement (type string)
      $query = "INSERT INTO account
            (id, usertype_id, username, email, password, created_at, updated_at)
            VALUES
            (NULL, :usertype_id, :username, :email, :password, :created_at, :updated_at)";

      // prepared statement -> statement zit een statement object in (nog geen data!)
      $statement = $this->pdo->prepare($query);

      // password hashen
      $hashed_password =  password_hash($pass, PASSWORD_DEFAULT);

      // zet de huidige tijd
      $created_at = $updated_at = date('Y-m-d H:i:s');

      // execute de statement (deze maakt de db changes)
      $statement->execute([
        'usertype_id'=>self::USER,
        'username'=>$username,
        'email'=>$email,
        'password'=>$hashed_password,
        'created_at'=> $created_at,
        'updated_at'=> $updated_at
      ]);

      // haalt de laatst toegevoegde id op uit de db
      $account_id = $this->pdo->lastInsertId();
      return $account_id;
    }

    private function create_or_update_persoon($firstname, $middlename, $lastname, $account_id){
      // table person vullen
      $query = "INSERT INTO persoon
            (id, account_id, firstname, middlename, lastname, created_at, updated_at)
            VALUES
            (NULL, :account_id, :firstname, :middlename, :lastname, :created_at, :updated_at)";

      // returned een statmenet object
      $statement = $this->pdo->prepare($query);

      // zet de huidige tijd
      $created_at = $updated_at = date('Y-m-d H:i:s');

      // execute prepared statement
      $statement->execute([
        'account_id'=>$account_id,
        'firstname'=>$firstname,
        'middlename'=>$middlename,
        'lastname'=>$lastname,
        'created_at'=> $created_at,
        'updated_at'=> $updated_at
      ]);

      $persoon_id = $this->pdo->lastInsertId();
      return $persoon_id;
    }

    // public function populate_table_usertype(){
    //   // zorg ervoor dat er data geschreven wordt naa de
    //   try{
    //     $this->pdo->beginTransaction();
    //
    //     $sql = "INSERT INTO usertype (id, type, created_at, updated_at) VALUES
    //     (NULL, :type, :created_at, :updated_at), (NULL, :type1, :created_at1, :updated_at1)";
    //
    //     $stmt = $this->pdo->prepare($sql);
    //
    //     $created_at = $updated_at =  date('Y-m-d H:i:s');
    //
    //     $assoc = [
    //       'type'=>'admin',
    //       'created_at'=>$created_at,
    //       'updated_at'=>$updated_at,
    //       'type1'=> 'user',
    //       'created_at1'=>$created_at,
    //       'updated_at1'=>$updated_at
    //     ];
    //
    //     $stmt->execute($assoc);
    //
    //     $this->pdo->commit();
    //
    //   }catch(Exception $e){
    //     echo $e->getMessage();
    //   }
    // }

    public function create_or_update_user($username, $firstname, $middlename, $lastname, $pass, $email){

      try{
        // begin een database transaction
        $this->pdo->beginTransaction();

        $account_id = $this->create_or_update_account($email, $pass, $username);

        $this->create_or_update_persoon($firstname, $middlename, $lastname, $account_id);

        // het commit de changes die zijn uitgevoerd
        $this->pdo->commit();

          // bekijkt of er een sessie is en kijkt of het admin is
        if(isset($_SESSION) && $_SESSION['usertype'] == self::ADMIN){
            return "New user has been succesfully added to the database";
        }


        header("location:login.php");
        exit();

      }catch(Exception $e){
        // undo db changes in geval van error
        $this->pdo->rollback();
        // geeft door dat het gefaald is en zet een error message in het log
        echo "Signup failed: " . $e->getMessage();
      }
    }

    // functie bekijkt of de user admin is of niet
    private function is_admin($username){
        // haalt de data op van het DB om te kijken of de user wel een admin is
        $query = "SELECT usertype_id FROM account WHERE username = :username";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['username'=>$username]);

        // resultaat word in een associative array gezet
        $result = $stmt->fetch();

        if($result['usertype_id'] == self::ADMIN){
        // als het true returned betekent het dat de account wel admin is
            return true;
        }

        // als het false returned betekent het dat de account geen admin is
        return false;
    }

    public function authenticate_user($username, $pass){
      // hoe logt te user in? email of username of allebei? = username
      // haal de user op uit account a.d.h.v. de username
      // als database match, dan haal je het password (query with pdo)
      // $hashed_password = password uit db (matchen met $pass)
      // alle alle data overeen komt, dan kun je redirecten naar een interface
      // stel geen match -> username and/or password incorrect message

      // echo hi $_SESSION['username']; htmlspecialchars()

      // maak een statement object op basis van de mysql query en sla deze op in $stmt
      $query = "SELECT id, usertype_id, password FROM account WHERE username = :username";

      $stmt = $this->pdo->prepare($query);
      // voorbereide instructieobject wordt uitgevoerd.
      $stmt->execute(['username' => $username]); //-> araay
      $result = $stmt->fetch(); // returned een array

      // checkt of $result een array is
      if(is_array($result)){

          // voerd count uit als #result een array is
          if(count($result) > 0){

              // pakt de gehashed wachtwoord van de database met de key 'password'
              $hashed_password = $result['password'];

              // verifieerd accounts die bestaan met de gegeven wachtwoord en checkt of het zelfde is als de gehashde wachwoord
              if($username && password_verify($pass, $hashed_password)){
                  session_start();

                  // slaat userdata in sessie veriable
                  $_SESSION['id'] = $result['id'];
                  $_SESSION['username'] = $username;
                  $_SESSION['usertype'] = $result['usertype_id'];
                  $_SESSION['loggedin'] = true;

                  // controlleerd of de user een admin is, als het een admin is redirct naar de admin pagina
                  // als het account geen admin is, redirect naar user page
                  if($this->is_admin($username)){
                      header("location: welcome_admin.php");
                      // redirects naar welcome_admin pagina
                      exit;
                  }else{
                      // redirects naar welcome_user pagina
                      header("location: welcome_user.php");
                      exit;
                  }

              }else{
                  // stuurt een error message
                  return "Incorrect username and/or password. Please fix your input and try again.";
              }
          }
      }else{
          // niks gevonden in de database. laat het de gebruiker niet weten!
          return "Failed to login. Please try again";
      }
  }
  // haalt gegevens van het database op
  public function show_profile_details_user($username){
  // gebruikt inner join om specifieke gegevens op te halen
      $sql = "
          SELECT a.id, u.type, p.firstname, p.middlename, p.lastname, a.username, a.email
          FROM person as p
          LEFT JOIN account as a
          ON p.account_id = a.id
          LEFT JOIN usertype as u
          ON a.type_id = u.id
      ";

      if($username !== NULL){
          // een query voor specifieke user wanneer een username gegeven is
          $sql .= 'WHERE a.username = :username';
      }

      $stmt = $this->db->prepare($sql);

      // checkd of username gegeven is, als het gedaan is execture de associative arraya
      $username !== NULL ? $stmt->execute(['username'=>$username]) : $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
  }

}
?>
