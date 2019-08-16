<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Models\Disability;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\Section;
use App\Models\Student;
use App\Models\Blood_Group;
use App\Models\Orphange;
use App\Models\Student_Detail;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonHelper;
use Image;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Redirect;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('students')) {
            $students = Student::orderBy('id','desc')->get();
            //print_r($students);die();
            return View('admin.students.index',['students'=>$students]);
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Menu::hasAccess('students','create')) {
            $religions = Religion::get();
            $genders = Gender::get();
            $disabilities = Disability::orderBy('id','desc')->get();
            $sections = Section::orderBy('id','desc')->get();
            $blood_group = Blood_Group::orderBy('id','asc')->get();
            $orphanges = Orphange::orderBy('id','asc')->get();
            return View('admin.students.create', compact('religions', 'genders', 'disabilities','sections','blood_group','orphanges'));
        } else {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request,Requests\StudentImageRequest $request)
    {
        if (Menu::hasAccess("students", "create")) {
            $user_id = Auth::id();
            $data = $request->except(['religion_id','class_id','disability_id','dob','departure_date','student_image','student_smile_image','student_poster_image']);
            $data['dob'] = !is_null($request->dob) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->dob))) : '';
            $data['admission_date'] = !is_null($request->admission_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->admission_date))) : '';
            $data['departure_date'] = !is_null($request->departure_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->departure_date))) : '';

            $data['religion_id'] = !empty($request->religion_id) ? $request->religion_id : null;
            $data['class_id'] = !empty($request->class_id) ? $request->class_id : null;
            $data['disability_id'] = !empty($request->disability_id) ? $request->disability_id : null;
            $data['created_by'] =$user_id;
            $data['created_ip_address'] = CommonHelper::getRealIpAddr();
            $student = Student::create($data);
            //upload image if exist
            $student_path = $student->name . '_' . $student->id;
            $path = public_path() . '/uploads/students/' . $student_path;
            $database_image_folder_path='/uploads/students/' . $student_path;
            if (!File::exists($path)) {
                $student_upload_directory = File::makeDirectory($path, 0777, true, true);

                if ($student_upload_directory == true) {
                    //Image 1
                    if ($request->hasFile('student_image')) {
                        $student_image = $request->file('student_image');
                        $image_name = '/main.' .$student_image->getClientOriginalExtension();
                        //$details_image_name = '/details.' .$student_image->getClientOriginalExtension();
                        $student_path_image=$path . $image_name;
                        //$student_details_path_image=$path . $details_image_name;

                        Image::make($student_image->getRealPath())->resize(360, 300)->save($student_path_image);
                        //Image::make($student_image->getRealPath())->resize(600, 422)->save($student_details_path_image);

                        $database_image_path=$database_image_folder_path.$image_name;
                        // $database_details_image_path=$database_image_folder_path.$details_image_name;
                        $student->student_image =$database_image_path;
                        // $student->student_detail_image =$database_details_image_path;
                        $student->save();
                    }
                    /*
                    //Image 2
                    if ($request->hasFile('student_smile_image')) {
                        $student_smile_image = $request->file('student_smile_image');
                        $image_name = '/smile.' .$student_smile_image->getClientOriginalExtension();
                        $student_path_image=$path . $image_name;

                        Image::make($student_smile_image->getRealPath())->resize(360, 300)->save($student_path_image);

                        $database_image_path=$database_image_folder_path.$image_name;
                        $student->student_smile_image =$database_image_path;
                        $student->save();
                    }
                    //Image 3
                    if ($request->hasFile('student_poster_image')) {
                        $student_poster_image = $request->file('student_poster_image');
                        $image_name = '/poster.' .$student_poster_image->getClientOriginalExtension();
                        $student_path_image=$path . $image_name;

                        Image::make($student_poster_image->getRealPath())->resize(780, 480)->save($student_path_image);

                        $database_image_path=$database_image_folder_path.$image_name;
                        $student->student_poster_image =$database_image_path;
                        $student->save();
                    }
                    */
                }

            }

            Session::flash('seccess_msg',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.students.index');

        } else {
            return View('error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("students", "view")) {

            $student = Student::find($id);
            return View('admin.students.show', compact('student'));
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('students','edit')) {
            $religions = Religion::orderBy('id','desc')->get();
            $genders = Gender::orderBy('id', 'desc')->get();
            $disabilities = Disability::orderBy('id','desc')->get();
            $sections = Section::orderBy('id','desc')->get();
            $student = Student::find($id);
            $blood_group = Blood_Group::orderBy('id','asc')->get();
            $orphanges = Orphange::orderBy('id','asc')->get();
            $birth_day = str_replace('-', '/', date('d-m-Y', strtotime($student->dob)));
            //$birth_day =$student->dob;

            if($student->departure_date=='0000-00-00')
            {
                $departureDate =null;
            }
            else
            {
                $departureDate = str_replace('-', '/', date('d-m-Y', strtotime($student->departure_date)));
            }
            if($student->admission_date=='0000-00-00')
            {
               $admissionDate =null;
            }
            else
            {
                $admissionDate = str_replace('-', '/', date('d-m-Y', strtotime($student->admission_date))); 
                
            }
            
            
            //dd($student);
            return View('admin.students.edit', compact('religions', 'genders', 'disabilities','sections','student','birth_day','admissionDate','departureDate','orphanges','blood_group'));
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        if (Menu::hasAccess("students", "edit")) {
            $user_id=Auth::id();

            $student = Student::find($id);
            $data = $request->except(['religion_id','class_id','disability_id','dob','admission_date','departure_date','student_image','student_smile_image','student_poster_image']);
            $data['dob'] = !is_null($request->dob) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->dob))) : '';
            $data['admission_date'] = !is_null($request->admission_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->admission_date))) : '';
            $data['departure_date'] = !is_null($request->departure_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->departure_date))) : '';

            $data['religion_id'] = !empty($request->religion_id) ? $request->religion_id : null;
            $data['class_id'] = !empty($request->class_id) ? $request->class_id : null;
            $data['disability_id'] = !empty($request->disability_id) ? $request->disability_id : null;
            $data['updated_by'] =$user_id;
            $data['updated_ip_address'] = CommonHelper::getRealIpAddr();

            $student->fill($data);
            if ($student->isDirty('id_card')) {
                $this->validate($request,[
                    'id_card' => 'required|max:150|unique:students'
                ]);
            }

            $student->update($data);

            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));

            //echo Session::get('seccess_msg');die();

            return redirect()->route(config('laraadmin.adminRoute') . '.students.index');

        } else {
            return View('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess("Students", "delete")) {
            $student = Student::find($id);

            //delete existing image folder
            $student_path = $student->name . '_' . $student->id;
            $path = public_path() . '/uploads/students/' . $student_path;
            if (File::exists($path)){
                File::deleteDirectory($path);
            }

            $student->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.students.index');
        } else {
            return View('error');
        }
    }

    public function image($id)
    {
        $student = Student::find($id);
        return View('admin.students.image_showcase', compact('student'));

    }

    public function updateImage($id, Requests\StudentImageRequest $request)
    {

        $student = Student::find($id);

        $student_folder = $student->name . '_' . $student->id;
        $path = public_path() . '/uploads/students/' . $student_folder;

        if (!File::exists($path)) 
        {
            File::makeDirectory($path, 0777, true, true);
        }


        $student_path = public_path() . '/uploads/students/' . $student->name . '_' . $student->id;

        $database_image_folder_path='/uploads/students/' . $student->name . '_' . $student->id;



        //Image 1
        if ($request->hasFile('student_image')) {
            $student_image = $request->file('student_image');
            $image_name = '/main.' .$student_image->getClientOriginalExtension();
            // $details_image_name = '/details.' .$student_image->getClientOriginalExtension();
            $student_path_image=$student_path . $image_name;
            //dd($student_path_image);
            //$student_details_path_image=$student_path . $details_image_name;
            if (file_exists($student_path_image)) {
                //first unlink the image
                @unlink($student_path_image);
                //@unlink($student_path_image);
            }
            Image::make($student_image->getRealPath())->resize(360, 300)->save($student_path_image);
            // Image::make($student_image->getRealPath())->resize(600, 422)->save($student_details_path_image);

            $database_image_path=$database_image_folder_path.$image_name;
            //$database_details_image_path=$database_image_folder_path.$details_image_name;
            $student->student_image =$database_image_path;
            //$student->student_detail_image =$database_details_image_path;
            $student->save();
        }

        /*
        //Image 2
        if ($request->hasFile('student_smile_image')) {
            $student_smile_image = $request->file('student_smile_image');
            $image_name = '/smile.' .$student_smile_image->getClientOriginalExtension();
            $student_path_image=$student_path . $image_name;
            if (file_exists($student_path_image)) {
                //first unlink the image
                @unlink($student_path_image);
            }
            Image::make($student_smile_image->getRealPath())->resize(360, 300)->save($student_path_image);
            $database_image_path=$database_image_folder_path.$image_name;
            $student->student_smile_image =$database_image_path;
            $student->save();
        }
        //Image 3
        if ($request->hasFile('student_poster_image')) {
            $student_poster_image = $request->file('student_poster_image');
            $image_name = '/poster.' .$student_poster_image->getClientOriginalExtension();
            $student_path_image=$student_path . $image_name;
            if (file_exists($student_path_image)) {
                //first unlink the image
                @unlink($student_path_image);
            }
            Image::make($student_poster_image->getRealPath())->resize(780, 480)->save($student_path_image);
            $database_image_path=$database_image_folder_path.$image_name;

            $student->student_poster_image =$database_image_path;
            $student->save();
        }
        */

        Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.students.index');

    }

    public function studentDetails($id)
    {
        if (Menu::hasAccess("Students", "create")) {
            $student = Student::find($id);
            $student_details = Student_Detail::where('student_id', $id)->orderBy('id','desc')->limit('10')->get();
            return View('admin.students.student_details', compact('student', 'student_details'));
        } else {
            return View('error');
        }
    }

    public function detailsStore(Requests\StudentDetailsRequest $request)
    {
        if (Menu::hasAccess("students", "create")) {
            $student = Student::find($request->student_id);

            //Attachment uploads
            $student_path = $student->name . '_' . $student->id;
            $path = public_path() . '/uploads/students/' . $student_path.'/details/';
            $database_image_folder_path='/uploads/students/' . $student_path.'/details/';
            //dd($path);
            if (!File::exists($path)) {
                $student_upload_directory = File::makeDirectory($path, 0777, true, true);

            } else {
                $student_upload_directory = $path;
            }

            if ($student_upload_directory == true) {
                //Attachment
                if ($request->hasFile('attachment')) {
                    $attachment = $request->file('attachment');
                    $image_name = time().'.'.$attachment->getClientOriginalExtension();
                    $attachment->move($path, $image_name);
                    $database_image_path=$database_image_folder_path.$image_name;
                }
            }


            $user_id = Auth::id();
            $data = $request->except(['attachment','date']);
            $data['date'] = !is_null($request->date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->date))) : '';
            $data['attachment'] = !empty($database_image_path) ? $database_image_path : null;
            $data['created_by'] =$user_id;
            $data['created_ip_address'] = CommonHelper::getRealIpAddr();
            $student_details = Student_Detail::create($data);
            Session::flash('seccess_msg',Lang::get('messages.Saved successfully'));
            return redirect()->back();

        } else {
            return View('error');
        }
    }

    public function detailUpdate($id, $detail_id)
    {
        if (Menu::hasAccess('students','edit')) {
            $student_Details_single = Student_Detail::find($detail_id);
            $student = Student::find($id);
            $student_details = Student_Detail::where('student_id', $id)->orderBy('id','desc')->get();
            $date = str_replace('-', '/', date('d-m-Y', strtotime($student_Details_single->date)));
            return View('admin.students.student_details', compact('student', 'student_details', 'student_Details_single','date'));
        } else {
            return View('error');
        }
    }

    public function detailUpdateStore(Requests\StudentDetailsRequest $request)
    {
        if (Menu::hasAccess('students','edit')) {
            $data = [];
            //$database_image_path=null;
            $student = Student::find($request->student_id);
            $student_Details_single = Student_Detail::find($request->student_detail_id);

            //Attachment uploads
            //Attachment
            if ($request->hasFile('attachment')) {

                $student_path = $student->name . '_' . $student->id;
                $path = public_path() . '/uploads/students/' . $student_path . '/details/';
                $database_image_folder_path = '/uploads/students/' . $student_path . '/details/';

                if (!File::exists($path)) {
                    $student_upload_directory = File::makeDirectory($path, 0777, true, true);

                } else {
                    $student_upload_directory = $path;
                }

                if(empty($student_Details_single->attachment))
                {
                    //....upload

                    //Attachment

                    $attachment = $request->file('attachment');
                    $image_name = time().'.'.$attachment->getClientOriginalExtension();
                    $attachment->move($path, $image_name);
                    $database_image_path=$database_image_folder_path.$image_name;



                }
                else
                {
                    //....unlink and upload
                    $exsisting_path = public_path() . $student_Details_single->attachment;
                    @unlink($exsisting_path);

                    $attachment = $request->file('attachment');
                    $image_name = time().'.'.$attachment->getClientOriginalExtension();
                    $attachment->move($path, $image_name);
                    $database_image_path=$database_image_folder_path.$image_name;
                }

            }
            else
            {
                if(empty($student_Details_single->attachment))
                {
                    $database_image_path=null;
                }
                else
                {
                    $database_image_path=$student_Details_single->attachment;
                }
            }

            //dd('not directory');

            $user_id = Auth::id();
            $data = $request->except(['attachment', 'student_detail_id','date']);
            $data['date'] = !is_null($request->date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->date))) : '';
            $data['created_by'] = $user_id;
            $data['created_ip_address'] = CommonHelper::getRealIpAddr();
            $data['attachment'] =$database_image_path;
            $student_Details_single->update($data);
            Session::flash('seccess_msg', Lang::get('messages.Saved successfully'));
            return redirect()->back();
        }

    }

    public function detailDelete($id, $detail_id)
    {
        if (Menu::hasAccess("Students", "delete")) {
            $student = Student::find($id);
            $student_details = Student_Detail::find($detail_id);

            //delete existing image folder
            if(!empty($student_details->attachment))
            {
                //....unlink and upload
                $exsisting_path = public_path() . $student_details->attachment;
                @unlink($exsisting_path);
            }

            $student_details->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return Redirect::to(config('laraadmin.adminRoute') .'/students/details/'.$id);
        } else {
            return View('error');
        }
    }

}
