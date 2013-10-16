<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        //Obtenemos el POST con la busqueda y lo asignamos a una variable
        $search = $this->request->getPost("search");

        //Creamos un objeto Solr para acceder al core 'equipos' y realizamos la busqueda formateando
        //la query para que busque que estén todas las palabras en el resultado
        $solr = new Solr('equipos');
        $solr->setQuery($search, 'and');
        $result = $solr->getResult(true);

        if ($result->response->numFound == 1) {
            //Si el resultado es el esperado, asignaremos los valores necesarios a variables en el view
            $this->view->setVar("tipo", "equipo");
            $this->view->setVar("equipo", $result->response->docs[0]);
        } else {
            //En caso de no obtener un equipo, pasamos a hacer la query para obtener los 2 equipos que más
            //encajan con la búsqueda
            $solr->setQuery($search, 'all');
            $result = $solr->getResult(true);
            $equipo1 = $result->response->docs[0];
            $equipo2 = $result->response->docs[1];

            //Pasamos al core 'partidos' para buscar los partidos de ambos equipos
            $solr->setCore('partidos');
            $query = 'local_id:(' . $equipo1->id . ' ' . $equipo2->id . ') AND ' .
                'visitante_id:(' . $equipo1->id . ' ' . $equipo2->id . ')';
            $solr->setQuery($query);
            $result = $solr->getResult(true);

            if($result->response->numFound > 0){
                //Si hay resultados de partidos jugados, pasaremos los datos necesarios al view
                $this->view->setVar("tipo", "partidos");
                $this->view->setVar("equipo1", $equipo1);
                $this->view->setVar("equipo2", $equipo2);
                $this->view->setVar("partidos", $result->response->docs);
                $this->view->setVar("query", $query);
            } else {
                //Si no, le asignaremos que está vacio
                $this->view->setVar("tipo", "vacio");
            }
        }
    }
}

