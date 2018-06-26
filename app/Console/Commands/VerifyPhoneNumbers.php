<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\PhoneNumber;

class VerifyPhoneNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phone-numbers:verify {file : The path of the file to be read}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify input file containing phone numbers';

    /**
     * The headers for the output csv file.
     *
     * @var array
     */
    protected $headers = ['phone number', 'carrier', 'status'];

    /**
     * The array containing all of the PhoneNumber models.
     *
     * @var array
     */
    protected $phoneNumbers = [];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $file = fopen($filePath, 'r');
        // get number of lines in the file
        $rowCount = (int) trim(exec('perl -pe \'s/\r\n|\n|\r/\n/g\' ' . escapeshellarg($filePath) . ' | wc -l'));

        $this->line("\nReading file...\n");

        if (empty($filePath)) {
            $this->error("\nError opening file.\n");
            exit;
        }

        $size = filesize($filePath);

        if (empty($size)) {
            $this->error("\nFile is empty.\n");
            exit;
        }

        // create progress bar using $rowCount
        $bar = $this->output->createProgressBar($rowCount);
        $this->line("\nRows in file: $rowCount\n");

        while (($line = fgetcsv($file)) !== FALSE) {

            $phoneNumber = new PhoneNumber;
            $phoneNumber->number = $line[0];

            $this->line("\n\nLooking up phone number data for $phoneNumber->number...");

            $this->phoneNumbers[] = $phoneNumber->lookup();
            $bar->advance();
        }

        // open file for writing
        $file = fopen('output-' . date('Y-m-d-H-i') . '-' . uniqid() . '.csv', 'w');

        // write headers to file
        fputcsv($file, $this->headers);

        foreach ($this->phoneNumbers as $phoneNumber) {
            // add a row for each phone number to the generated output file
            $line = [$phoneNumber->number, $phoneNumber->carrier, $phoneNumber->status];
            fputcsv($file, $line);
        }

        // close the file
        fclose($file);

        $bar->finish();
        $this->info("\n\nDone!\n");

    }
}
