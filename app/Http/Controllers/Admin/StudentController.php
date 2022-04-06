<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Row;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Picqer\Barcode\BarcodeGeneratorPNG;



class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'store','create','show','search']); 
    }
    public function index()
    {
        $search = '';
        $date = '';
        $rows = Student::latest()->paginate(10);
        $rows_count = count(Row::get()->all());
        return view('admin.students.index',compact('rows','search','rows_count','date'));
    }
    
    public function create()
    {
        $rows = Row::get()->all();
        $rows_count = count(Row::get()->all());
        return view('admin.students.create',compact('rows','rows_count'));
    }

    public function message()
    {
        return [
            'name.required' => 'يجب ادخال اسم الطالب',
            'phone.required' => ' (1) يجب ادخال رقم الطالب',
            'phone.digits' => 'يجب ادخال رقم صحيح يحتوى على 11 رقم',
            'phone.numeric' => 'رقم الطالب يجب ان يحتوى على ارقام فقط',
            'phone2.digits' => 'يجب ادخال رقم صحيح يحتوى على 11 رقم',
            'phone2.numeric' => 'رقم الطالب يجب ان يحتوى على ارقام فقط',
            'row.required' => 'يجب اختيار الصف',
        ];
    }

    public function Store(Request $request)
    {
        
        $phone2 = null;
        if($request->phone2 != null){
            $request->validate([
                'name' => 'required',
                'phone' => 'required|numeric|digits:11',
                'phone2' => 'required|numeric|digits:11',
                'row' => 'required'
            ],$this->message());
            $phone2 = $request->phone2;
        }else{
            $request->validate([
                'name' => 'required',
                'phone' => 'required|numeric|digits:11',
                'row' => 'required'
            ],$this->message());
        }
        try{
            $student = new Student;
            $student->name = $request->name;
            $student->phone = $request->phone;
            $student->phone2 = $phone2;
            $student->user_create = Auth::user()->id;
            $student->row_id = $request->row;
            $student->date = Carbon::now();
            $student->save();

            $number = $student->id;
            $generator = new BarcodeGeneratorPNG();
            $barcode =  base64_encode($generator->getBarcode($number, $generator::TYPE_CODE_128));
            $student->barcode = $barcode;
            $student->update();
            return redirect()->route('admin.students.create')->with('success','تم اضافة بيانات الطالب الى النظام بنجاح');
        }
        catch(Exception $ex){
            return redirect()->route('admin.students.create')->with('error','ex');
        }
        
        
        
        
        
    }

    public function show($id)
    {
        $rows = Row::get()->all();
        $student = Student::findOrFail($id);
        return view('admin.students.show',compact('rows','student'));
    }

    public function card($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.card',compact('student'));
    }


    public function edit($id)
    {
        try{
            $student = Student::findOrFail($id);
            $rows = Row::get()->all();
            return view('admin.students.edit',compact('rows','student'));
        }   
        catch(Exception $ex){

        }
    }

    public function update(Request $request , $id)
    {
        $student = Student::findOrFail($id);
            $phone2 = $student->phone2;
            if($request->phone2 != null){
                $request->validate([
                    'name' => 'required',
                    'phone' => 'required|numeric|digits:11',
                    'phone2' => 'required|numeric|digits:11',
                    'row' => 'required'
                ],$this->message());
                $phone2 = $request->phone2;
            }else{
                $request->validate([
                    'name' => 'required',
                    'phone' => 'required|numeric|digits:11',
                    'row' => 'required'
                ],$this->message());
            }
        try{
            
            if($student->name == $request->name &&
                $student->phone == $request->phone &&
                $student->phone2 == $request->phone2 &&
                $student->row_id == $request->row
            ){
                return redirect()->route('admin.students.edit',$student->id)->with('error','لم يتم تعديل بيانات الطالب '.$student->name.' لعدم التغيير البيانات');
            }
            else{
                $student->name = $request->name;
                $student->phone = $request->phone;
                $student->phone2 = $request->phone2;
                $student->row_id = $request->row;
                $student->update();
                return redirect()->route('admin.students.edit',$student->id)->with('success','تم تعديل بيانات الطالب '.$student->name.' من النظام بنجاح');

            }
        }   
        catch(Exception $ex){

        }
    }

    public function destroy($id)
    {
        try{
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->route('admin.students.index')->with('success','تم حذف بيانات الطالب '.$student->name.' من النظام بنجاح');
        }

        catch(Exception $ex){
            return redirect()->route('admin.students.index')->with('error','ex');
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $date = $request->date;
        if($search == null && $date == null){
            return redirect()->route('admin.students.index');
        }else if($search != null && $date == null){
            $rows = Student::where('id',$request->search)->paginate();
            $count_all_rows = count(Student::get()->all());
            if($count_all_rows == 0){
                $rows = Student::query()->where('name','LIKE','%'.$request->search.'%')->paginate(10);
            }

            $rows_count = count(Row::get()->all());
            return view('admin.students.index',compact('rows','search','rows_count','date'));
        }
        else if($search != null && $date == null){
            $rows = Student::query()->where('date','=',$request->date)->paginate();
            $rows_count = count(Row::get()->all());
            return view('admin.students.index',compact('rows','search','rows_count','date'));
        }else{
            $rows = Student::query()->where('id',$request->search)->where('date','=',$request->date)->paginate();
            $count_all_rows = count(Student::query()->where('id',$request->search)->where('date','=',$request->date)->get()->all());
            if($count_all_rows == 0){
                $rows = Student::query()->where('name','LIKE','%'.$request->search.'%')->where('date','=',$request->date)->paginate(10);
            }

            $rows_count = count(Row::get()->all());
            return view('admin.students.index',compact('rows','search','rows_count','date'));
        }
        
    }
}
