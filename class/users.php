<?php

class Users{
	
	public $objDb;
	public $objSe;
	public $result;
	public $rows;
	public $useropc;
	
	public function __construct(){
		
		$this->objDb = new Database();
		$this->objSe = new Sessions();
		
	}
	
	public function login_in(){

        $sth = $this->objDb->prepare('SELECT * FROM users U inner join profiles P '
            . 'on U.idprofile = P.idProfile WHERE U.loginUsers = :login AND U.passUsers = :pass');
            
            $sth->bindParam(':login', $_POST["usern"]);
            $sth->bindParam(':pass', $_POST["passwd"]);
            
            $sth->execute();
            
            $result = $sth->fetchAll();
            
            if($result){
                
                $profile = $result[0]['nameProfi'];
                
                switch($profile){
                    case 'Standard':
                        $this->objSe->init();
                        $this->objSe->set('idUser', $result[0]['idUsers']);
                        $this->objSe->set('loginUsers', $result[0]['loginUsers']);
                        $this->objSe->set('nameProfi', $result[0]['nameProfi']);
                        $this->objSe->set('idProfile', $result[0]['idProfile']);                        
                        echo "Ha ingresado como Ususario Standard";
                        echo '<a href="log_out.php">Cerrar</a>';
                        //header('Location: user/index.php');
			break;
                    case 'Admin':
                        $this->objSe->init();
                        $this->objSe->set('idUser', $result[0]['idUsers']);
                        $this->objSe->set('loginUsers', $result[0]['loginUsers']);
                        $this->objSe->set('nameProfi', $result[0]['nameProfi']);
                        $this->objSe->set('idProfile', $result[0]['idProfile']);                        
                        echo "Ha ingresado como Ususario Administrador";
                        echo '<br><a href="log_out.php">Cerrar</a>';
                        //header('Location: admin/index.php');
			break;
                }
                
            }else{
                header('Location: index.php?error=1');
            }		
	}
	
}

?>