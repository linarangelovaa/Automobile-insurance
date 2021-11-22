<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;

class DeleteVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:vehicle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all softDeleted records and vehicles
    whose insurance_date is expired';

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
     * @return int
     */
    public function handle()
    {
        Vehicle::where('date', '<=', date('Y-m-d', strtotime('-1 days')))->forceDelete();
        Vehicle::whereNotNull('deleted_at')->forceDelete();
    }
}