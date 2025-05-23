<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UserExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::get(['name', 'email', 'password_change_count','name_change_count', 'login_count']);
    }

    public function headings() :array
    {
        return ["ID","Name", "Email", "Psw", "Created at", "Updated at", 'Password changes', 'Name changes', 'Login count'];
    }

}
