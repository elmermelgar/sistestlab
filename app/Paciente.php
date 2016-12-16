<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    /**
     * @var string
     */
    private $documento_identidad;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido;


    /**
     * @var \DateTime
     */
    private $fecha_nacimiento;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $genero;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string;
     */
    private $profesion;

    /**
     * @return string
     */
    public function getDocumentoIdentidad()
    {
        return $this->documento_identidad;
    }

    /**
     * @param string $documento_identidad
     */
    public function setDocumentoIdentidad($documento_identidad)
    {
        $this->documento_identidad = $documento_identidad;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @param \DateTime $fecha_nacimiento
     */
    public function setFechaNacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param string $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * @param string $profesion
     */
    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;
    }

}
