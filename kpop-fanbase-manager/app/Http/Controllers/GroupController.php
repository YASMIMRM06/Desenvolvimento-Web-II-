<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('songs')->orderBy('name')->paginate(12);
        return view('groups.index', compact('groups'));
    }

    public function show(Group $group)
    {
        $group->load('songs');
        return view('groups.show', compact('group'));
    }
}