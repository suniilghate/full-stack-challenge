<?php

namespace Otto;

class Challenge
{
    use PdoQueryBuilder;

    protected $pdoBuilder;
    protected $params;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.config.php';
        $this->setPdoBuilder(new PdoBuilder($config));
        $this->setPdoObject();
    }

    /**
     * Use the PDOBuilder to retrieve all the records based on request param
     *
     * @return array
     */
    public function fetchRecordsAsParam($requestParams) 
    {
        $this->params = $requestParams;
        switch ($requestParams[0]) {
            case 'records':
                $recordArr = $this->getRecords();
                break;

            case 'director':
                    $recordArr = $this->getDirectorRecords();
                    break;
                    
            case 'single-director':
                $recordArr = $this->getSingleDirectorRecord();
                break;
                
            case 'business':
                $recordArr = $this->getBusinessRecords();
                break;
                
            case 'single-business':
                $recordArr = $this->getSingleBusinessRecord();
                break;
                
            case 'businesses-registered-in-year':
                $recordArr = $this->getBusinessesRegisteredInYear();
                break;
                    
            case 'last-100':
                $recordArr = $this->getLast100Records();
                break;
                
            case 'business-name-with-director-fullname':
                $recordArr = $this->getBusinessNameWithDirectorFullName();
                break;    
            
            default:
                $recordArr = $this->getRecords();
                break;
        }
        // TODO
        

        return $recordArr;
    }
    /**
     * Use the PDOBuilder to retrieve all the records
     *
     * @return array
     */
    public function getRecords() 
    {
        // TODO
        $recordArr = $this->fetchRecords();
        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve all the director records
     *
     * @return array
     */
    public function getDirectorRecords() 
    {
        // TODO
        $recordArr = $this->fetchDirectorRecords();
        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve a single director record with a given id
     *
     * @param int $id
     * @return array
     */
    public function getSingleDirectorRecord()
    {
        // TODO
        $id = (!is_null($this->params[1]) || $this->params[1] != "") ? $this->params[1] : '';
        $recordArr = $this->fetchSingleDirectorRecord($id);
        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve all the business records
     *
     * @return array
     */
    public function getBusinessRecords() 
    {
        // TODO
        $recordArr = $this->fetchBusinessRecords();
        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve a single business record with a given id
     *
     * @param int $id
     * @return array
     */
    public function getSingleBusinessRecord() 
    {
        // TODO
        $id = (!is_null($this->params[1]) || $this->params[1] != "") ? $this->params[1] : '';
        $recordArr = $this->fetchSingleBusinessRecord($id);

        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve a list of all businesses registered on a particular year
     *
     * @param int $year
     * @return array
     */
    public function getBusinessesRegisteredInYear()
    {
        // TODO
        $year = (!is_null($this->params[1]) || $this->params[1] != "") ? $this->params[1] : '';
        $recordArr = $this->fetchBusinessesRegisteredInYear($year);

        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve the last 100 records in the directors table
     *
     * @return array
     */
    public function getLast100Records()
    {
        // TODO
        $recordArr = $this->fetchLast100Records();

        return $recordArr;
    }

    /**
     * Use the PDOBuilder to retrieve a list of all business names with the director's name in a separate column.
     * The links between directors and businesses are located inside the director_businesses table.
     *
     * Your result schema should look like this;
     *
     * | business_name | director_name |
     * ---------------------------------
     * | some_company  | some_director |
     *
     * @return array
     */
    public function getBusinessNameWithDirectorFullName()
    {
        // TODO
        $recordArr = $this->fetchBusinessNameWithDirectorFullName();

        return $recordArr;
    }

    /**
     * @param PdoBuilder $pdoBuilder
     * @return $this
     */
    public function setPdoBuilder(PdoBuilder $pdoBuilder)
    {
        $this->pdoBuilder = $pdoBuilder;
        return $this;
    }

    /**
     * @return PdoBuilder
     */
    public function getPdoBuilder()
    {
        return $this->pdoBuilder;
    }
}
