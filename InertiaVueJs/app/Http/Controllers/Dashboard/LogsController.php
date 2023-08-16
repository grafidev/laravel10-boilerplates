<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;
use Inertia\Inertia;

class LogsController extends Controller
{
    public function __construct(private LogRepository $logRepository)
    {
    }

    public function index($channel = 'actions')
    {
        $files = $this->logRepository->getFiles($channel);

        return Inertia::render('Admin/Logs', compact('files', 'channel'));
    }

    public function show($channel = 'actions', $date = null)
    {
        $info = $this->logRepository->getFilesInfo($channel, $date);

        return Inertia::render('Admin/ShowLog', compact('info'));
    }
}
