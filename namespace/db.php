<?php
    //create a classs to make all the operations on the database using PDO class
    //include_once "../lib/globals.php";
    namespace lib;
    use PDO;
    use PDOException;
    use PDOStatement;
   // require_once "..\\lib\\globals.php";
    //require_once "E:\\scuola\\xampp\\htdocs\\PranziOnLine\\lib\\globals.php";
    //require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\globals.php";

    //include_once Globals::autoload("globals.php");

    class DB{
        private string $error = "";
        private PDO | false | null $pdo = null;
        private PDOStatement | false | null $query = null;

        public function __construct(){
            try{
                $this->pdo = new PDO(
                    Globals::getDSN(), 
                    Globals::$username,
                    Globals::$password, 
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                //return ["outcome" => true];
            }catch(PDOException $e){
                return ["outcome" => false, "message" => $e->getMessage()];
            }
        }
        
        /* public function open(){
            
        } */

        //close the connection
        public function close(): void{
            $this->pdo = null;
        }

        public function query(string $query, array $parameters = [], int $fetch_mode = PDO::FETCH_BOTH): bool|array {
            try{
                $query = trim(str_replace('\r', " ", $query));
                $this->query = $this->pdo->prepare($query);
                if(!empty($parameters)) {
                    foreach ($parameters as $value) {
                        if(is_int($value[1])) {
                            $type = PDO::PARAM_INT;
                        } else if(is_bool($value[1])) {
                            $type = PDO::PARAM_BOOL;
                        } else if(is_null($value[1])) {
                            $type = PDO::PARAM_NULL;
                        } else {
                            $type = PDO::PARAM_STR;
                        }
                        // Add type when binding the values to the column
                        $this->query->bindValue($value[0], $value[1], $type);
                    }
                }

                if($this->query->execute()){
                    $rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
                    $statement = strtolower($rawStatement[0]);

                    if ($statement === "select" || $statement === "show")
                        return $this->query->fetchAll($fetch_mode);
                    elseif ($statement === "insert" || $statement === "update" || $statement === "delete")
                        return $this->query->rowCount();
                }
                else
                    return ["outcome" => false, "message" =>  $this->query->errorInfo()];
            }
            catch(PDOException $e){
               return ["outcome" => false, "message" => $e->getMessage()];
            }
        }
        public function last_insert_ID(): bool|string {
            return $this->pdo->lastInsertId();
        }
    }

?>
