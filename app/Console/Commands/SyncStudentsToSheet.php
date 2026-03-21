<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncStudentsToSheet extends Command
{
    protected $signature = 'sync:students {--fresh : Clear sheet before insert}';

    protected $description = 'Sync all Student records from database to Google Sheet';

    public function handle()
    {
        $this->info('Starting Student sync...');

        $sheet = new GoogleSheetService();

        $students = Student::orderBy('id')->get();

        if ($students->isEmpty())
        {
            $this->warn('No students found.');
            return Command::SUCCESS;
        }

        // 🔥 Build rows ONCE
        $rows = $students->map(function ($student)
        {
            return [
                $student->id,
                $student->user_id,
                $student->franchise_id,
                $student->name,
                $student->phone,
                $student->email,
                $student->registration_number,
                $student->whatsapp,
                $student->age_group,
                $student->gender,
                $student->present_status,
                $student->state,
                $student->district,
                $student->looking_for,
                $student->agree_terms,
                $student->profile_summary,
                $student->pincode,
                $student->father_name,
                $student->mother_name,
                $student->category,
                $student->address,
                $student->highest_qualification,
                $student->tenth_board,
                $student->tenth_year,
                $student->tenth_marks,
                $student->tenth_stream,
                $student->twelfth_board,
                $student->twelfth_year,
                $student->twelfth_marks,
                $student->twelfth_stream,
                $student->graduation_university,
                $student->graduation_year,
                $student->graduation_marks,
                $student->graduation_stream,
                $student->graduation_field,
                $student->pg_university,
                $student->pg_year,
                $student->pg_marks,
                $student->pg_stream,
                $student->pg_field,
                $student->skill_type,
                $student->skill_trade,
                $student->skill_year,
                $student->experience_type,
                $student->passport,
                $student->relocation,
                $student->blood_group,
                $student->photo,
                $student->apply_type,
                $student->utm_source,
                $student->utm_medium,
                $student->utm_campaign,
                $student->utm_term,
                $student->utm_content,
                $student->profile_completed,
                optional($student->created_at)->toDateTimeString(),
                optional($student->updated_at)->toDateTimeString(),
            ];
        });

        // 🚀 CHUNK + BATCH APPEND (quota-safe)
        $rows->chunk(300)->each(function ($chunk) use ($sheet)
        {
            $sheet->appendStudentsBatch($chunk->toArray());
        });

        $this->info('Student sync completed successfully.');
        Log::info('Student backfill sync completed');

        return Command::SUCCESS;
    }
}
