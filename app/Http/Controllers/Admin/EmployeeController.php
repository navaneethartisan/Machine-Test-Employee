<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmployeePasswordSendMail;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Toastr;
use Yajra\Datatables\Datatables;
use Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $employee = Employee::count();
        return view('dashboard',compact('employee'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designation = Designation::pluck('id','designation');
        return view('admin.employee.create',compact('designation'));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'designation'=>'required',
            'name'=>'required|max:150',
            'email'=>'required|unique:employees,email',
            'photo'=>'mimes:jpeg,jpg,png|nullable|max:5012',
        ]);

        if ($request->hasFile('photo')){
            $path = Storage::disk('public')->put('employee', $request->file('photo'));
        }

        $employee = new Employee;
        $employee->designation_id = $request->designation;
        $employee->name = $request->name;
        $employee->email = $request->email;
        if ($request->hasFile('photo')){
        $employee->photo = $path;
        }
        $password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 6)), 0, 6);
        $employee->password = bcrypt($password);
        $employee->save();

        if (env('MAIL_USERNAME') != null) {
        Mail::to($request->email)->send(new EmployeePasswordSendMail($employee, $password));
        }


        Toastr::success('Employee Successfully Created', 'Success');
        return redirect(route('employee.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $employee = Employee::select('employees.*')->with(['MyDesignation']);

        return Datatables::of($employee)->addColumn('action', function ($employee) {
            return '<a href="'.route('employee.edit',$employee->id).'" title="edit"><button class="btn-info btn-sm"><i class="fa fa-edit"></i> </button></a>

                <button data-url="'.route('employee.destroy',$employee->id).'"class="btn-danger btn-sm deleting-btn"><i class="fa fa-trash"></i></button>';
           })
        ->addColumn('MyDesignation', function (Employee $employee) {
                    return $employee->MyDesignation ? $employee->MyDesignation['designation'] : "";
                })
       ->rawColumns(['action'])
       ->addIndexColumn()
       ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $designation = Designation::pluck('id','designation');

        return view('admin.employee.edit',compact('employee','designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'designation'=>'required',
            'name'=>'required|max:150',
            'email'=>'required|unique:employees,email,'.$id,
            'photo'=>'mimes:jpeg,jpg,png|nullable|max:5012',
        ]);


        if ($request->hasFile('photo')){
            $employee = Employee::findOrFail($id);
            Storage::disk('public')->delete($employee->photo);
            $path = Storage::disk('public')->put('employee', $request->file('photo'));
        }


        $employee = Employee::findOrFail($id);
        $employee->designation_id = $request->designation;
        $employee->name = $request->name;
        $employee->email = $request->email;
        if ($request->hasFile('photo')){
        $employee->photo = $path;
        }
        $employee->save();

        Toastr::success('Employee Successfully Updated', 'Success');
        return redirect(route('employee.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        Storage::disk('public')->delete($employee->photo);
        $employee->delete();

        Toastr::success('Employee Successfully Removed', 'Success');
        return redirect()->back();
    }
}
