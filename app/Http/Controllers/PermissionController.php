<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Shinobi;

use App\Role;
use App\Permission;

use Smarch\Watchtower\Requests\StoreRequest;
use Smarch\Watchtower\Requests\UpdateRequest;
use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{

    /**
     * Set resource in constructor.
     */
    function __construct() {
        $this->route = "permission";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ( Shinobi::can( config('admin.acl.permission.index', false) ) ) {
            $permissions = $this->getData();

            return view( 'permission.index', compact('permissions') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view permission list' ]);
    }

    /**
     * Returns paginated list of items, checks if filter used
     * @return array Permissions
     */
    protected function getData()
    {
        if ( \Request::has('search_value') ) {
            $value = \Request::get('search_value');
            $permissions = Permission::where('name', 'LIKE', '%'.$value.'%')
                ->orWhere('slug', 'LIKE', '%'.$value.'%')
                ->orWhere('description', 'LIKE', '%'.$value.'%')
                ->orderBy('name')->paginate( config('admin.pagination.permissions', 15) );
            session()->flash('search_value', $value);
        } else {
            $permissions = Permission::orderBy('name')->paginate( config('admin.pagination.permissions', 15) );
            session()->forget('search_value');
        }

        return $permissions;
    }

    public function getAllPermissionsData()
    {
        $roles = Permission::select(['id', 'name', 'slug', 'description']);
//            ->where('status','=','ACTIVE');
        return Datatables::of($roles)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( Shinobi::can( config('admin.acl.permission.create', false) ) ) {
            return view( config('admin.views.permissions.create') )
                ->with('route', $this->route);
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'create new permissions' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $response = response()->json(['errors' => 'You are not permitted to create permission.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.permission.create', false) ) ) {
            Permission::create($request->all());
            $response = response()->json(['success' => 'Permission successfully created.', 'status_code' => 200]);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if ( Shinobi::canAtLeast( [ config('admin.acl.permission.edit', false),  config('admin.acl.permission.show', false)] ) ) {
            $resource = Permission::findOrFail($id);
            $show = "1";
            $route = $this->route;

            return view( config('admin.views.permissions.show'), compact('resource','show','route') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view permissions' ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if ( Shinobi::canAtLeast( [ config('admin.acl.permission.edit', false),  config('admin.acl.permission.show', false)] ) ) {
            $resource = Permission::findOrFail($id);
            $show = "0";
            $route = $this->route;

            return view( config('admin.views.permissions.edit'), compact('resource','show','route') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'edit permissions' ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateRequest $request)
    {
        $response = response()->json(['errors' => 'You are not permitted to update permission.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.permission.edit', false) ) ) {
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());
            $response = response()->json(['success' => 'Permission successfully edited.', 'status_code' => 200]);
        }

        return $response;
    }

    public function deactivatePermission(Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if ( Shinobi::can ( config('admin.acl.role.destroy', false) ) ) {
            $result = PermissionRepository::deactivatePermission($request['permission_id']);
            if($result>0){

                $response = response()->json(['message' => 'permission successfully deactivated', 'status_code' => 200]);
            }
        }
        return $response;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $level = "danger";
        $message = " You are not permitted to destroy permissions.";

        if ( Shinobi::can ( config('admin.acl.permission.destroy', false) ) ) {
            Permission::destroy($id);
            $level = "warning";
            $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Permission deleted.";
        }

        return redirect()->route( config('admin.route.as') .'permission.index')
            ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

    /**
     * Show the form for editing the permission roles.
     *
     * @param  int  $id
     * @return Response
     */
    public function editRole($id)
    {
        if ( Shinobi::can( config('admin.acl.permission.role', false) ) ) {
            $permission = Permission::findOrFail($id);

            $roles = $permission->roles;

            $available_roles = Role::whereDoesntHave('permissions', function ($query) use ($id) {
                $query->where('permission_id', $id);
            })->get();

            return view( config('admin.views.permissions.role'), compact('permission', 'roles', 'available_roles') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'sync permission roles' ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateRole($id, Request $request)
    {
        $response = response()->json(['message' => 'You are not permitted to update permissions.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.permission.role', false) ) ) {
            $permission = Permission::findOrFail($id);
            if ($request->has('slug')) {
                $permission->roles()->sync( $request->get('slug') );
            } else {
                $permission->roles()->detach();
            }
            $response = response()->json(['message' => 'Permission Role successfully Updated.', 'status_code' => 200]);
        }

        return $response;

    }

}
