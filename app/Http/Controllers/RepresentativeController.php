<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Representative;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    public function create(Organization $organization): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('representatives.create', compact('organization'));
    }

    public function show(Representative $representative)
    {
        return view('representative.show', compact('representative'));
    }

    public function store(Request $request, Organization $organization): RedirectResponse
    {
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'patronymic' => 'nullable',
            'departament' => 'nullable',
            'phone' => 'required',
        ]);

        $organization->representatives()->create($request->all());

        return redirect()->route('organizations.show', $organization)->with('success', 'Представитель добавлен');
    }

    public function update(Request $request, Organization $organization, Representative $representative): RedirectResponse
    {
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'patronymic' => 'nullable',
            'departament' => 'nullable',
            'phone' => 'required',
        ]);

        $representative->update($request->all());

        return redirect()->route('organizations.show', $organization)->with('success', 'Представитель обновлён');
    }

    public function destroy(Organization $organization, Representative $representative): RedirectResponse
    {
        $representative->delete();

        return redirect()->route('organizations.show', $organization)->with('success', 'Представитель удалён');
    }
}
