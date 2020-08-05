<?php

namespace App\Exports;

use App\User;
use App\Student_Detail;
use App\Student_Bus_Fare;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
}
