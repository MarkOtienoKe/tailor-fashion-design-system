<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:35
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Shinobi;

use App\User;
use App\Role;
use Smarch\Watchtower\Requests\UserStoreRequest;
use Smarch\Watchtower\Requests\UserUpdateRequest;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    protected $model = User::class;

    /**
     * Set resource model in constructor.
     */
    function __construct() {
        $this->model = $this->getModel();
    }


    /**
     * Determine which model to use
     * @return Model Instance
     */
    function getModel() {
        $model = config('admin.user.model', $this->model);
        return new $model;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ( Shinobi::can( config('admin.acl.user.index', false) ) ) {
            if ( $request->has('search_value') ) {
                $value = $request->get('search_value');
                $users = $this->model->where('name', 'LIKE', '%'.$value.'%')
                    ->orderBy('name')->paginate( config('admin.pagination.users', 15) );
                session()->flash('search_value', $value);
            } else {
                $users = $this->model->orderBy('name')->paginate( config('admin.pagination.users', 15) );
                session()->forget('search_value');
            }

            return view( 'user.index', compact('users') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view user list' ]);
    }

    public function getAllUsersData()
    {
        $users = User::select(['id', 'name', 'email', 'status', 'created_at'])
            ->where('status','=','ACTIVE');
        return Datatables::of($users)
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( Shinobi::can( config('admin.acl.user.create', false) ) ) {
            return view('user.create');
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'create new users' ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        $response = response()->json(['errors' => 'You are not permitted to create users.', 'status_code' => 500]);

        if ( Shinobi::can ( config('admin.acl.user.create', false) ) ) {
            $requestData = $request->all();
            $requestData['status'] = 'ACTIVE';
            $requestData['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $this->model->create($requestData);
            $response = response()->json(['success' => 'user successfully created.', 'status_code' => 200]);

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
        if ( Shinobi::canAtLeast( [ config('admin.acl.user.show', false),  config('admin.acl.user.edit', false) ] ) ) {
            $resource = $this->model->findOrFail($id);
            $show = "1";
            return view( 'user.edit', compact('resource','show') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'view users' ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if ( Shinobi::canAtLeast( [ config('admin.acl.user.edit', false),  config('admin.acl.user.show', false) ] ) ) {
            $resource = $this->model->findOrFail($id);
            $show = "0";
            return view( 'user.edit', compact('resource','show') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'edit users' ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UserUpdateRequest $request)
    {

        $response = response()->json(['errors' => 'You are not permitted to update users.', 'status_code' => 500]);

        if ( Shinobi::can ( config('admin.acl.user.edit', false) ) ) {
            $user = $this->model->findOrFail($id);
            if ($request->get('password') == '') {
                $user->update( $request->except('password') );
            } else {
                $user->update( $request->all() );
            }
            $response = response()->json(['success' => 'user successfully updated.', 'status_code' => 200]);
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
        $message = " You are not permitted to destroy user objects";

        if ( Shinobi::can ( config('admin.acl.user.destroy', false) ) ) {
            $this->model->destroy($id);
            $level = "warning";
            $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User deleted.";
        }

        return redirect()->route( config('admin.route.as') . 'user.index')
            ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

    public function deactivateUser(Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if ( Shinobi::can ( config('admin.acl.user.destroy', false) ) ) {
            $result = UserRepository::deactiveUser($request['user_id']);
            if($result>0){

            $response = response()->json(['message' => 'user successfully deactivated', 'status_code' => 200]);
            }
        }
        return $response;
    }

    /**
     * Show the form for editing the user roles.
     *
     * @param  int  $id
     * @return Response
     */
    public function editUserRoles($id)
    {
        if ( Shinobi::can( config('admin.acl.user.role', false) ) ) {
            $user = $this->model->findOrFail($id);

            $roles = $user->roles;

            $available_roles = Role::whereDoesntHave('users', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->get();

            return view( 'user.role', compact('user', 'roles', 'available_roles') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'sync user roles' ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateUserRoles($id, Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if (Shinobi::can(config('admin.acl.user.role', false))) {
            $user = $this->model->findOrFail($id);
            if ($request->has('ids')) {
                $user->roles()->sync($request->get('ids'));
            } else {
                $user->roles()->detach();
            }

            $response = response()->json(['message' => 'user role successfully updated', 'status_code' => 200]);
        }
        return $response;
    }

    /**
     * [userMatrix description]
     * @return Response
     */
    public function showUserMatrix()
    {
        if ( Shinobi::can( config('admin.acl.user.viewmatrix', false) ) ) {
            $roles = Role::all();
            $users = $this->model->orderBy('name')->get();
            $us = DB::table('role_user')->select('role_id as r_id','user_id as u_id')->get();

            $pivot = [];
            foreach($us as $u) {
                $pivot[] = $u->r_id.":".$u->u_id;
            }

            return view( 'user.matrix', compact('roles','users','pivot') );
        }

        return view( config('admin.views.layouts.unauthorized'), [ 'message' => 'sync user roles' ]);
    }

    /**
     * [updateMatrix description]
     * @return Response
     */
    public function updateUserMatrix(Request $request)
    {
        $response = response()->json(['message' => 'action failed', 'status_code' => 500]);
        if ( Shinobi::can ( config('admin.acl.user.usermatrix', false) ) ) {
            $bits = $request->get('role_user');
            foreach($bits as $v) {
                $p = explode(":", $v);
                $data[] = array('role_id' => $p[0], 'user_id' => $p[1]);
            }

            DB::transaction(function () use ($data) {
                DB::table('role_user')->delete();
//				DB::statement('ALTER TABLE role_user AUTO_INCREMENT = 1');
                DB::table('role_user')->insert($data);
            });

            $response = response()->json(['message' => 'user matrix successfully updated', 'status_code' => 200]);
        }

        return $response;
    }

}