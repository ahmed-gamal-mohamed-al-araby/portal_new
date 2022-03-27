<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Department;
use App\Models\Group;
use App\Models\JobCode;
use App\Models\JobGrade;
use App\Models\JobName;
use App\Models\Project;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\GroupUse;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:employees', ['only' => ['index']]);
        $this->middleware('permission:add-employee', ['only' => ['create','store']]);
        $this->middleware('permission:edit-employee', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-employee', ['only' => ['restore']]);
    }

    public function index()
    {
        $users = User::with('manager')->with('sector')->with('department')->paginate(env('PAGINATION_LENGTH', 5));
        return view('dashboard-views.employee.index', compact('users'));
    }
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash_index()
    {
        $users = User::onlyTrashed()->with('manager')->with('sector')->with('department')->paginate(env('PAGINATION_LENGTH', 5));

        return view('dashboard-views.employee.trash', compact('users'));
    }

     /**
     * Return a view of the resource.
     *
     * @return \Illuminate\Support\Facades\View
     */
    function fetch_data(Request $request)
    {
        // dd($request->all());
        /* Request
        [
            page, // page number
            legnth, // items per page
            search_content,
            page_type => ['index', 'trashed']
        ]
        */

        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $users = [];
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = User::count();
                }
                if (strlen($searchContent)) {
                    $users = User::where('name_ar', 'like', '%' . $searchContent . '%')->orWhere('name_en', 'like', '%' . $searchContent . '%')->orWhere('code', 'like', '%' . $searchContent . '%')->with('manager')->with('sector')->with('department')->paginate($length);
                } else {
                    $users = User::with('manager')->with('sector')->with('department')->paginate($length);
                }
            } else if ($pageType == 'trashed') {
                if ($length == -1) {
                    $length = User::onlyTrashed()->count();
                }
                if (strlen($searchContent)) {
                    $users = User::onlyTrashed()
                        ->where(function ($query) use ($searchContent) {
                            return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                                ->orWhere('name_en', 'like', '%' . $searchContent . '%')
                                ->orWhere('code', 'like', '%' . $searchContent . '%');
                        })->with('manager')->with('sector')->with('department')
                        ->paginate($length);
                } else {
                    $users = User::onlyTrashed()->with('manager')->with('sector')->with('department')->paginate($length);
                }
            }

            return view('dashboard-views.employee.pagination_data', compact('users', 'pageType'))->render();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = Sector::all();
        $departments = Department::all();
        $projects = Project::all();
        $users = User::all();
        $jobCodes = JobCode::all();
        $groups = Group::all();
        return view('dashboard-views.employee.create', compact('sectors', "groups" ,'projects','departments','jobCodes', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();

        $newStoredUser = User::create(
            $request->except('_token','group_id','delegated_at'),
        );

        if($request->delegated_at == "on") {
            $newStoredUser->update([
                "delegated_at" => 1
            ]);
        } else {
            $newStoredUser->update([
                "delegated_at" => 0
            ]);
        }

        foreach($request->group_id as $groupId) {
            UserGroup::create([
                "group_id" => $groupId,
                "user_id" => $newStoredUser->id
            ]);
        }

        DB::commit();
        // Notification part (In the future)

        // Start toastr notification
        Toastr()->success(
            trans('site.added_successfully'),
            trans("site.Success"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "10000",
                "extendedTimeOut" => "10000",
            ]
        );
        // End toastr notification

        return redirect()->route('employee.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $employee)
    {
        return json_decode(collect([
            'User' => json_decode($employee),
            'Manager Data' => json_decode($employee->manager),
            'Sector Data' => json_decode($employee->sector),
            'Department Data' => json_decode($employee->department),
            'Project Data' => json_decode($employee->project),
            'JobGrade Data' => json_decode($employee->jobGrade),
            'JobName Data' => json_decode($employee->jobName),
            'JobCode Data' => json_decode($employee->jobName ? $employee->jobName->jobCode : null),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $employee)
    {
        $_user = [];
        $user = $employee;
        $sectors = Sector::all();
        $departments = Department::all();
        $projects = Project::all();
        $groups = Group::all();
        $users = User::all();

        $_user['jobCode'] = $user->jobGrade? $user->jobGrade->jobCode : null;
        $jobGrades =$_user['jobCode']? $_user['jobCode']->jobGrades : [];
        $jobNames = $_user['jobCode']? $_user['jobCode']->jobNames : [];
        $_user['jobCode'] = $_user['jobCode']? $_user['jobCode']->id : null;
        $_user['manager'] = $user->manager? $user->manager->id : null;
        $_user['sector'] = $user->sector? $user->sector->id : null;
        $_user['department'] = $user->department? $user->department->id : null;
        $_user['project'] = $user->project? $user->project->id : null;
        $jobCodes = JobCode::all();

        return view('dashboard-views.employee.edit', compact('sectors', "groups" ,'departments','projects','jobGrades','jobCodes','jobNames', 'users', 'user', '_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user , $id)
    {
        // return $request->delegated_at;

        DB::beginTransaction();
        $updatedUser = User::where("id",$id)->update(
            $request->except('_token','_method','group_id'),
        );

        if($request->delegated_at == "on") {
            User::where("id",$id)->update([
                "delegated_at" => 1
            ]);
        } else {
            User::where("id",$id)->update([
                "delegated_at" => 0
            ]);
        }


        UserGroup::where("user_id",$id)->delete();

        foreach($request->group_id as $groupId) {
            UserGroup::create([
                "group_id" => $groupId,
                "user_id" => $id
            ]);
        }
        DB::commit();

            // Start toastr notification
            Toastr()->success(
                trans('site.updated_successfully'),
                trans("site.Success"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
            // End toastr notification
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        $errorMessage = false;
        $sector = Sector::where('head_id', $id)->first();
        $department = null;
        if ($sector) {
            $errorMessage = 'This emplyee is the head of sector ' . $sector->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this sector';
        }

        if (!$sector) {
            $department = Department::where('manager_id', $id)->first();
            if ($department) {
                $errorMessage = 'This emplyee is the head of department ' . $department->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this department';
            }
        }

        if (!$department) {
            $project = Project::where('manager_id', $id)->first();
            if ($project) {
                $errorMessage = 'This emplyee is the project Manager of ' . $project->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this project';
            }
        }

        if ($errorMessage) {
            return $errorMessage;
        } else {
            User::where("id",$id)->update([
                'active' => 0,
            ]);

            // Notification part
            return 'Emplyee ' . $user->name_ar . ' Deactived successfully';
        }

        // return redirect()->route('employee.index');



    }

    public function trashpost(Request $request ,$id)
    {
        $errorMessage = false;
        $sector = Sector::where('head_id', $id)->first();
        $department = null;
        if ($sector) {
            $errorMessage = 'This emplyee is the head of sector ' . $id . ' If you make sure to delete this emplyee delete or assign another emplyee this sector';
        }

        if (!$sector) {
            $department = Department::where('manager_id', $id)->first();
            if ($department) {
                $errorMessage = 'This emplyee is the head of department ' . $department->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this department';
            }
        }

        if (!$department) {
            $project = Project::where('manager_id', $id)->first();
            if ($project) {
                $errorMessage = 'This emplyee is the project Manager of ' . $project->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this project';
            }
        }

        if ($errorMessage) {
            return $errorMessage;
        } else {
            User::where("id",$id)->delete();

            // Notification part
            Toastr()->success(
                trans('site.Emplyee_Deactived_successfully'),
                trans("site.Success"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
            // End toastr notification
        return redirect()->route('employee.index');

        }


    }
    public function trashAll(Request $request ,$id)
    {
        $errorMessage = false;
        $sector = Sector::where('head_id', $id)->first();
        $department = null;
        if ($sector) {
            $errorMessage = 'This emplyee is the head of sector ' . $id . ' If you make sure to delete this emplyee delete or assign another emplyee this sector';
        }

        if (!$sector) {
            $department = Department::where('manager_id', $id)->first();
            if ($department) {
                $errorMessage = 'This emplyee is the head of department ' . $department->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this department';
            }
        }

        if (!$department) {
            $project = Project::where('manager_id', $id)->first();
            if ($project) {
                $errorMessage = 'This emplyee is the project Manager of ' . $project->name_ar . ' If you make sure to delete this emplyee delete or assign another emplyee this project';
            }
        }

        if ($errorMessage) {
            return $errorMessage;
        } else {
            User::where("id",$id)->forceDelete();

            // Notification part
            Toastr()->success(
                trans('site.Emplyee Deleted successfully'),
                trans("site.Success"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
            // End toastr notification
        return redirect()->route('employee.index');

        }

    }

    public function restore(Request $request,$id)
    {
        $employee = User::withTrashed()->where('id', $id)->firstOrFail();
        $status = null;

        if ($employee->trashed()) {
            $employee->restore();

            // Notification part (In the future)

            Toastr()->success(
                trans('site.Emplyee_Restored_successfully'),
                trans("site.Success"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
            // End toastr notification
        return redirect()->route('employee.index');
    }

}
}
