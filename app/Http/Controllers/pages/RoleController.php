<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    use HasRoles;
    function __construct()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $rolePermissions = $user->role->permissions->pluck('name')->toArray();
            $this->middleware(["role:$user","permission:" . implode('|', $rolePermissions)]);
        }
        $this->middleware('permission:role-list', ['only' => ['index','getRoles']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-view', ['only' => ['show']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        

    }
    public function index(Request $request)
    {
        $roles = Role::all();
        if (!Auth::check()) {
          return redirect()->route('auth-login-basic');
        }
        else{
          return view('role.index',compact('roles'));
        }
    }

    public function getRoles(Request $request)
    {
        // Read value
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');

        $searchValue = $request->input('search.value');

        // Total records
        $totalRecords = Role::count();

        // Apply search filter
        $filteredRecords = Role::where('name', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records with pagination and search
        $records = Role::where('name', 'like', '%' . $searchValue . '%')
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $data = [];
        $counter = $start + 1;
        $user = Auth::user(); // Get the logged-in user

        foreach ($records as $record) {
          $editButton = '<a href="' . route('role.edit', $record->id) . '" class="btn"><i class="fa-regular fa-pen-to-square"></i></a>';
          $viewButton = '<a href="' . route('role.show', $record->id) . '" class="btn"><i class="fa-solid fa-eye"></i></a>';
          $deleteButton = '<form action="' . route('role.destroy', $record->id) . '" method="POST" style="display:inline">
                              ' . csrf_field() . '
                              ' . method_field('DELETE') . '
                              <button type="submit" class="btn"><i class="fa-solid fa-trash-can"></i></button>
                          </form>';

          $buttons = '';

          // Check if the user can edit role
          if (Auth::user()->can('role-edit')) {
              $buttons .= $editButton . '&nbsp;';
          }

          // Check if the user can view role
          if (Auth::user()->can('role-view')) {
              $buttons .= $viewButton . '&nbsp;';
          }

          // Check if the user can delete role
          if (Auth::user()->can('role-delete')) {
              $buttons .= $deleteButton . '&nbsp;';
          }

          $row = [
              $counter,
              $record->name,
              $buttons
          ];
          $data[] = $row;
          $counter++;
      }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];
        return response()->json($response);
    }
    public function create()
    {
        $permissions = Permission::get();
        return view('role.create',compact('permissions'));
    }
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'roleName' => 'required|unique:roles,name',
        'permissions' => 'required',
      ]);

        if($validator->fails()){
          return response()->json(['error'=>$validator->errors()]);
        }

        $role = Role::create(['name' => $request->input('roleName')]);
        $role->syncPermissions($request->input('permissions'));

        return response()->json(['success'=>'Role Created Successfully!!']);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('role.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('role.edit', compact('role', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(),[
        'roles' => 'required|unique:roles,name',
        'permissions' => 'required',
      ]);

        $role = Role::find($id);
        $role->name = $request->input('roles');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('role.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('role.index')
                        ->with('success','Role deleted successfully');
    }
}
