<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ClientsController extends Controller
{
    
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

        $data = [
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
        Client::create($data);
        
        
        // Client::create($request->all());
    
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
