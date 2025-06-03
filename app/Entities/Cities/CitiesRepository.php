<?php

namespace App\Entities\Cities;

use App\Entities\BaseRepository;

class CitiesRepository extends BaseRepository
{

	public function __construct(City $model)
	{
		parent::__construct($model);
	}

}
