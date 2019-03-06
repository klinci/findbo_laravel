<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Artisan;
use Session;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{
    
	public function testMyProfileAsGuest() {
		$response = $this -> call('GET', '/myprofile');
		$response -> assertStatus(302);
		$response -> assertRedirect('/login');
	}

	public function testMyProfileAsUser() {
		$this -> actingAs(new User);
		$response = $this -> call('GET', '/myprofile');
		$response -> assertStatus(200);
	}

	public function testUpdateProfileAsGuest() {
		$response = $this -> call('POST', '/updateprofile');
		$response -> assertStatus(302);
	}

	public function testUpdatePasswordAsGuest() {
		$response = $this -> call('POST', '/updatepassword');
		$response -> assertStatus(302);
	}

}
