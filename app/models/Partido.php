<?php


class Partido extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $local_id;
     
    /**
     *
     * @var integer
     */
    public $goles_local;
     
    /**
     *
     * @var integer
     */
    public $visitante_id;
     
    /**
     *
     * @var integer
     */
    public $goles_visitante;
     
    /**
     *
     * @var integer
     */
    public $semana;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'local_id' => 'local_id', 
            'goles_local' => 'goles_local', 
            'visitante_id' => 'visitante_id', 
            'goles_visitante' => 'goles_visitante', 
            'semana' => 'semana'
        );
    }

    public function initialize()
    {
        $this->belongsTo('local_id','Equipo','id');
        $this->belongsTo('visitante_id','Equipo','id');
    }

}
