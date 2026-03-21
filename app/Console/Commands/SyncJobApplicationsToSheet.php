<?php

namespace App\Console\Commands;

use App\Models\JobApplication;
use App\Services\JobApplicationGoogleSheetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncJobApplicationsToSheet extends Command
{
    protected $signature = 'sync:job-applications {--fresh : Clear sheet before insert}';

    protected $description = 'Sync all JobApplication records from database to Google Sheet';

    public function handle()
    {
        $this->info('Starting JobApplication sync...');

        $sheet = new JobApplicationGoogleSheetService();

        $applications = JobApplication::orderBy('id')->get();

        if ($applications->isEmpty())
        {
            $this->warn('No job applications found.');
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($applications->count());
        $bar->start();

        foreach ($applications as $application)
        {
            $sheet->append([
                $application->id,
                $application->student_id,
                $application->job_id,
                $application->job_title,
                $application->company_name,
                $application->district,
                $application->state,
                $application->status ?? 'Applied',
                optional($application->applied_at)->toDateTimeString(),
                optional($application->created_at)->toDateTimeString(),
                optional($application->updated_at)->toDateTimeString(),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info('JobApplication sync completed successfully');
        Log::info('JobApplication backfill sync completed');

        return Command::SUCCESS;
    }
}
