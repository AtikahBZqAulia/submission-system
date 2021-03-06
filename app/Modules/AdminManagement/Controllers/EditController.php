<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\AdminManagement\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Modules\AdminManagement\Models\Admin;
use App\Modules\AdminManagement\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:AdminManagement-Create'])->only(['store','addadmin']);
        $this->middleware(['role:AdminManagement-Save'])->only(['update','index']);
    }

    public function index($id) {
        $admin = Admin::findOrFail($id);
        return view("AdminManagement::medit", ["admin" => $admin, "grouplist" => Group::GetSelectableList()]);
    }


    public function addadmin() {
        $data = ["grouplist" => Group::GetSelectableList()];
        return view("AdminManagement::new", $data);
    }

    public function changepass_form($id) {
        $data = [
            'title' => 'Reset Password',
            'action' => route('admin.manageadmin.reset', $id),
            'admin' => Admin::findOrFail($id)
        ];
        return view("AdminManagement::reset", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $admin = Admin::find($id);
            $admin->updated_at = Carbon::now()->toDateTimeString();
            $admin->updated_by = Auth::user()->id;
            $admin->update($request->all());
            $admin->saveGroup($request->grouplist);
            return response()->json([$admin, $request->grouplist]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function change_password(Request $request, $id) {
        $validator = Validator::make($request->all(), [
           'password' => 'required|confirmed|min:6'
        ]);

        if($validator->passes()) {
            $admin = Admin::find($id);
            $admin->updated_at = Carbon::now()->toDateTimeString();
            $admin->updated_by = Auth::user()->id;
            $admin->password = bcrypt($request->get('password'));
            $admin->update();
            return response()->json(['success' => true]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


    }

    protected function validator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|numeric'
        ]);
    }

    protected function newAdminValidator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function maxYear() {
        return Carbon::now()->addYears('-17')->addDays('1')->toDateString();
    }

    public function store(Request $request) {
        $validator = $this->newAdminValidator($request);
        if($validator->passes()) {
            $admin = Admin::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'address' => $request->get('address'),
                'phone' => $request->get('phone'),
                'password' => bcrypt($request->get('password')),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'active' => 1,
            ]);

            $admin->createdby()->associate(Auth::user());
            $admin->updatedby()->associate(Auth::user());
            $admin->update();
            $admin->saveGroup($request->grouplist);
            return response()->json([$admin]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}