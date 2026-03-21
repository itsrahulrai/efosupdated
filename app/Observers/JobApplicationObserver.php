<?php

namespace App\Observers;

use App\Models\JobApplication;
use App\Services\JobApplicationGoogleSheetService;
use Illuminate\Support\Facades\Log;

class JobApplicationObserver
{
    public bool $afterCommit = true;

    protected function sheet(): JobApplicationGoogleSheetService
    {
        return new JobApplicationGoogleSheetService();
    }

    protected function map(JobApplication $a): array {
        return [
            $a->id,
            $a->student_id,
            $a->job_id,
            $a->job_title,
            $a->company_name,
            $a->district,
            $a->state,
            $a->status ?? 'Applied',
            optional($a->applied_at)->toDateTimeString(),
            optional($a->created_at)->toDateTimeString(),
            optional($a->updated_at)->toDateTimeString(),
        ];
    }

    public function created(JobApplication $application): void
    {
        try {
            Log::info('JobApplicationObserver CREATED', [
                'id' => $application->id,
            ]);

            $this->sheet()->append($this->map($application));

        }
        catch (\Throwable $e)
        {
            Log::error('GoogleSheet JobApplication CREATE failed', [
                'job_application_id' => $application->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ================= DELETE ================= */
    public function deleted(JobApplication $application): void
    {
        try {
            Log::info('JobApplicationObserver DELETED', ['id' => $application->id]);
            $this->sheet()->deleteByApplicationId($application->id);
        }
        catch (\Throwable $e)
        {
            Log::error('GoogleSheet JobApplication DELETE failed', [
                'job_application_id' => $application->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
