<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function create()
    {
        return view('customer.create-project');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|string',
            'complexity' => 'required|integer|min:1|max:5',
        ]);

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'tech_stack' => $request->tech_stack,
            'complexity' => $request->complexity,
            'customer_id' => Auth::id(),
            'approved' => false,
        ]);

        return redirect()->route('customer.my-projects')->with('success', 'Проект отправлен на модерацию.');
    }

    public function myProjects()
    {
        $projects = Project::where('customer_id', Auth::id())->get();
        return view('customer.my-projects', compact('projects'));
    }
}
