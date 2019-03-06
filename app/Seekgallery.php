<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seekgallery extends Model
{
    protected $table = 'seekGallery';
    protected $fillable = [
		'path','property_id'
	];
}
