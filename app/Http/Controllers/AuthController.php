<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->userRepository = $userRepository;
    }

    public function getUserInfor()
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $id = auth()->user()->id;
            $user = $this->userRepository->getSingle($id);
            if($user == null)
            {
                return response()->json(['Message' => "This page doesn't exist"]);
            }
            else 
            {
                $post = $this->userRepository->getSingle($id);
                return response()->json($user);
            }
        }

        // return response()->json(request(['password','name']));
    }

    public function updateUserInfor()
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $user = array(
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password'))
            );
            $userUpdated = $this->userRepository->updateUserInfor($user);
            if($userUpdated)
            {
                return response()->json($userUpdated);
            }   
            else 
            {
                return response()->json(['Message' => 'Cannot update user']);
            }
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
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
}