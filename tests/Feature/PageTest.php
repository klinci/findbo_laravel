<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageTest extends TestCase
{

    public function testGuestHomePage() {
    	$response = $this -> call('GET', '/');
    	$response -> assertStatus(200);
    }

    public function testLoggedInHomePage() {
    	$this -> actingAs(new User);
    	$response = $this -> call('GET', '/');
    	$response -> assertStatus(200);
    }

    public function testAboutPage() {
    	$response = $this -> call('GET', '/about');
        $response -> assertStatus(200);
    }

    public function testHowItWorksPage() {
        $response = $this -> call('GET', '/how_it_works');
        $response -> assertStatus(200);
    }

    public function testPricePage() {
        $response = $this -> call('GET', '/price');
        $response -> assertStatus(200);
    }

    public function testTermsAndConditionsPage() {
        $response = $this -> call('GET', '/terms_condition');
        $response -> assertStatus(200);
    }

    public function testFaqPage() {
        $response = $this -> call('GET', '/faq');
        $response -> assertStatus(200);
    }

}
