<?php

namespace App\Http\Requests\Auth;

use App\Models\Student;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['nullable', 'string', 'email'],
            'registration_number' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }

 public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    /**
     * ===============================
     * STUDENT LOGIN
     * ===============================
     * Can login using:
     * - registration_number
     * - email
     * - phone
     */
    if ($this->filled('registration_number')) {

        $loginValue = trim($this->registration_number);

        $student = Student::where('registration_number', $loginValue)
            ->orWhere('phone', $loginValue)
            ->orWhereHas('user', function ($q) use ($loginValue) {
                $q->where('email', $loginValue);
            })
            ->with('user')
            ->first();

        if (! $student || ! $student->user) {
            throw ValidationException::withMessages([
                'registration_number' => 'Invalid Email / Registration Number / Phone.',
            ]);
        }

        if (! Hash::check($this->password, $student->user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Invalid password.',
            ]);
        }

        Auth::login($student->user);
        RateLimiter::clear($this->throttleKey());
        return;
    }

    /**
     * ===============================
     * ADMIN / FRANCHISE LOGIN
     * ===============================
     * Email + Password only
     */
    if (! Auth::attempt(
        $this->only('email', 'password'),
        $this->boolean('remember')
    )) {

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}


    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

   public function throttleKey(): string
    {
        return Str::lower(
            ($this->registration_number ?? $this->email ?? '') . '|' . $this->ip()
        );
    }

}
