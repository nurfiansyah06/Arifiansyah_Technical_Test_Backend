<?php

namespace App\Console\Commands;

use App\Models\Penalties;
use Illuminate\Console\Command;

class UpdateIsExistsPenalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-is-exists-penalty';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update is exists penalty';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Penalties::whereDate('end_date', '<=', now())->update(['is_exists' => false]);
    }
}
