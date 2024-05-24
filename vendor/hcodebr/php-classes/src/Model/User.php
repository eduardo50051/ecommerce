<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;


class User extends Model{

    const SESSION = "User";

    public static function login($login, $password){

        $sql = new SqL();

        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if (count($results) === 0){
            return false;
            throw new \Exception("Usuário Inexistente ou senha inválida");
            

        }


        $data = $results[0];

        if (password_verify($password, $data["despassword"]) === true) {

            $user = new User();

            $user->setData($data);
           
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;




        } else{

            throw new \Exception("Usuário Inexistente ou senha inválida");

        }



    }


    public static function verifyLogin($inadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ){ 

            header("Location: /ecommerce/admin/login");
            exit;

        }
    }

    public static function logout(){
        $_SESSION[User::SESSION] = NULL;
    }


    public static function listAll(){

        $sql = new SqL();

       return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");


    }



    public function get($iduser)
    {
     
     $sql = new Sql();
     
     $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser;", array(
     ":iduser"=>$iduser
     ));
     
     $data = $results[0];
     
     $this->setData($data);
     
     }

     public function save(){

        $sql = new SqL();


        $results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>$this->despassword(),
            ":desemail"=>$this->desemail(),
            ":nrphone"=>$this->desrnphone(),
            ":inadmin"=>$this->getinadmin()
        ));

        $this->setData($results[0]);

     }


}



?>