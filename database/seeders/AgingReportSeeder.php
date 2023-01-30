<?php

namespace Database\Seeders;

use App\Models\Masters\AgingReport;
use App\Models\Masters\BusinessPartner;
use App\Models\Masters\Customer;
use App\Models\Masters\User;
use Illuminate\Database\Seeder;
use PDO;

class AgingReportSeeder extends Seeder
{
    function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d', $val);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $businessPartner = BusinessPartner::take(5)->get();
        $user = User::find(1);
        $customer = Customer::take(5)->get();
        AgingReport::withoutEvents(function () use ($businessPartner, $user, $customer) {
            $count = 5;
            for ($i = 1; $i <= $count; $i++) {
                $startDate = $this->randomDate('2022-11-01', '2022-11-15');
                $endDate = $this->randomDate('2022-11-26', '2022-11-31');
                $agingReport = new AgingReport;
                $cstm = $customer->random();
                $agingReport->fill([
                    'bpid' => $businessPartner->random()->bpid,
                    'userid' => $user->userid,
                    'usercode' => "USR20221203" . $user->userid,
                    'userfullname' => $user->userfullname,
                    'cstmcode' => "CSTM20221203" . $cstm->cstmid,
                    'cstmname' => $cstm->cstmname,
                    'invno' => "INSN20320230$i",
                    'invdate' => $startDate,
                    'duedate' => $endDate,
                    'outstandinginv' => 1,
                ]);
                $agingReport->save();
            }
        });
    }
}
