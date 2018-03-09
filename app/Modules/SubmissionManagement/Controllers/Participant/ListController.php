<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 07/03/18
 * Time: 9:25
 */

namespace App\Modules\SubmissionManagement\Controllers\Participant;


use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(["role:UserMangement-View"]);
    }

    public function index() {
        $data['users'] = User::all();
        return view("SubmissionManagement::participant.index", $data);
    }

    public function detail($id) {
        $user = User::findOrFail($id);
        $title = "Participant Detail";
        return view("SubmissionManagement::participant.detail", compact(["user", "title"]));
    }

    public function DT() {
        $users = User::query()->with(["personal_data"]);
        $datatable = Datatables::of($users);

        $datatable->editColumn("personal_data.institution", function($u) {
            return empty($u->personal_data) ? " - " : $u->personal_data->institution;
        });

        $datatable->addColumn('action', function($u) {
            $btn = HtmlHelper::linkButton("View", route('admin.participant.detail', $u->id), "btn-xs btn-info btn-modal", "", "glyphicon-search");
            if(Auth::user()->hasRole("UserManagement-Edit")) {
                if($u->deleted) {
                    $btn .= HtmlHelper::linkButton("Recover", route('admin.participant.recover', $u->id), "btn-xs btn-warning btn-recover", "", "glyphicon-repeat");
                } else {
                    $btn .= HtmlHelper::linkButton("Delete", route('admin.participant.delete', $u->id), "btn-xs btn-danger btn-delete", "", "glyphicon-trash");
                }
            }

            return "<div class='btn-group'>{$btn}</div>";
        });


        return $datatable->make(true);
    }
}