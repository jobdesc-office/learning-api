<?php

namespace App\Console\Commands;

use App\Services\PullDataServices;
use Illuminate\Console\Command;

class PullDataDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:pull-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull data Dashboard every day';

    public function handle(PullDataServices $pullDataServices) : void
    {
        try {
            $pullDataServices->dspbycust();
            $pullDataServices->dspbycustlabel();
            $pullDataServices->dspbycustlabeldt();
            $pullDataServices->dspbyowner();
            $pullDataServices->dspbystage();
            $pullDataServices->dspbystagedt();
            $pullDataServices->dspbystatus();
            $pullDataServices->dspbystatusdt();
        } catch (\Exception $exception) {
            echo "Failed to process data: " . $exception->getMessage();
        }
    }
}
