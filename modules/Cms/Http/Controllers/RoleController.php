<?php
namespace Modules\Cms\Http\Controllers;

use Modules\Cms\Http\Controllers\AuthorizedController;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RoleController extends AuthorizedController
{
    /**
     * Holds the Sentinel Roles repository.
     *
     * @var \Cartalyst\Sentinel\Roles\EloquentRole
     */
    protected $roles;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = Sentinel::getRoleRepository()->createModel();
    }

    /**
     * Display a listing of roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $record = Config::get('constants.RECORD_PER_PAGE');
        $roles = $this->roles->paginate($record);

        return View::make('cms::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->showForm('create');
    }

    /**
     * Handle posting of the form for creating new role.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        return $this->processForm('create');
    }

    /**
     * Show the form for updating role.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->showForm('update', $id);
    }

    /**
     * Handle posting of the form for updating role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        return $this->processForm('update', $id);
    }

    /**
     * Remove the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($role = $this->roles->find($id))
        {
            $role->delete();
        }
        return redirect()->route('roles.index');
    }

    /**
     * Shows the form.
     *
     * @param  string  $mode
     * @param  int     $id
     * @return mixed
     */
    protected function showForm($mode, $id = null)
    {
        if ($id)
        {
            if ( ! $role = $this->roles->find($id))
            {
                return Redirect::to('roles');
            }
        }
        else
        {
            $role = $this->roles;
        }

        return View::make('cms::roles.form', compact('mode', 'role'));
    }

    /**
     * Processes the form.
     *
     * @param  string  $mode
     * @param  int     $id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function processForm($mode, $id = null)
    {
        $input = Input::all();

        $rules = [
                'name' => 'required|unique:roles',
                'slug' => 'required|unique:roles'
        ];

        if ($id)
        {
            $role = $this->roles->find($id);

            $rules['slug'] .= ",slug,{$role->slug},slug";
            $rules['name'] .= ",name,{$role->name},name";

            $messages = $this->validateRole($input, $rules);

            if ($messages->isEmpty())
            {
                $role->fill($input);

                $role->save();
            }
        }
        else
        {
            $messages = $this->validateRole($input, $rules);

            if ($messages->isEmpty())
            {
                $role = $this->roles->create($input);
            }
        }

        if ($messages->isEmpty())
        {
            return Redirect::to('roles');
        }

        return Redirect::back()->withInput()->withErrors($messages);
    }

    /**
     * Validates a role.
     *
     * @param  array  $data
     * @param  mixed  $id
     * @return \Illuminate\Support\MessageBag
     */
    protected function validateRole($data, $rules)
    {
        $validator = Validator::make($data, $rules);

        $validator->passes();

        return $validator->errors();
    }
}