<?php

namespace Tests\Feature\REST;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InfoTest extends TestCase
{
    /**
     * Test api endpoint if accesible 
     * & if contains correct info
     *
     * @return void
     */
    public function testApiInfo()
   	{
   		$response = $this->get('/v1/rest/info');
   		$response
   			->assertStatus(200)
   			->assertJson([
   				'version' => '1.0',
   				'version_prefix' => 'v1'
   			]);
   	}
}
