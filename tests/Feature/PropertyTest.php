<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropertyTest extends TestCase
{
    /**
     * Confirm that a page for inserting a property opens properly for a landlord.
     */
    public function testAddPropertyPageAsLandlord() {
        $this -> actingAs(new User(['userType' => 1, 'token' => 1]));
        $response = $this -> call('GET', '/add_property');
        $response -> assertStatus(200);
    }

    /**
     * Confirm that a page for inserting a property redirects for a home seeker.
     */
    public function testAddPropertyPageAsHomeSeeker() {
        $this -> actingAs(new User(['userType' => 2, 'token' => 1]));
        $response = $this -> call('GET', '/add_property');
        $response -> assertStatus(403);
    }

}
