<?php

namespace Database\Seeders;

use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $data = [
        [
            'username' => 'developer',
            'userpassword' => 'user123',
            'userfullname' => "Men in black",
            'userappaccess' => 107,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 2,
        ],
        [
            'username' => 'guanting123',
            'userpassword' => 'guanting123',
            'userfullname' => "Guanting Yin",
            'userappaccess' => 107,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 3,
            'userdtsgid' => 1,
        ],
        [
            'username' => 'saiful123',
            'userpassword' => 'saiful123',
            'userfullname' => "Saiful Anwar",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 3,
            'userdtsgid' => 4
        ],
        [
            'username' => 'nurul123',
            'userpassword' => 'nurul123',
            'userfullname' => "Nurul Rahma",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 3,
            'userdtsgid' => 2
        ],
        [
            'username' => 'mansur123',
            'userpassword' => 'mansur123',
            'userfullname' => "Mansur Umar",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 4,
            'userdtsgid' => 3
        ],
        [
            'username' => 'vina123',
            'userpassword' => 'vina123',
            'userfullname' => "Vina Guntur",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 4,
            'userdtsgid' => 3
        ],
        [
            'username' => 'günter123',
            'userpassword' => 'günter123',
            'userfullname' => "Günter Hermenegild",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 4,
            'userdtsgid' => 5
        ],
        [
            'username' => 'yuki123',
            'userpassword' => 'yuki123',
            'userfullname' => "Yuki Katsurou",
            'userappaccess' => 106,
            // userdetail
            'userdtbpid' => 1,
            'userdttypeid' => 4,
            'userdtsgid' => 5
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $dt) {
            User::withoutEvents(function () use ($dt) {
                $data = collect($dt);
                $data = $data->merge(['useremail' => $data->get('username') . "@gmail.com"]);
                $data = $data->merge(['userphone' => '08343234235']);
                $data = $data->merge(['userpassword' => Hash::make($data->get('userpassword'))]);
                $modelUser = new User;
                $user = $modelUser->fill($data->only($modelUser->getFillable())->toArray());
                if ($user->save()) {
                    UserDetail::withoutEvents(function () use ($data, $user) {
                        $data = $data->merge(['userid' => $user->userid]);
                        $modelDetail = new UserDetail;
                        $detail = $modelDetail->fill($data->only($modelDetail->getFillable())->toArray());
                        $detail->save();
                    });
                }
            });
        }
    }
}
