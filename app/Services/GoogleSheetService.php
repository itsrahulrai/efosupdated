<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected Sheets $service;
    protected string $spreadsheetId;
    protected string $sheetName = 'Students';

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('EFOS Student Sync');

        $client->setScopes([
            'https://www.googleapis.com/auth/spreadsheets',
        ]);

        $client->setAuthConfig(base_path(env('GOOGLE_SHEETS_CREDENTIALS')));
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
    }

    /* ================= APPEND ================= */
    public function appendStudent(array $row): void
    {
        $values = [];
        foreach ($row as $value)
        {
            $values[] = $value === null ? '' : (string) $value;
        }

        $body = new ValueRange([
            'values' => [
                $values,
            ],
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

        Log::info('GoogleSheet APPEND success');
    }

    /* ================= FIND ROW ================= */
    public function findRowByStudentId(int $studentId): ?int
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
            // skip header

            if (isset($row[0]) && (string) $row[0] === (string) $studentId)
            {
                return $index + 1; // sheet rows are 1-based
            }
        }

        return null;
    }

    /* ================= UPDATE ================= */
    public function updateStudent(int $studentId, array $row): void
    {
        $rowNumber = $this->findRowByStudentId($studentId);

        if (!$rowNumber)
        {
            $this->appendStudent($row);
            return;
        }

        $values = [];
        foreach ($row as $value)
        {
            $values[] = $value === null ? '' : (string) $value;
        }

        $lastColumn = $this->columnLetter(count($values) - 1);

        $body = new ValueRange([
            'values' => [
                $values,
            ],
        ]);

        $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            "{$this->sheetName}!A{$rowNumber}:{$lastColumn}{$rowNumber}",
            $body,
            ['valueInputOption' => 'RAW']
        );

        Log::info('GoogleSheet UPDATE success', ['student_id' => $studentId]);
    }

    /* ================= DELETE ================= */
    public function deleteStudent(int $studentId): void
    {
        $rowNumber = $this->findRowByStudentId($studentId);

        if (!$rowNumber)
        {
            return;
        }

        $requests = [
            new Sheets\Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId' => 0, // ⚠ must be numeric sheetId, not name
                        'dimension' => 'ROWS',
                        'startIndex' => $rowNumber - 1,
                        'endIndex' => $rowNumber,
                    ],
                ],
            ]),
        ];

        $batchRequest = new BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $this->service->spreadsheets->batchUpdate(
            $this->spreadsheetId,
            $batchRequest
        );

        Log::info('GoogleSheet DELETE success', ['student_id' => $studentId]);
    }

    /* ================= COLUMN LETTER ================= */
    private function columnLetter(int $index): string
    {
        $letter = '';
        while ($index >= 0)
        {
            $letter = chr($index % 26 + 65) . $letter;
            $index = intdiv($index, 26) - 1;
        }
        return $letter;
    }

    public function getStudentRowMap(): array {
        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            "{$this->sheetName}!A:A"
        );

        $rows = $response->getValues() ?? [];
        $map = [];

        foreach ($rows as $index => $row)
        {
            if ($index === 0)
            {
                continue;
            }
            // skip header
            if (!empty($row[0]))
            {
                $map[(string) $row[0]] = $index + 1; // row number
            }
        }

        return $map;
    }

    /* ================= BATCH APPEND STUDENTS ================= */
    public function appendStudentsBatch(array $rows): void
    {
        if (empty($rows))
        {
            return;
        }

        $values = array_map(function ($row)
        {
            return array_map(
                fn($v) => $v === null ? '' : (string) $v,
                $row
            );
        }, $rows);

        $body = new ValueRange([
            'values' => $values,
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

        Log::info('GoogleSheet BATCH APPEND success', [
            'rows' => count($rows),
        ]);
    }

}
