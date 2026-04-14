<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json(['status' => false,'message' => 'Invalid email or password',], 401);
        }

        $user = Auth::user();
        // mentor approval check
        if ($user->role == 'mentor')
        {
            if (!$user->mentorProfile || $user->mentorProfile->status != 'approved')
            {
                return response()->json(['status' => false,'message' => 'Mentor account not approved',], 403);
            }
        }

        // franchise approval check
        if ($user->role == 'franchise')
        {
            if (!$user->franchiseProfile || $user->franchiseProfile->status != 'approved')
            {

                return response()->json(['status' => false,'message' => 'Franchise account not approved',], 403);
            }
        }

        // create token
        $token = $user->createToken('mobile-app')->plainTextToken;
        return response()->json([
            'status' => true,'message' => 'Login successful',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    ],
                    
                    ],
        ]);

    }

    // student dashboard
    public function studentDashboard(Request $request)
    {
        if ($request->user()->role != 'student')
        {
            
            return response()->json(['status' => false,'message' => 'Unauthorized',], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $request->user(),
        ]);

    }

    // mentor dashboard
    public function mentorDashboard(Request $request)
    {
        if ($request->user()->role != 'mentor')
        {
            return response()->json(['status' => false,'message' => 'Unauthorized',], 403);
        }
        return response()->json(['status' => true,'data' => $request->user(),]);
    }

    // franchise dashboard
    public function franchiseDashboard(Request $request)
    {
        if ($request->user()->role != 'franchise')
        {
            return response()->json(['status' => false,'message' => 'Unauthorized',], 403);
        }

        return response()->json(['status' => true,'data' => $request->user(),
        ]);
    }

  public function logout(Request $request)
  {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }
}
