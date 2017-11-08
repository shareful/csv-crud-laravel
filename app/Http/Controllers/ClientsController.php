<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ClientsController extends Controller
{

    /**
     * Clients Event Logger 
     *
     * @var \Monolog\Logger
     */
    protected $clientLog;

    /**
     * Constructor of ClientsController
     * Initialize Logger
     *
     * @return void
     */
    public function __construct(){
        $this->clientLog = new Logger('client');
        $this->clientLog->pushHandler(new StreamHandler(storage_path('logs/client.log')), Logger::INFO);
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
        
        // Pagination        
        $count = Client::getTotal();
        $page = $request->input('page') ? $request->input('page') : 1;

        $paginator = new Paginator([], $count, $limit, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);

        // Selecting records according to page number
        $offset = ($page-1)*$limit; // get records start from        
        
        $clients = Client::getRecords($offset, $limit);
        
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
        // Validation
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

        // Store data        
        if(!Client::create($request->all())){
            throw new \Exception('Client can not created.');
        }

        // keep this event log
        $this->clientLog->info('ClientLog', ['Client is created successfully']);

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
        $client = Client::getOne($id);

        if (!$client) {
            throw new \Exception('Client record not found.');
        }
        // print_r($client->toArray());exit();
        return view('clients.show', ['client' => $client]);
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
