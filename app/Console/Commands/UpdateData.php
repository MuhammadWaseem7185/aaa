<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User added';

    /**
     * Execute the console command.
     */
    public function handle()
{
        $this->adduser();
        $this->deletePendingOrders();
        $this->deletecancelOrders();

}

    public function adduser()              {
        $data['name']='waseem';
        $data['email']='waseem'.time().'@example.com';
        $data['password']=bcrypt('password');
        DB::table('users')->insert($data);
        $this->info('Data inserted successfully!');
    }

  private function deletePendingOrders()
    {
        $deleted = DB::table('orders')
            ->where('status', 'pending')
            ->delete();

        $this->info($deleted . ' pending orders deleted!');
    }

    private function deletecancelOrders()
    {
        $deleted = DB::table('orders')
            ->where('status', 'cancelled')
            ->delete();

        $this->info($deleted . ' cancel orders deleted!');
    }


}
