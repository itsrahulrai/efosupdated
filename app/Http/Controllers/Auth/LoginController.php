<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index()
    {
        return view('student.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('registration_number', $request->registration_number)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['registration_number' => 'Invalid credentials']);
    }
    public function create() { return redirect()->route('student.index'); }
    public function show($id) { }
    public function edit($id) { }
    public function update(Request $request, $id) { }
    public function destroy($id) { Auth::logout(); return redirect()->route('student.index'); }
}
