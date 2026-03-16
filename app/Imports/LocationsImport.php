<?php

namespace App\Imports;

use App\Models\Tenant\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Enums\ChangeFrequency;

class LocationsImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading
{
    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time in the background
    }

    public function model(array $row)
    {
        // tryFrom returns the Enum case if it matches, otherwise null
        $frequency = ChangeFrequency::tryFrom(ucfirst(strtolower($row['frequency']))) ?? ChangeFrequency::WEEKLY;

        return Location::updateOrCreate(
            [
                'city' => $row['city'],
                'suburb' => $row['suburb'],
            ],
            [
                'change_frequency' => $frequency,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'city' => 'required|string',
            'suburb' => 'required|string',
        ];
    }
}