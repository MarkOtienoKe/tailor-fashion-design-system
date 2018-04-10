<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 25/03/2018
 * Time: 12:18
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Shinobi;

use App\Role;
use App\User;
use App\Permission;

use Smarch\Watchtower\Requests\StoreRequest;
use Smarch\Watchtower\Requests\UpdateRequest;
use Yajra\Datatables\Datatables;


class RoleController extends Controller
{
    /**
     * Set resource in constructor.
     */
    function __construct()
    {
        $this->route = "role";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ( Shinobi::can( config('admin.acl.role.index', false) ) ) {
            $roles = $this->getData();

            return view('role.index', compact('roles') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view role list' ]);
    }

    /**
     * Returns paginated list of items, checks if filter used
     * @return array Permissions
     */
    protected function getData()
    {
        if ( \Request::has('search_value') ) {
            $value = \Request::get('search_value');
            $roles = Role::where('name', 'LIKE', '%'.$value.'%')
                ->orWhere('slug', 'LIKE', '%'.$value.'%')
                ->orWhere('description', 'LIKE', '%'.$value.'%')
                ->orderBy('name')->paginate( config('admin.pagination.roles', 15) );
            session()->flash('search_value', $value);
        } else {
            $roles = Role::orderBy('name')->paginate( config('admin.pagination.roles', 15) );
            session()->forget('search_value');
        }

        return $roles;
    }

    public function getAllRolesData()
    {
        $roles = Role::select(['id', 'name', 'slug', 'description'])
            ->where('status','=','ACTIVE');
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
        if ( Shinobi::can( config('admin.acl.role.create', false) ) ) {
            return view(config('admin.views.roles.create'))
                ->with('route', $this->route);
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'create new roles' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $response = response()->json(['errors' => 'You are not permitted to create roles.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.user.create', false) ) ) {
//            $requestData = $request->all();
//            $requestData['status'] = 'ACTIVE';
//            $requestData['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            Role::create($request->all());
            $response = response()->json(['success' => 'Role successfully created.', 'status_code' => 200]);
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
        if ( Shinobi::canAtLeast( [ config('admin.acl.role.edit', false),  config('admin.acl.role.show', false)] ) ) {
            $resource = Role::findOrFail($id);
            $show = "1";
            $route = $this->route;
            return view( config('admin.views.roles.show'), compact('resource','show','route') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view roles' ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if ( Shinobi::canAtLeast( [ config('admin.acl.role.edit', false),  config('admin.acl.role.show', false)] ) ) {
            $resource = Role::findOrFail($id);
            $show = "0";
            $route = $this->route;

            return view( config('admin.views.roles.edit'), compact('resource','show','route') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'edit roles' ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateRequest $request)
    {
        $response = response()->json(['errors' => 'You are not permitted to create roles.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.role.edit', false) ) ) {
            $role = Role::findOrFail($id);
            $role->update($request->all());
            $response = response()->json(['success' => 'Role successfully updated.', 'status_code' => 200]);
        }

        return $response;
    }

    public function deactivateRole(Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if ( Shinobi::can ( config('admin.acl.role.destroy', false) ) ) {
            $result = RoleRepository::deactiveRole($request['role_id']);
            if($result>0){

                $response = response()->json(['message' => 'role successfully deactivated', 'status_code' => 200]);
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
        $message = " You are not permitted to destroy roles.";

        if ( Shinobi::can ( config('admin.acl.role.destroy', false) ) ) {
            Role::destroy($id);
            $level = "warning";
            $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role deleted.";
        }

        return redirect()->route( 'role.index')
            ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

    /**
     * Show the form for editing the role permissions.
     *
     * @param  int  $id
     * @return Response
     */
    public function editRolePermissions($id)
    {
        if ( Shinobi::can( config('admin.acl.role.permissions', false) ) ) {
            $role = Role::findOrFail($id);

            $permissions = $role->permissions;

            $available_permissions = Permission::whereDoesntHave('roles', function ($query) use ($id) {
                $query->where('role_id', $id);
            })->get();

            return view( 'role.permission', compact('role', 'permissions', 'available_permissions') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'sync role permissions' ]);
    }

    /**
     * Sync roles and permissions.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateRolePermissions($id, Request $request)
    {
        $response = response()->json(['message' => 'You are not permitted to create roles.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.role.permissions', false) ) ) {
            $role = Role::findOrFail($id);
            if ($request->has('slug')) {
                $role->permissions()->sync( $request->get('slug') );
            } else {
                $role->permissions()->detach();
            }
            $response = response()->json(['message' => 'role permission successfully updated.', 'status_code' => 200]);
        }

        return $response;
    }

    /**
     * Show the form for editing the role users.
     *
     * @param  int  $id
     * @return Response
     */
    public function editRoleUsers($id)
    {
        if ( Shinobi::can( config('admin.acl.role.users', false) ) ) {
            $role = Role::findOrFail($id);

            $users = $role->users;

            $available_users = User::whereDoesntHave('roles', function ($query) use ($id) {
                $query->where('role_id', $id);
            })->get();

            return view( 'role.user', compact('role', 'users', 'available_users') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'sync role users' ]);
    }

    /**
     * Sync roles and users.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateRoleUsers($id, Request $request)
    {
        $response = response()->json(['message' => 'You are not permitted to create roles.', 'status_code' => 500]);

        if (Shinobi::can ( config('admin.acl.role.users', false) ) ) {
            $role = Role::findOrFail($id);
            if ($request->has('slug')) {
                $role->users()->sync( $request->get('slug') );
            } else {
                $role->users()->detach();
            }
            $response = response()->json(['message' => 'role user successfully updated.', 'status_code' => 200]);
        }

        return $response;
    }

    /**
     * A full matrix of roles and permissions.
     * @return Response
     */
    public function showRoleMatrix()
    {
        if ( Shinobi::can( config('admin.acl.role.viewmatrix', false) ) ) {
            $roles = Role::all();
            $perms = Permission::all();
            $prs = DB::table('permission_role')->select('role_id as r_id','permission_id as p_id')->get();

            $pivot = [];
            foreach($prs as $p) {
                $pivot[] = $p->r_id.":".$p->p_id;
            }

            return view( 'role.matrix', compact('roles','perms','pivot') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view the role matrix' ]);
    }

    /**
     * Sync roles and permissions.
     * @return Response
     */
    public function updateRoleMatrix(Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if ( Shinobi::can ( config('admin.acl.role.permissions', false) ) ) {
            $bits = $request->get('perm_role');
            foreach($bits as $v) {
                $p = explode(":", $v);
                $data[] = array('role_id' => $p[0], 'permission_id' => $p[1]);
            }

            DB::transaction(function () use ($data) {
                DB::table('permission_role')->delete();
                //DB::statement('ALTER TABLE permission_role AUTO_INCREMENT = 1');
                DB::table('permission_role')->insert($data);
            });


            $response = response()->json(['message' => 'Role matrix successfully updated', 'status_code' => 200]);
        }

        return $response;
    }
}