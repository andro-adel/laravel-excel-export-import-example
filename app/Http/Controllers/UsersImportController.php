<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\User;
use Illuminate\Http\Request;

class UsersImportController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('users.import' , [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file')->store('import');

        $import = new UsersImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }


        return back()->withStatus('Import in queue, we will send notification after import finished.');
    }
}
