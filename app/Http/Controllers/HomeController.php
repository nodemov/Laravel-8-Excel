<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

// User
// FacadesExcel
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function usersImport()
    {
        ini_set('max_execution_time', 240);
        //\Excel::import(new \App\Imports\UsersImport, storage_path('app/public/Attendee-2020.xlsx'));
        $data = Excel::toArray(new \App\Imports\UsersImport, storage_path('app/public/userIm.xlsx'));
        $i = 0;
        dd($data[0]);

        for ($i = 0; $i < count($data[0]); $i++) {
            $name = trim($data[0][$i][0]);
            $email = trim($data[0][$i][1]);
            // echo $email;
            $password = trim($data[0][$i][2]);
            $role = trim($data[0][$i][3]);

            $user_count = User::where('email', $email)->count();

            // var_dump($user_count);
            // ." ";
           
            if ($user_count === 0) {
                //if($i==0){ $i++; continue; }
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => $role,
                ]);
            echo $user_count;

                continue;
            }else{
            // echo $user_count;

            }

        }
    }
}
