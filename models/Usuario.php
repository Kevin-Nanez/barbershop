<?php 


namespace Model;

class usuario extends ActiveRecord{
    //base de datos
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id','nombre','apellido','email','phone','user_password','confirm_password','admin','confirmado','token'];

    public $id = null;
    public $nombre = '';
    public $apellido = '';
    public $email = '';
    public $phone = '';
    public $user_password = '';
    public $confirm_password = '';
    public $admin = null;
    public $confirmado = null;
    public $token = '';

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->user_password = $args['user_password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
        $this->admin = $args['admin'] ?? null;
        $this->confirmado = $args['confirmado'] ?? null;
        $this->token = $args['token'] ?? '';

    }

    //mensajes de validacion para la creacion de cuentas
// es publica la clase por que se va a usar fuera de la clase en login controller
    public function validarRegistro()
    {
        if(!$this->nombre){
            self::$alertas['error'][] = "El campo Nombre es obligatorio";
        }
        if(!$this->apellido){
            self::$alertas['error'][] = "El campo Apellido es obligatorio";
        }
        if (!empty($this->email)) {
            // Expresión regular para validar un correo electrónico
            $regex = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
        
            if (preg_match($regex, $this->email)) {
                // El correo electrónico es válido
            } else {
                self::$alertas['error'][] = "El formato del correo electrónico no es válido";
            }
        } else {
            self::$alertas['error'][] = "El campo Email es obligatorio";
        }
        if(!$this->phone){
            self::$alertas['error'][] = "El campo Telefono es obligatorio";
        }
        if(!$this->user_password){
            self::$alertas['error'][] = "El campo Password es obligatorio";         
        }else if(strlen($this->user_password)<8){
        self::$alertas['error'][] = "La contraseña debe tener 8 caracteres como minimo";   
        }

        if(!$this->confirm_password){
            self::$alertas['error'][] = "El campo Confirm Password es obligatorio";  
        }
        if(($this->user_password && $this->confirm_password) && ($this->user_password !== $this->confirm_password)){
            self::$alertas['error'][] = "Las contraseñas no coinciden";  
        }
        return self::$alertas;
     
    }

    public function existeUsuario(){
        $query = "SELECT * FROM ".self::$tabla . " WHERE email = '". $this->email . "' LIMIT 1";
        $resultEmail = self::$db->query($query);
        $rowCount = mysqli_num_rows($resultEmail);
        if($rowCount != 0){
            self::$alertas['error'][] = "El Email ya se encuentra en uso";  
        }

        $query = "SELECT * FROM ".self::$tabla . " WHERE phone = '". $this->phone . "' LIMIT 1";
        $resultPhone = self::$db->query($query);
        $rowCount = mysqli_num_rows($resultPhone);
        if($rowCount != 0){
            self::$alertas['error'][] = "El Número de Telefono ya se encuentra en uso";  
        }

        return self::$alertas;
    }

    public function hashPassword(){
        $this->user_password = password_hash($this->user_password,PASSWORD_BCRYPT);
    }

    public function samePassword(){
        $query = "SELECT email, user_password FROM ". self::$tabla;
        $resultUsers = self::$db->query($query);
        
        if ($resultUsers) {
            // Usar fetch_assoc para obtener cada fila como un arreglo asociativo
            while ($row = $resultUsers->fetch_assoc()) {
                // $row contiene los valores de email y user_password para cada fila
                $email = $row['email'];
                $userPassword = $row['user_password'];
        
                if(password_verify($this->confirm_password, $userPassword)){
                    self::$alertas['error'][] = "La contraseña ".$this->confirm_password." ya esta siendo usada por: " . $email; 
                
                }
            }
            // Liberar los resultados después de usarlos
            $resultUsers->free();
        } else {
            // Manejar el error si la consulta falla
            echo "No hay coincidencias";
        }
        return self::$alertas;

    }

}

