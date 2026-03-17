<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Testing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Mail::raw('Hello! This is a raw simple email from Laravel.', function ($message) {
            $message->to('nabilahahmad.nordin@student.iium.edu.my')
                ->subject('Test Raw Email');
        });
    }
}
