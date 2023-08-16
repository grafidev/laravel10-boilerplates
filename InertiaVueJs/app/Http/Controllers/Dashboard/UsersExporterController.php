<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersExporterController extends Controller
{
    public function index(Request $request)
    {
        return (new UsersExport($request->userIds))->download('users.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
