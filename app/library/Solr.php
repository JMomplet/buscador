<?php

/**
 * Class Solr
 *
 * Clase para facilitar el acceso a los datos de Solr
 */
class Solr
{
    /**
     * @var string
     */
    protected $host = "http://localhost:8983";
    /**
     * @var string
     */
    protected $core;
    /**
     * @var string
     */
    protected $reqHandler = "/select";
    /**
     * @var string
     */
    protected $query;
    /**
     * @var string
     */
    protected $format = 'json';
    /**
     * @var object|null
     */
    protected $result = null;

    /**
     * @param string $core
     */
    public function setCore($core)
    {
        $this->core = $core;
    }

    /**
     * @return string
     */
    public function getCore()
    {
        return $this->core;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Con esta función introduciremos la query a realizar.
     *
     * En caso de no introducir modo, no se procesará. Se han incluido los modos necesarios para este buscador.
     *
     * @param string $query
     * @param string|null $mode
     */
    public function setQuery($query, $mode = null)
    {
        if (!is_null($mode)) {
            switch ($mode) {
                case 'and':
                    $query = str_replace(' ', ' AND ', $query);
                    break;
                case 'all':
                    $query = str_replace(' ', ' OR ', $query);
                    break;
            }
        }
        $this->query = 'q=' . urlencode($query);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $reqHandler
     */
    public function setReqHandler($reqHandler)
    {
        $this->reqHandler = $reqHandler;
    }

    /**
     * @return string
     */
    public function getReqHandler()
    {
        return $this->reqHandler;
    }

    /**
     * @param bool $update Determinará si volver a obtener los datos de Solr si ya se han obtenido con anterioridad
     * @return null|object
     */
    public function getResult($update = false)
    {
        if (is_null($this->result) || $update) {
            $url = $this->getFullPath() . '&' . $this->query;

            $curl = curl_init($url);
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => TRUE,
            ));
            $data = curl_exec($curl);
            curl_close($curl);
            $this->result = json_decode($data);
        }

        return $this->result;
    }


    /**
     * @param $core
     */
    public function __construct($core)
    {
        $this->setCore($core);
    }

    /**
     * @return string
     */
    protected function getFullPath()
    {
        return $this->host . '/solr/' . $this->core . $this->reqHandler .
        '?wt=' . $this->format;
    }

    /**
     * @param bool $fullImport
     */
    public function dataImport($fullImport = false)
    {
        $url = $this->host . '/solr/' . $this->core . '/dataimport';
        if ($fullImport)
            $url .= "?command=full-import";
        else
            $url .= "?command=delta-import";

        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => TRUE,
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}