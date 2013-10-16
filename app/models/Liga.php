<?php


class Liga extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $pais;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'nombre' => 'nombre', 
            'pais' => 'pais'
        );
    }

}
