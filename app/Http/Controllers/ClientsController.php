<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;

class ClientsController extends Controller
{
    /**
     * Csv filename 
     *
     * @param const FILENAME contains csv filename 
     */
    const FILENAME = "clients.csv";

    /**
     * Storage path location 
     *  
     * @param string $storagePath
     */
    protected $soragePath;

    /**
     * Constructor of ClientsController
     * 
     * @return void
     */
    public function __construct(){
        $this->storagePath = storage_path('app').'/'.self::FILENAME;
    }

    /**
     * Display a listing of the clients.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $limit = 2; // get number of records
        
        $csv = Reader::createFromPath($this->storagePath, 'r');
        $csv->setHeaderOffset(0); //set the CSV header offset to 0
        
        // Pagination
        $count = count($csv); // return total number of records
        $page = $request->input('page') ? $request->input('page') : 1;

        $paginator = new Paginator([], $count, $limit, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);

        // Selecting records according to page number
        $offset = ($page-1)*$limit; // get records start from        
        
        $stmt = (new Statement())
            ->offset($offset)
            ->limit($limit);
        $result = $stmt->process($csv);        
        
        $clients = [];
        foreach ($result->getRecords() as $index => $record) {
            $record['offset'] = $index;
            $clients[] = (object) $record;
        }
        
        return view('clients.list', ['clients' => $clients, 'paginator' => $paginator]);
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required',
            'email' => 'bail|required|email',
            'address' => 'bail|required',
            'nationality' => 'bail|required',
            'birthDate' => 'bail|required|date_format:"m/d/Y"',
            'contactMode' => 'bail|required',
        ]);

        $client = [
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'nationality' => $request->input('nationality'),
            'birthDate' => $request->input('birthDate'),
            'education' => $request->input('education'),
            'contactMode' => $request->input('contactMode'),
        ];
        
        try {
            // check whether file exist or not
            if (File::exists($this->storagePath)) {
                // File exist. So we just need to insert new $client
                $writer = Writer::createFromPath($this->storagePath, 'a');
                $writer->insertOne($client);
            } else {
                // File not exist. so this is the first insertion. 
                // We need to insert header too. Header goes to the offset 0
                $clients = [
                    array_keys($client), // for csv header
                    $client
                ];
                $writer = Writer::createFromPath($this->storagePath, 'w+');
                $writer->insertAll($clients);
            }
        } catch (CannotInsertRecord $e){
            // log which client insertion failed
            echo $e->getName();
            echo $e->getData();
        }

        return redirect('clients');
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @throws Exception if client not found
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reader = Reader::createFromPath($this->storagePath, 'r');
        $reader->setHeaderOffset(0); // Set header offset always to 0

        // $id is the nth offset of the record in csv file
        $stmt = (new Statement())
            ->offset($id-1) // need to decrement 1 since we set header offset 0
            ->limit(1);
    
        // access the 0th record from the recordset (indexing starts at 0)
        $client = $stmt->process($reader)->fetchOne(0);
        if (empty($client)) {
            throw new \Exception('Client record not found.');
        }
        
        return view('clients.show', ['client' => (object)$client]);
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
