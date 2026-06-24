<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request) {
        $query = Activity::query();

        if (request('tanggal')) {
            $query->whereDate('created_at', request('tanggal'));
        }

        $data = $query->latest()->get();
        return view ('pages.log-aktivitas.index', compact('data'));
    }
}
