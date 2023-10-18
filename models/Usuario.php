<?php


namespace Model;

class usuario extends ActiveRecord
{
    //base de datos
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'phone', 'user_password', 'administrador', 'confirmado', 'token'];

    public $id = null;
    public $nombre = '';
    public $apellido = '';
    public $email = '';
    public $phone = '';
    public $user_password = '';
    public $confirm_password = '';
    public $administrador = null;
    public $confirmado = null;
    public $token = '';

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->user_password = $args['user_password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
        $this->administrador = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    //mensajes de validacion para la creacion de cuentas
    // es publica la clase por que se va a usar fuera de la clase en login controller
    public function validarRegistro()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El campo Nombre es obligatorio";
        } elseif(strlen($this->nombre)>64){
            self::$alertas['error'][] = "El Nombre es demasiado largo";
        }


        if (!$this->apellido) {
            self::$alertas['error'][] = "El campo Apellido es obligatorio";
        }elseif(strlen($this->nombre)>64){
            self::$alertas['error'][] = "El apellido es demasiado largo";
        }

        if (!empty($this->email)) {
            // Expresión regular para validar un correo electrónico
            $regex = '/^[A-Za-z0-9._%+-]{1,64}@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
            if (!preg_match($regex, $this->email)) {
                self::$alertas['error'][] = "El formato del correo electrónico no es válido";
            }
        } else {
            self::$alertas['error'][] = "El campo Email es obligatorio";
        }



        if (!$this->phone) {
            self::$alertas['error'][] = "El campo Telefono es obligatorio";
        } elseif (!preg_match("/^[0-9]+$/", $this->phone)) {
            self::$alertas['error'][] = "El campo Teléfono solo debe contener números";
        }elseif(strlen($this->phone)>11 ||strlen($this->phone)<9){
            self::$alertas['error'][] = "Fromato de telefono invalido";   
        }

        if (strlen($this->user_password)>=8 ){
            if (!$this->user_password) {
                self::$alertas['error'][] = "El campo Password es obligatorio";
            } else if (strlen($this->user_password) < 8) {
                self::$alertas['error'][] = "La contraseña debe tener 8 caracteres como minimo";
            }
    
            if (!$this->confirm_password) {
                self::$alertas['error'][] = "El campo Confirm Password es obligatorio";
            }
            if (($this->user_password && $this->confirm_password) && ($this->user_password !== $this->confirm_password)) {
                self::$alertas['error'][] = "Las contraseñas no coinciden";
            }
        } else{
            self::$alertas['error'][] = "Las contraseña debe tener 8 caracteres como minimo";
        }


 
        return self::$alertas;
    }

    public function existeUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultEmail = self::$db->query($query);
        $rowCount = mysqli_num_rows($resultEmail);
        if ($rowCount != 0) {
            self::$alertas['error'][] = "El Email ya se encuentra en uso";
        }

        $query = "SELECT * FROM " . self::$tabla . " WHERE phone = '" . $this->phone . "' LIMIT 1";
        $resultPhone = self::$db->query($query);
        $rowCount = mysqli_num_rows($resultPhone);
        if ($rowCount != 0) {
            self::$alertas['error'][] = "El Número de Telefono ya se encuentra en uso";
        }

        return self::$alertas;
    }

    public function hashPassword()
    {
        $this->user_password = password_hash($this->user_password, PASSWORD_BCRYPT);
    }

    public function samePassword()
    {
        $query = "SELECT email, user_password FROM " . self::$tabla;
        $resultUsers = self::$db->query($query);

        if ($resultUsers) {
            // Usar fetch_assoc para obtener cada fila como un arreglo asociativo
            while ($row = $resultUsers->fetch_assoc()) {
                // $row contiene los valores de email y user_password para cada fila
                $email = $row['email'];
                $userPassword = $row['user_password'];

                if (password_verify($this->confirm_password, $userPassword)) {
                    self::$alertas['error'][] = "La contraseña " . $this->confirm_password . " ya esta siendo usada por: " . $email;
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

    public function crearToken()
    {
        //genera un token unico
        $this->token = uniqid();

    }

    public function primeraMayuscula(){
        $this->nombre = ucfirst($this->nombre) ;
        $this->apellido = ucfirst($this->apellido);
    }

    public function validarLogin(){
        if (!$this->email) {
            self::$alertas['error'][] = "El campo Email es obligatorio";
        }
        if (!$this->user_password) {
            self::$alertas['error'][] = "El campo Password es obligatorio";
        }
        return self::$alertas;
    }

    public function validarPassword($passwordLoguin)
    {        
        if(password_verify($passwordLoguin, $this->user_password)){
            
            if($this->confirmado != 1){
                self::$alertas['error'][] = "Revise su bandeja de entrada para confirmar el correo";
            }

        } else{
            self::$alertas['error'][] = "Contraseña Incorrecta";
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = "El campo Email es obligatorio";
        }
        return self::$alertas;
    }

    public function ValidarCambioPassword($user_password,$confirm_password ){
        if (strlen($user_password)>=8 ){
            if (!$user_password) {
                self::$alertas['error'][] = "El campo Password es obligatorio";
            }
            if (!$confirm_password) {
                self::$alertas['error'][] = "El campo Confirm Password es obligatorio";
            }
            if (($user_password && $confirm_password) && ($user_password !== $confirm_password)) {
                self::$alertas['error'][] = "Las contraseñas no coinciden";
            }
        } else{
            self::$alertas['error'][] = "Las contraseña debe tener 8 caracteres como minimo";
        }

        return self::$alertas;
    }

    


}
