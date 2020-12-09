<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function usersImport()
    {
        ini_set('max_execution_time', 240);
        $data = Excel::toArray(new \App\Imports\UsersImport, storage_path('app/public/userIm.xlsx'));
        $i = 0;
        // dd($data);

        foreach ($data[0] as $d) {
            // dd($d);
            $name = trim($d[0]);
            $email = trim($d[1]);
            $password = trim($d[2]);
            $role = trim($d[3]);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user_count = User::where('email', $email)->count();
                if ($user_count == 0) {
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'role' => $role,
                    ]);
                }
            }

        }
        return "success : OK";
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
