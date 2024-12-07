<?php
class Vehiculo{
    private $id = 0;
    private $placa ="";
    private $modelo ="";
    private $marca ="";
    private $interno ="";
    private $propietario ="";

    public function __get($atributo){
        if(isset($this->$atributo)){
            return $this->$atributo;
        }else{
            echo "El atributo Ingresado No Existe";
        }
    }

    public function __set($atributo,$valor){
        if(isset($this->$atributo)){
            $this->$atributo = $valor;
        }else{
            echo "El atributo Ingresado No Existe";
        }
    }

    public function guardarDatos(){
        if($this->id > 0){
            $sql ="UPDATE vehiculos set placa ='{$this->placa}',modelo ='{$this->modelo}',
            marca ='{$this->marca}',interno ='{$this->interno}',propietario ='{$this->propietario}' WHERE id = '{$this->id}'";


            mysqli_query(Conexion::obtenerConexion(),$sql) or die ("Problemas al Actualizar los datos");

            //echo "Datos Actualizados";

        }else{ 
            $sql="INSERT INTO vehiculos (placa,modelo,marca,interno,propietario)VALUES
                ('{$this->placa}','{$this->modelo}','{$this->marca}','{$this->interno}',
                    '{$this->propietario}')";

            mysqli_query(Conexion::obtenerConexion(),$sql) or die ("Problemas al Insertar los datos");

            echo "Datos Insertados";
        }  
    }

    public function listarDatos(){
        $sql = "SELECT * FROM vehiculos";

        $datos = mysqli_query(Conexion::obtenerConexion(),$sql)
            or die ("Problemas al leer los datos");

        $contador = 1;
        while($fila = mysqli_fetch_assoc($datos)){
            echo<<<fila
                <tr>
                    <td>{$contador}</td>
                    <td>{$fila['Placa']}</td>
                    <td>{$fila['Modelo']}</td>
                    <td>{$fila['Marca']}</td>
                    <td>{$fila['Interno']}</td>
                    <td>{$fila['Propietario']}</td>
                    <td><a href = "index.php?borrar={$fila['id']}"><img src = "../img/Eliminar.png" /></a></td>
                    <td><a href = "index.php?modificar={$fila['id']}"><img src = "../img/Editar.png" /></a></td>
                </tr>

fila;            
        $contador++;
        }

    }
    
    public function borrarDatos($id){
        $sql = "DELETE FROM vehiculos where id = {$id}";

        mysqli_query(Conexion::obtenerConexion(),$sql)
        or die ("Problemas al Borrar los datos");

      //  echo"<script type ='text/javascript'> alert('Datos Eliminados')</script";
    }

    public function cargarDatos($id){
        $sql ="select * from vehiculos where id ={$id}";

        $datos = mysqli_query(Conexion::obtenerConexion(),$sql)
            or die ("Problemas al leer los datos");

        if(mysqli_num_rows($datos) > 0){
            $datos2 = mysqli_fetch_assoc($datos);
            $this->placa = $datos2['Placa'];
            $this->modelo = $datos2['Modelo'];
            $this->marca = $datos2['Marca'];
            $this->interno = $datos2['Interno'];
            $this->propietario = $datos2['Propietario'];
            $this->id = $datos2['id'];
        } 
    }

}

?>