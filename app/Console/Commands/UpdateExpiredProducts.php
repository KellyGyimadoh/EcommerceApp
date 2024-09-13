<?php

namespace App\Console\Commands;

use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentdate=Carbon::now();
        Products::where('expiry_date','<=',$currentdate)->where('status',0)->update(['status'=>1]);
        $this->info('Expired product updated');
    }
}
