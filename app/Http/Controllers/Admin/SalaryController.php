<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'store','create','show','search']); 
    }
    public function index(){
        $rows = Salary::latest()->paginate(10);
        $search = null;
        $student_count = count(Student::get()->all());
        return view('admin.salary.index',compact('search','rows','student_count','id'));
    }

    public function create()
    {
        $rows = Student::get()->all();
        $student_count = count(Student::get()->all());
        return view('admin.salary.create',compact('rows','student_count'));
    }
    
    public function message()
    {
        return [
            'student.required' => 'يجب اختيار الطالب',
            'salary.required' => 'يجب ادخال المبلغ المدفوع',
            'status.required' => 'يجب اختيار حالة الطالب',
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'student' => 'required',
            'salary' =>'required',
            'status' => 'required'
        ],$this->message());

        $row = new Salary();
        $row->student_id = $request->student;
        $row->salary = $request->salary;
        $row->status  = $request->status;
        $row->user_create = Auth::user()->id;
        $row->notes = $request->notes;
        $row->admin_notes = $request->admin_notes;
        $row->date = Carbon::now();
        $row->save();
        return redirect()->route('admin.salary.create')->with('success','تم اضافة مصاريف الطالب '.$row->Student->name.' على النظام بنجاح');
    }
    public function show($id)
    {
        $salary = Salary::findOrFail($id);
        $rows = Student::get()->all();
        return view('admin.salary.show',compact('rows','salary'));
    }
    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        $rows = Student::get()->all();
        return view('admin.salary.edit',compact('rows','salary'));
    }
    public function update(Request $request , $id)  
    {
        $request->validate([
            'student' => 'required',
            'salary' =>'required',
            'status' => 'required'
        ],$this->message());


        $row = Salary::findOrFail($id);
        if($row->student_id == $request->student &&
            $row->salary == $request->salary &&
            $row->status == $request->status &&
            $row->notes == $request->notes &&
            $row->admin_notes == $request->admin_notes
        
        ){
            
            return redirect()->route('admin.salary.edit',$row->id)->with('error','لم يتم تعديل مصاريف الطالب '.$row->Student->name.' لعدم تغيير البيانات');

        }else{

        
            $row->student_id = $request->student;
            $row->salary = $request->salary;
            $row->status  = $request->status;
            $row->notes = $request->notes;
            $row->admin_notes = $request->admin_notes;
            $row->update();
            return redirect()->route('admin.salary.edit',$row->id)->with('success','تم تعديل مصاريف الطالب '.$row->Student->name.' على النظام بنجاح');
        }
    }

    public function destroy($id)
    {
        $row = Salary::findOrFail($id);
        $row->delete();
        return redirect()->route('admin.salary.index')->with('success','تم حذف مصاريف الطالب '.$row->Student->name.' من النظام بنجاح');

    }

    public function search(Request $request)
    {
        $search = $request->search;
        if($search != null){
            $rows = Salary::where('date',$search)->paginate();  
            $student_count = count(Student::get()->all());  
            return view('admin.salary.index',compact('rows','search','student_count'));
        }
        else {
            return redirect()->route('admin.salary.index');
        }
        
    }
}
