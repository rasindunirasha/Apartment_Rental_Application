<?php

namespace App\Entities\Apartments;

use App\Entities\BaseRepository;

class ApartmentsRepository extends BaseRepository
{

	public function __construct(Apartment $model)
	{
		parent::__construct($model);
	}

}
