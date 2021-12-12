<?php

namespace TCC\Modelo;

use TCC\Modelo\Abstrato\Modelo;
use Ramsey\Uuid\Uuid;

class DestinatarioEmail extends Modelo
{

    protected $id_destinatarioemail;
    protected $id_usuario;
    protected $id_email;
    protected $status;

    const ST_PENDENTE = 0;
    const ST_ENVIADO = 1;

    public function __construct()
    {
        if (func_num_args() != 0) {
            parent::__construct(func_get_args()[0]);
        }
        if($this->id_destinatarioemail==null || $this->id_destinatarioemail == ''){
            $this->id_destinatarioemail = Uuid::uuid4()->toString();
        }
    }

    public function getIdDestinatarioemail()
    {
        return $this->id_destinatarioemail;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function setIdDestinatarioemail($id_destinatarioemail): void
    {
        $this->id_destinatarioemail = $id_destinatarioemail;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function getIdEmail()
    {
        return $this->id_email;
    }

    public function setIdEmail($id_email): void
    {
        $this->id_email = $id_email;
    }



}