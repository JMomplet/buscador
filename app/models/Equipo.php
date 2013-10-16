<?php


class Equipo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var integer
     */
    public $liga_id;

    /**
     *
     * @var string
     */
    public $descripcion;

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'nombre' => 'nombre',
            'liga_id' => 'liga_id',
            'descripcion' => 'descripcion'
        );
    }

    public function initialize()
    {
        $this->hasMany('id', 'Partido', 'local_id');
        $this->hasMany('id', 'Partido', 'visitante_id');
    }
}
