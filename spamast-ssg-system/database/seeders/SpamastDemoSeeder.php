<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\Seeder;

class SpamastDemoSeeder extends Seeder
{
    public function run(): void
    {
        $institutes = [
            'IAS' => 'Institute of Arts and Sciences',
            'IPGS' => 'Institute of Professional and Graduate Studies',
            'IBMG' => 'Institute of Business Management and Governance',
            'IASDC' => 'Institute of Agricultural Sciences and Development Communication',
            'ICET' => 'Institute of Computing, Engineering, and Technology',
            'ITED' => 'Institute of Teacher Education',
            'IFMS' => 'Institute of Fisheries and Marine Sciences',
        ];

        $instituteRecords = [];

        foreach ($institutes as $code => $name) {
            $instituteRecords[$code] = Institute::updateOrCreate(
                ['code' => $code],
                ['name' => $name]
            );
        }

        $programs = [
            'IPGS' => ['MBA', 'PhD-EM', 'MAEd-ST', 'MAEd-EM', 'MAEd-MT', 'MSF', 'MSMBD'],
            'IBMG' => ['BPA', 'BSOA', 'BSAB', 'BSDC', 'BSAIS', 'BSTM'],
            'IASDC' => ['BSA', 'BSABE', 'BAT'],
            'ICET' => ['BSIT', 'ACT', 'BIndTech'],
            'ITED' => ['BEED', 'BSED-English', 'BSED-Math', 'BSED-Science', 'BTLEd'],
            'IFMS' => ['BSF', 'BSEnviSci', 'BSMB', 'DFT'],
        ];

        $programRecords = [];

        foreach ($programs as $instituteCode => $programCodes) {
            foreach ($programCodes as $programCode) {
                $instituteId = $instituteRecords[$instituteCode]->id;

                $program = Program::where('institute_id', $instituteId)
                    ->where('name', $programCode)
                    ->first();

                if (!$program) {
                    $program = Program::where('code', $programCode)->first();
                }

                if (!$program) {
                    $program = new Program();
                }

                $program->institute_id = $instituteId;
                $program->name = $programCode;
                $program->code = $programCode;
                $program->save();

                $programRecords[$programCode] = $program;
            }
        }

        $studentProgramCodes = array_keys($programRecords);

        for ($i = 1; $i <= 20; $i++) {
            $number = str_pad($i, 3, '0', STR_PAD_LEFT);
            $program = $programRecords[
                $studentProgramCodes[($i - 1) % count($studentProgramCodes)]
            ];

            Student::updateOrCreate(
                ['student_id' => 'DEMO-STU-' . $number],
                [
                    'name' => 'Demo Student ' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'email' => 'student' . str_pad($i, 2, '0', STR_PAD_LEFT) . '@spamast.test',
                    'password' => 'Password123!',
                    'course' => $program->name,
                    'program_id' => $program->id,
                    'year_level' => (($i - 1) % 4 + 1) . 'th Year',
                    'contact_number' => null,
                    'role' => 'student',
                ]
            );
        }

        $officerProgram = $programRecords['BSIT'];

        Student::updateOrCreate(
            ['student_id' => 'DEMO-OFF-001'],
            [
                'name' => 'Demo Officer',
                'email' => 'officer@spamast.test',
                'password' => 'Password123!',
                'course' => $officerProgram->name,
                'program_id' => $officerProgram->id,
                'year_level' => 'N/A',
                'contact_number' => null,
                'role' => 'officer',
            ]
        );

        Student::updateOrCreate(
            ['student_id' => 'DEMO-ADV-001'],
            [
                'name' => 'Demo Adviser',
                'email' => 'adviser@spamast.test',
                'password' => 'Password123!',
                'course' => $officerProgram->name,
                'program_id' => $officerProgram->id,
                'year_level' => 'N/A',
                'contact_number' => null,
                'role' => 'adviser',
            ]
        );

        $this->command->info('SPAMAST demo data seeded successfully.');
    }
}
