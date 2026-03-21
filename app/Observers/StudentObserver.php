<?php

namespace App\Observers;

use App\Models\Student;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;

class StudentObserver
{
    public bool $afterCommit = true;

    protected function sheet(): GoogleSheetService
    {
        return new GoogleSheetService();
    }

    protected function map(Student $s): array {
        return [
            $s->id,
            $s->user_id,
            $s->franchise_id,
            $s->name,
            $s->phone,
            $s->email,
            $s->registration_number,
            $s->whatsapp,
            $s->age_group,
            $s->gender,
            $s->present_status,
            $s->state,
            $s->district,
            $s->looking_for,
            $s->agree_terms,
            $s->profile_summary,
            $s->pincode,
            $s->father_name,
            $s->mother_name,
            $s->category,
            $s->address,
            $s->highest_qualification,
            $s->tenth_board,
            $s->tenth_year,
            $s->tenth_marks,
            $s->tenth_stream,
            $s->twelfth_board,
            $s->twelfth_year,
            $s->twelfth_marks,
            $s->twelfth_stream,
            $s->graduation_university,
            $s->graduation_year,
            $s->graduation_marks,
            $s->graduation_stream,
            $s->graduation_field,
            $s->pg_university,
            $s->pg_year,
            $s->pg_marks,
            $s->pg_stream,
            $s->pg_field,
            $s->skill_type,
            $s->skill_trade,
            $s->skill_year,
            $s->experience_type,
            $s->passport,
            $s->relocation,
            $s->blood_group,
            $s->photo,
            $s->apply_type,
            $s->utm_source,
            $s->utm_medium,
            $s->utm_campaign,
            $s->utm_term,
            $s->utm_content,
            $s->profile_completed,
            optional($s->created_at)->toDateTimeString(),
            optional($s->updated_at)->toDateTimeString(),
        ];
    }

    /* ================= CREATE ================= */
    public function created(Student $student): void
    {
        try {
            Log::info('StudentObserver CREATED', ['id' => $student->id]);
            $this->sheet()->appendStudent($this->map($student));
        }
        catch (\Throwable $e)
        {
            Log::error('GoogleSheet CREATE failed', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ================= UPDATE ================= */
    public function updated(Student $student): void
    {
        $student->refresh();

        try {
            Log::info('StudentObserver UPDATED', ['id' => $student->id]);
            $this->sheet()->updateStudent($student->id, $this->map($student));
        }
        catch (\Throwable $e)
        {
            Log::error('GoogleSheet UPDATE failed', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ================= DELETE ================= */
    public function deleted(Student $student): void
    {
        try {
            Log::info('StudentObserver DELETED', ['id' => $student->id]);
            $this->sheet()->deleteStudent($student->id);
        }
        catch (\Throwable $e)
        {
            Log::error('GoogleSheet DELETE failed', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
