<?php 
namespace App\Http\Controllers;

use Validator;
use App\Model\User;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    protected $user_repository;
    public function __construct(UserRepository $user_repository)
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
        $this->user_repository = $user_repository;
    }

    // public function getUserInfor()
    // {
    //     if(!auth()->user())
    //     {
    //         return response()->json(['Message' => 'Not Authorized']);
    //     }
    //     else 
    //     {
    //         $id = auth()->user()->id;
    //         $user = $this->userRepository->getSingle($id);
    //         if($user == null)
    //         {
    //             return response()->json(['Message' => "This page doesn't exist"]);
    //         }
    //         else 
    //         {
    //             $post = $this->userRepository->getSingle($id);
    //             return response()->json($user);
    //         }
    //     }

    //     // return response()->json(request(['password','name']));
    // }

    // public function updateUserInfor()
    // {
    //     if(!auth()->user())
    //     {
    //         return response()->json(['Message' => 'Not Authorized']);
    //     }
    //     else 
    //     {
    //         $user = array(
    //             'name' => request('name'),
    //             'email' => request('email'),
    //             'password' => Hash::make(request('password'))
    //         );
    //         $userUpdated = $this->userRepository->updateUserInfor($user);
    //         if($userUpdated)
    //         {
    //             return response()->json($userUpdated);
    //         }   
    //         else 
    //         {
    //             return response()->json(['Message' => 'Cannot update user']);
    //         }
    //     }
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return $this->responseForbidden($validation->messages()->first());
        }

        // if (!$token) {
        //     return $this->responseUnauthorized();
        // }

        $credentials = $request->only(['email', 'password']);

        try {
        	if ($token = $this->guard()->attempt($credentials)) {
    			return $this->responseWithToken($token);
	        }

            return $this->responseUnauthorized(trans('auth.login_fail'));
        } catch (Exception $e) {
        	return $this->responseInternalError($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'student_code' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return $this->responseForbidden($validation->messages()->first());
        }

        $checkExist = $this->user_repository->checkStudentCode($request->student_code);
        if($checkExist)
        {
            return $this->responseForbidden('Sinh viên này đã tồn tại trong hệ thống');
        }
        else 
        {
            $user = new User();
            $user->id = Uuid::generate(4);
            $user->student_code = $request->student_code;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return $this->response(new UserResource($user));
        }

        // $credentials = request(['name', 'email', 'password']);

        // $user = $this->userRepository->store($credentials);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    private function guard(){
        return Auth::guard();
    }

    private function responseWithToken($token){
		$header = [
            'Authorization' => $token
        ];
        $data = [
            'access_token' => $token
        ];
    	return $this->response($data, trans('auth.login_successful'), $header);
	}
}