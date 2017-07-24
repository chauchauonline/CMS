<?php
namespace Modules\Cms\Http\Controllers;

use Modules\Cms\Http\Controllers\BaseController;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AuthorizedController extends BaseController {

	public function __construct()
	{
		// $this->beforeFilter('auth');
		$this->user = Sentinel::getUser();
	}
}
