<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeSeekerTest extends TestCase
{
    /**
     * Confirm that a page for inserting a home seeker ad opens properly for a home seeker.
     */
    public function testAddHomeSeekerAdPageAsHomeSeeker() {
        $this -> actingAs(new User(['userType' => 2, 'token' => 1]));
        $response = $this -> call('GET', '/home_seeker/create');
        $response -> assertStatus(200);
    }

    /**
     * Confirm that a page for inserting a home seeker ad redirects for a landlord.
     */
    public function testAddHomeSeekerAdPageAsLandlord() {
        $this -> actingAs(new User(['userType' => 1, 'token' => 1]));
        $response = $this -> call('GET', '/home_seeker/create');
        $response -> assertStatus(403);
    }
}
