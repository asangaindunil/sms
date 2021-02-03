<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\Validator as FacadesValidator;
   
class StudentController extends BaseController
{
    /**
     * Get students information api
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudentInformation()
    {

        $students = Student::all();
        return $this->sendResponse(StudentResource::collection($students), 'Students retrieved successfully.');

    }

   

    public function getSingleStudent(Request $request)
    {        
        $student = Student::find($request->id);
  
        if (is_null($student)) {
            return $this->sendError('Student not found.');
        }
   
        return $this->sendResponse(new StudentResource($student), 'Student retrieved successfully.');

    }

    public function deleteStudent(Request $request)
    {
        $student = Student::find($request->id);
  
        if (is_null($student)) {
            return $this->sendError('Student not found.');
        }
        $student->delete();
   
        return $this->sendResponse([], 'Student deleted successfully.');

    }
}