<?php

namespace App;

use Jenssegers\Model\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;


class Client extends Model
{

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'gender',
    	'phone',
    	'email',
    	'address',
    	'nationality',
        'birthDate',
    	'education',
    	'contactMode'
    ];

    /**
     * Csv filename 
     *
     * @var const
     */
    const FILENAME = "clients.csv";

    /**
     * Get storage path.
     *
     * @return string
     */
    public static function getStoragePath(){
    	return storage_path('app').'/'.self::FILENAME;
    }

    /**
     * Save a new client and return the instance.
     *
     * @param  array  $attributes
     * @return \App\Client|false
     */
    public static function create(array $attributes = [])
    {
    	$instance = new static((array) $attributes);
    
    	// save to csv file
    	try {
            // check whether file exist or not
            if (File::exists(self::getStoragePath())) {
                // File exist. So we just need to insert new $client
                $writer = Writer::createFromPath(self::getStoragePath(), 'a');
                
                // add validator so that cell count are same for all records
                $writer->addValidator(function (array $row): bool {
				    return 9 == count($row);
				}, 'row_must_contain_9_cells');
                $writer->insertOne($instance->toArray());

                // unset to close the file resource
        		unset($writer);
            } else {
                // File not exist. so this is the first insertion. 
                // We need to insert header too. Header goes to the offset 0
                $records = [
                    array_keys($instance->toArray()), // for csv header
                    $instance->toArray()
                ];
                $writer = Writer::createFromPath(self::getStoragePath(), 'w+');

                // add validator so that cell count are same for all records
                $writer->addValidator(function (array $row): bool {
				    return 9 == count($row);
				}, 'row_must_contain_9_cells');
                $writer->insertAll($records);

                // unset to close the file resource
        		unset($writer);
            }

            return $instance;
        } catch (CannotInsertRecord $e){
            // log which client insertion failed
            Log::error('Client creation failed. Reason:'.$e->getName().' Record: ', $e->getRecord());
            
            return false;
        }
    }

    /**
     * Get total number of records in csv file.
     *
     * @return int
     */
    public static function getTotal()
    {
    	$reader = Reader::createFromPath(self::getStoragePath(), 'r');
        $reader->setHeaderOffset(0); //set the CSV header offset to 0
        
        $total =  count($reader); // return total number of records
        // unset to close the file resource
        unset($reader);

        return $total;
    }

    /**
     * Get records from csv file.
     *
     * @param int $offset
     * @param int $limit
     * @return \App\Client[]
     */
    public static function getRecords($offset=0, $limit=null)
    {
    	$reader = Reader::createFromPath(self::getStoragePath(), 'r');
        $reader->setHeaderOffset(0); //set the CSV header offset to 0

        $clients = [];
    	if ($limit > 0) {
    		$stmt = (new Statement())
            ->offset($offset)
            ->limit($limit);
        	
        	$result = $stmt->process($reader);                

        	foreach ($result->getRecords() as $index => $record) {
	            $instance = new static($record);
                $instance->setAttribute('offset', $index);
	            $clients[] = $instance;
	        }
    	} else {
    		foreach ($reader->getRecords() as $index => $record) {
	            $instance = new static($record);
                $instance->setAttribute('offset', $index);
	            $clients[] = $instance;
	        } 		
    	}

    	// unset to close the file resource
        unset($reader);

    	return $clients;
    }

    /**
     * Get records from csv file.
     *
     * @param int $offset
     * @return \App\Client|false;
     */
    public static function getOne($offset)
    {
    	$reader = Reader::createFromPath(self::getStoragePath(), 'r');
        $reader->setHeaderOffset(0); // Set header offset always to 0
        
        // $offset is the nth offset of the record in csv file
        $stmt = (new Statement())
            ->offset($offset-1) // need to decrement 1 since we set header offset 0
            ->limit(1);
    
        // access the 0th record from the recordset (indexing starts at 0)
        $record = $stmt->process($reader)->fetchOne(0);
        
        // unset to close the file resource
        unset($reader);

        if (!empty($record)) {
        	$instance = new static($record);
            $instance->setAttribute('offset', $offset);
        	return $instance;
        } else {
        	return false;
        }
    }
}
