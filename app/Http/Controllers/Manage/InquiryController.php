<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Entities\Inquiries\InquiriesRepository;
use ElegantMedia\OxygenFoundation\Http\Traits\Web\CanCRUD;
use ElegantMedia\OxygenFoundation\Http\Traits\Web\CanRead;
use ElegantMedia\OxygenFoundation\Http\Traits\Web\FollowsConventions;
use EMedia\Formation\Builder\Formation;

class InquiryController extends Controller
{

	use FollowsConventions;

	// Uncomment this line if you're going to use Oxygen's Default Controller Methods
	use CanCRUD;
	use CanRead;

	protected $repo;

	public function __construct(InquiriesRepository $repo)
	{
		$this->repo = $repo;

		$this->resourceEntityName = 'Inquiry';
        $this->isDestroyAllowed = true;
	}

    protected function getResourcePrefix()
    {
        return 'manage.inquiries';
    }

	protected function getIndexRouteName($suffix = 'index'): string
	{
		return "manage.inquiries.$suffix";
	}

    /**
     *
     * This is the form shown when creating a new record.
     *
     * @param  $entity
     *
     * @return Formation
     */
    protected function getCreateForm($entity = null)
    {
        return new Formation($entity);
    }

    /**
     *
     * This is the form shown when editing an existing record.
     *
     * @param  $entity
     *
     * @return Formation
     */
    protected function getEditForm($entity = null)
    {
        return new Formation($entity);
    }

}
