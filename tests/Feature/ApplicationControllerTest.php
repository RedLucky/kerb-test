<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicationControllerTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_check_available_exist()
    {
        $this->json('GET', '/api/check_available')
             ->assertJson([
                 'status' => 200,
                 'message' => 'success'
             ]);
    }

    public function test_check_available_not_exist()
    {
        $this->json('POST', '/api/book', ['bay_id'=>1, 'customer_id'=> 1, 'owner_id'=>1]);
        $this->json('POST', '/api/book', ['bay_id'=>2, 'customer_id'=> 2, 'owner_id'=>1]);
        $this->json('POST', '/api/book', ['bay_id'=>3, 'customer_id'=> 3, 'owner_id'=>1]);
        $this->json('GET', '/api/check_available')
        ->assertJson([
            'data' => []
        ]);
    }

    public function test_book_bay_success()
    {
        $this->json('POST', '/api/book', ['bay_id'=>1, 'customer_id'=> 1, 'owner_id'=>1])
             ->assertJson([
                 'status' => 201,
                 'message' => 'success'
             ]);
    }

    public function test_book_bay_already_have_book()
    {
        $response = $this->json('POST', '/api/book', ['bay_id'=>1, 'customer_id'=> 1, 'owner_id'=>1]);
        $response = $this->json('POST', '/api/book', ['bay_id'=>2, 'customer_id'=> 1, 'owner_id'=>1]);
        $response->assertStatus(500);
    }

    public function test_book_bay_selected_another_bay_automaticly()
    {
        $response = $this->json('POST', '/api/book', ['bay_id'=>1, 'customer_id'=> 1, 'owner_id'=>1]);
        $response = $this->json('POST', '/api/book', ['bay_id'=>1, 'customer_id'=> 2, 'owner_id'=>1]);
        $response->assertStatus(201);
    }
}
