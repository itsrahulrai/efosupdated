<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class JobApplicationGoogleSheetService
{
    protected Sheets $service;
    protected string $spreadsheetId;
    protected string $sheetName = 'Applied Job';

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('EFOS Job Application Sync');
        $client->setScopes([
            'https://www.googleapis.com/auth/spreadsheets',
        ]);
        $client->setAuthConfig(base_path(env('GOOGLE_SHEETS_CREDENTIALS')));
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
    }

    /* ================= APPEND JOB APPLICATION ================= */
    public function append(array $row): void
    {
        $values = array_map(
            fn($v) => $v === null ? '' : (string) $v,
            array_values($row)
        );

        $body = new ValueRange([
            'values' => [$values],
        ]);

        $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            "{$this->sheetName}!A1",
            $body,
            [
                'valueInputOption' => 'RAW',
                'insertDataOption' => 'INSERT_ROWS',
            ]
        );

        Log::info('GoogleSheet JobApplication APPEND success');
    }

    /* ================= FIND ROW ================= */
    public function findRowByApplicationId(int $id): ?int
    {
        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            "{$this->sheetName}!A:A"
        );

        $rows = $response->getValues() ?? [];

        foreach ($rows as $index => $row)
        {
            if ($index === 0)
            {
                continue;
            }
            // header

            if (isset($row[0]) && (string) $row[0] === (string) $id)
            {
                return $index + 1; // Google Sheets is 1-based
            }
        }

        return null;
    }

    /* ================= DELETE ================= */
    public function deleteByApplicationId(int $id): void
    {
        $rowNumber = $this->findRowByApplicationId($id);

        if (!$rowNumber)
        {
            Log::warning('JobApplication row not found in sheet', [
                'job_application_id' => $id,
            ]);
            return;
        }

        $sheetId = $this->getSheetId();

        $request = new BatchUpdateSpreadsheetRequest([
            'requests' => [
                new Request([
                    'deleteDimension' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'dimension' => 'ROWS',
                            'startIndex' => $rowNumber - 1,
                            'endIndex' => $rowNumber,
                        ],
                    ],
                ]),
            ],
        ]);

        $this->service->spreadsheets->batchUpdate(
            $this->spreadsheetId,
            $request
        );

        Log::info('GoogleSheet JobApplication DELETE success', [
            'job_application_id' => $id,
        ]);
    }

    /* ================= GET SHEET ID ================= */
    private function getSheetId(): int
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);

        foreach ($spreadsheet->getSheets() as $sheet)
        {
            if ($sheet->getProperties()->getTitle() === $this->sheetName)
            {
                return $sheet->getProperties()->getSheetId();
            }
        }

        throw new \Exception("Sheet '{$this->sheetName}' not found");
    }
}
