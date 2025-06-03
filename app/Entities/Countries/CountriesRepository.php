<?php

namespace App\Entities\Countries;

use App\Entities\BaseRepository;

class CountriesRepository extends BaseRepository
{

	public function __construct(Country $model)
	{
		parent::__construct($model);
	}

}
