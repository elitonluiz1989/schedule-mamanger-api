<?php

namespace Tests\Models\Core;

use Illuminate\Database\Eloquent\Model;

class TestSampleModel extends Model
{
	public $timestamps = false;

	protected $table = 'test_sample_table';

	protected $fillable = ['name', 'age'];
}
