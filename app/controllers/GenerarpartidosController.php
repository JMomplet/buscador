<?php

class GenerarpartidosController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $liga = $this->request->get('liga');

        //Accedemos a los equipos de la liga recibida por GET
        $equipos = Equipo::find(array(
            "liga_id = '" . $liga . "'",
            "order" => "id"
        ));



        if ($equipos) {
            //Eliminamos de la base de datos los partidos jugados por esos equipos
            foreach ($equipos as $equipo) {
                $equipo->partido->delete();
            }

            //Guardamos en variables los valores necesarios en la asignación de partidos
            $id_inicial = $equipos[0]->id;
            $num_equipos = count($equipos);
            $num_semanas = 20;

            $partidos_semana = (int)($num_equipos / 2);
            $incremento = $id_inicial - 1;

            //Asignamos los partidos
            for ($semana = 1; $semana <= $num_semanas; $semana++) {
                for ($partido = 1; $partido <= $partidos_semana; $partido++) {

                    $local_id = $partido + ($semana - 1) + $incremento;
                    $visitante_id = (($num_equipos - $partido + 1) + ($semana - 1)) + $incremento;

                    if ($local_id > ($num_equipos + $incremento))
                        $local_id -= $num_equipos;

                    if ($visitante_id > ($num_equipos + $incremento))
                        $visitante_id -= $num_equipos;

                    if ($semana > $num_semanas / 2) {
                        $visitante_id -= 1;
                        if ($partido == 10)
                            $visitante_id += 10;
                    }

                    //Guardamos en la base de datos el partido
                    $obj = new Partido();
                    $obj->local_id = $local_id;
                    $obj->goles_local = rand(0, 5);
                    $obj->visitante_id = $visitante_id;
                    $obj->goles_visitante = rand(0, 5);
                    $obj->semana = $semana;
                    $obj->save();
                }
            }

            //Tras haber asignado todos los partidos, pasamos a actualizar los datos en Solr
            $solr = new Solr('partidos');
            $solr->dataImport(true);

            echo '<h1>Partidos generados</h1>';
        } else {
            echo '<h1>No se ha podido generar partidos</h1>';

        }
    }
}

