<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $userArr = [
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => 'STUDENT',
            'password' => bcrypt($input['password']),
        ];

        $user = User::create($userArr);

        $student = [
            'name' => $input['name'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'status' => 1
        ];

        $student = Student::create($student);
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'Student register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $credentials = request(['email', 'password']);

            if (!$success['token'] = Auth::guard('users')->attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);

            $success['name'] =  $user->name;
            $success['id'] =  $user->id;

            return $this->sendResponse($success, 'Student login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
