<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateProjectTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     public function testArtificialintelligenceIsAwesome()
     {
         Auth::loginUsingId(1);
         $this->visit('/project/new');
         $this->type('Testproject', 'name');
         $this->type('Dit is een omschrijving', 'description');
         $this->select('2', 'customer_id');
         $this->press('');
         $this->seePageIs('/project');
     }

}
