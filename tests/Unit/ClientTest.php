<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;

class ClientTest extends TestCase
{
    /**
     * Test client creation.
     *
     * @return void
     */
    public function testNewClient()
    {
    	$data = [
            'name' => 'UnitTest',
            'gender' => 'male',
            'phone' => '01716513782',
            'email' => 'km.shareful@gmail.com',
            'address' => 'khilgaon, dhaka',
            'nationality' => 'Bangladeshi',
            'birthDate' => '06/01/1984',
            'education' => '',
            'contactMode' => 'email',
        ];

        // test successfull client creation
        $instance = Client::create($data);
        $this->assertInstanceOf('App\Client', $instance);
        $this->assertEquals('UnitTest', $instance->name); 

        // Test failed to client creation for not having 9 column
        unset($data['education']); // unset to reduce array size
        $instance = Client::create($data);
        $this->assertFalse($instance);
    }

    /**
     * Test total client 
     *
     * @return void
     */
    public function testClientCount(){
    	$count = Client::getTotal();
    	$this->assertGreaterThan(0, $count);
    }

    /**
     * Test read multiple clients.
     *
     * @return void
     */
    public function testClientGetRecords(){
    	$offset = 0;
    	$limit = 2;
    	$clients = Client::getRecords($offset, $limit);
    	$this->assertGreaterThan(0, count($clients));
    }

    /**
     * Test read single client.
     *
     * @return void
     */
    public function testClientFetchOne(){
    	$offset = 1; // offset should be at least one because offset 0 is a header
    	$client = Client::getOne($offset);
    	$this->assertInstanceOf('App\Client', $client);

    	// test failed fetch single record
    	$offset = 100;
    	$client = Client::getOne($offset);
    	$this->assertFalse($client);
    }
}
