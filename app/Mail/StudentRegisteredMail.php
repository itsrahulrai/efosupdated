<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Student;

class StudentRegisteredMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $student;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('EFOS User Registration')
            ->view('emails.student_registered')
            ->with([
                'name' => $this->student->name,
                 'email' => $this->student->email, 
                'registration_number' => $this->student->registration_number,
                'password' => $this->student->phone,
            ]);
    }
}
