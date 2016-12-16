<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /**
     * @var string
     */
    protected $table='clientes';

    /**
     * @var boolean
     */
    protected $timestamps=false;

    /**
     * @var string
     */
    private $documento_identidad;

    /**
     * @var string
     */
    private $razon_social;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $telefono;

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
    public function getRazonSocial()
    {
        return $this->razon_social;
    }

    /**
     * @param string $razon_social
     */
    public function setRazonSocial($razon_social)
    {
        $this->razon_social = $razon_social;
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

}
