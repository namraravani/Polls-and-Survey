<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    use HasRoles;
    function __construct()
    {
        if (Auth::check()) {
        $user = Auth::user();
        $rolePermissions = $user->role->permissions->pluck('name')->toArray();
        $this->middleware(["role:$user","permission:" . implode('|', $rolePermissions)]);
        }
        $this->middleware('permission:user-list', ['only' => ['index','getuser']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-view', ['only' => ['show']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);


    }
    public function user()
    {
        return view('users.index');
    }

    public function getuser(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');

        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('first_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $users = User::orderBy('users.id', "desc")
            ->where('first_name', 'like', '%' . $searchValue . '%')
            ->where('id', '!=', Auth::user()->id)
            ->select('users.*')
            ->take($start)
            ->take($rowperpage)
            ->get();


        $data = array();
        $counter = 0;
        foreach ($users as $user) {
            $row = array();
            $row[] = ++$counter;
            if($user['role']==NULL)
            {
              $row[] = '<span class="badge rounded-pill bg-label-danger">' .'NO ROLE ASSIGNED' . '</span>';
            }
            else
            {
              $row[] = '<span style="background-color:lightgreen; color:green;" class="badge rounded-pill"><i class="fas fa-check-circle me-1" style="font-size: 18px; color: ; margin-right: 5px;"></i>' . $user['role'] . '</span>';
            }

            if ($user->profile_img) {
              $row[] = '<img src="' . asset($user->profile_img) . '" alt="Profile Image" style="border-radius: 50%; object-fit: cover; width: 60px; height: 60px;">';
          } else {
              $initials = strtoupper(substr($user->first_name, 0, 1));
              $initials1 = strtoupper(substr($user->last_name, 0, 1));
              $row[] = '<div style="border-radius: 50%; width: 60px; height: 60px; background-color: #000; display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: bold; color: #fff;">' . $initials . $initials1 . '</div>';
          }

            $row[] = '<span style="background-color:#FCD299; color:#FE5000;" class="badge rounded-pill"><i class="fas fa-user-circle" style="font-size: 18px; color: ; margin-right: 5px;"></i>' . $user['username'] . '</span>';
            $row[] = '<span style="background-color:lightgreen; color:green;" class="badge rounded-pill"><i class="fas fa-info-circle" style="font-size: 18px; color: ; margin-right: 5px;"></i>' . $user['first_name'] . '</span>';
            $row[] = '<span style="background-color:lightgreen; color:green;" class="badge rounded-pill"><i class="fas fa-info-circle" style="font-size: 18px; color: ; margin-right: 5px;"></i>' . $user['last_name'] . '</span>';
            $row[] = '<span style="background-color:lightgrey; color:black;" class="badge rounded-pill">' .'<i class="fa-solid fa-phone"></i>'.   $user['phone_no'] . '</span>';
            $row[] = '<span class="badge rounded-pill bg-label-primary"><i class="fas fa-envelope" style="font-size: 18px; color: ; margin-right: 5px;"></i>' . $user['email'] . '</span>';



            $Action = '';

            Auth::user()->can('user-edit') ? $Action .= '<a href="' . route(('users.edit'), [$user["id"]]) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>' : "";
            Auth::user()->can('user-view') ? $Action .= '<a href="' . route(('users.show'), [$user["id"]]) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>' : "";
            Auth::user()->can('user-delete') ? $Action .= '<a data-id="' . $user["id"] . '" href="' . route("users.destroy", ["id" => $user["id"]]) . '" onclick="event.preventDefault(); deleteUser(' . $user["id"] . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>' : "";

            // JavaScript code for the SweetAlert confirmation dialog
            $Action .= '
                <script>
                function deleteUser(id) {
                  Swal.fire({
                      title: "Are you sure?",
                      text: "You want to remove the user!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "Yes, remove it!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Perform the delete action here
                          window.location.href = "' . route("users.destroy", ["id" => $user["id"]]) . '?id=" + id;
                          Swal.fire("User deleted!", "", "success");
                      } else {
                          Swal.fire("Deletion canceled.", "", "warning");
                      }
                  });
              }
                </script>';



            $row[] = $Action;
            $data[] = $row;
        }

        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data,
        );

        echo json_encode($output);
        exit;
    }

    public function create(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles','user'));
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'role' => 'required',
        'profile_img' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'username' => 'required|unique:users,username',
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_no' => 'required|digits:10|unique:users,phone_no',
        'email' => 'required|unique:users,email,',

    ]);



        if ($validator->fails()) {
          return response()->json(['error' => $validator->errors()]);
        }

        if ($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $thumbnailName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploaded_images'), $thumbnailName);
            $profileImgPath = 'uploaded_images/' . $thumbnailName;
        }

        $user = new User();
        $user->role = $request->input('role');
        $user->assignRole($request->input('role'));
        $user->profile_img = $profileImgPath;
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_no = $request->input('phone_no');
        $user->email = $request->input('email');
        $user->password = $user->password;
        $user->save();

        return response()->json(['success' => 'New User Created Successfully']);
    }
        public function edit($id)
    {
        $user = User::findOrFail($id);
        $userRole = $user->role;
        $roles = Role::pluck('name','name')->all();
        return view('users.edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->assignRole($request->input('role'));
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_no = $request->input('phone_no');
        $user->email = $request->input('email');

        $previousImage = $user->profile_img;

        if ($request->hasFile('profile_img')) {
            // New image is uploaded
            $image = $request->file('profile_img');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'Product_thumbnails/';
            $path = $image->move($destinationPath, $imageName);

            // Delete the previous image
            if ($previousImage) {
                File::delete(public_path($previousImage));
            }

            $user->profile_img = $path;
        } elseif ($request->has('delete_profile_img')) {
            // Existing image is deleted
            if ($previousImage) {
                File::delete(public_path($previousImage));
            }
            $user->profile_img = null;
        } else {
            // No changes to the profile image
            $user->profile_img = $previousImage;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
      //   if ($request->filled('password')) {
      //     $user->password = $request->input('password');
      // }

        $user->save();

        return redirect()->route('user')->with('success', 'User updated successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', ['user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'User deleted successfully');
    }




}
