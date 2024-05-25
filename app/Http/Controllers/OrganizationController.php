<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Representative;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::query();

        // Поиск по названию организации
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('legal_address', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        }

        $organizations = $query->paginate(10);

        return view('organizations.index', compact('organizations'));
    }

    public function show(Organization $organization)
    {
        $representatives = $organization->representatives()->paginate(10);
        $events = $organization->events()->paginate(10);
        return view('organizations.show', compact('organization', 'representatives', 'events'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'legal_address' => 'required',
           'email' => 'required|email|unique:organizations,email',
        ]);

        Organization::create($request->all());

        return redirect()->route('organizations.index')->with('success', 'Организация успешно добавлена');
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required',
            'legal_address' => 'required',
            'email' => 'required|email|unique:organizations,email,'.$organization->id,
        ]);

        $organization->update($request->all());

        return redirect()->route('organizations.index')->with('success', 'Организация обновлена');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Организация удалена');
    }
}
