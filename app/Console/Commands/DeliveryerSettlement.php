<?php

namespace App\Console\Commands;

use App\Models\Deliveryer;
use App\Models\DeliveryerTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeliveryerSettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliveryer-settlement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $deliveryers = Deliveryer::whereStatus(Deliveryer::STATUS_ONLINE)->get();
        foreach ($deliveryers as $deliveryer) {
            $transaction = $deliveryer->generateTransaction();
            $transaction->status = DeliveryerTransaction::STATUS_PENDING;
            $transaction->save();
        }

        return 0;
    }
}
