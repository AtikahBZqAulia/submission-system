<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 15/01/2018
 * Time: 16:42
 */

namespace App\Modules\User\Controllers;


use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\Country;
use App\Models\BaseModel\PersonalData;
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $message = $request->session()->get('message');
        $this->data['user'] = $user;
        $this->data['message'] = $message;
        $this->data['header'] = "Personal Data";
        return view("User::profile.index", $this->data);
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(),[
            "name"      => "required|string|max:150",
            "address"   => "required|string|max:190",
            "phone"     => "numeric",
            "birthdate" => "string",
            "student"   => "required|numeric",
            "nik"               => "string",
            "identity_type_id"  => "numeric",
            "identity_number"   => "string",
            "institution"       => "required|string",
            "department"        => "required|string",
            "islocal"           => "",
        ]);

        if($validator->passes()) {
            $user = Auth::user();
            $country = Country::find($request->get('country_id'));
            if($country->code == "ID")
                $request['islocal'] = 1;
            else
                $request['islocal'] = 0;
            if(empty($user->personal_data)) {$pd  = new PersonalData();
               $pd->user_id = $user->id;
               $pd->setRawAttributes($request->only(['nik','institution','department','country_id']));
               if($country->code == "ID")
                   $pd->islocal = 1;
               else
                   $pd->islocal = 0;
               $pd->user()->associate($user);
               $pd->save();
            } else {
                $user->personal_data()->update($request->only(['islocal','nik','institution','department','identity_number','identity_type_id','student']));
            }
            $user->update($request->only(['name','address','phone','birthdate']));
            return response()->json(['success' => true]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function security() {
        $this->data['header'] = "Change Password";
        return view("User::profile.security", $this->data);
    }


    public function updatepass(Request $request) {
        $validator = Validator::make($request->all(),[
            'old_password'  => 'required',
            'password'  => 'required|min:6|confirmed',
        ]);

        if($validator->passes()) {
            if(Hash::check($request->get('old_password'), Auth::user()->getAuthPassword())) {
                $user = Auth::user();
                $user->password = bcrypt($request->get('password'));
                $user->save();
                return response()->json(['success' => true]);
            } else {
                $error = ['old_password' => ['Invalid password']];
                return response()->json(['errors' => $error]);
            }
        } else {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }
}