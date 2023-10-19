<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportUser;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import(Request $request)
    {
        Excel::import(new ImportUser, $request->file('file')->store('files'));
        $user = User::whereDoesntHave('roles')->get();
        foreach ($user as $guru) {
            $guru->assignRole('guru');
        }
        return redirect()->back()->with('success', 'Data Guru Berhasil Diimport!');
    }
}
