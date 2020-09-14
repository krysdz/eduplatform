<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::all();

        return view('admin.terms.index', [
            'terms' => $terms,
        ]);
    }

    public function create()
    {
        return view('admin.terms.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active' => 'sometimes|string'
        ]);
        $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');

        $start_date = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));

        if ($start_date->year < $end_date->year) {
            $name = 'Semestr zimowy '.$start_date->year.'/'.$end_date->year;
        } elseif ($start_date->year == $end_date->year) {
            $name = 'Semestr letni '.($start_date->year - 1).'/'.$end_date->year;
        } else {
            flash('Tworzenie semestru nie powiodło się')->error();
            return redirect()->route('admin.terms.index');
        }

        if (!$validatedData) {
            flash('Tworzenie semestru nie powiodło się')->error();
            return redirect()->route('admin.terms.index');
        }

        if (!Term::create(array_merge($validatedData, ['name' => $name]))) {
            flash('Tworzenie semestru nie powiodło się')->error();
            return redirect()->route('admin.terms.index');
        }
        
        $this->setIsActiveFalseInOtherTerm($validatedData['is_active']);
        flash('Tworzenie semestru powiodło się')->success();
        return redirect()->route('admin.terms.index');
    }

    public function show(Request $request, int $id)
    {
        $term = Term::findOrFail($id);
        return view('admin.terms.show', ['term' => $term]);
    }

    public function edit(Request $request, int $id)
    {
        $term = Term::findOrFail($id);
        return view('admin.terms.edit', ['term' => $term]);
    }

    public function update(Request $request, int $id)
    {
        $currentTerm = Term::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:terms,name,'.$currentTerm->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active' => 'sometimes|string'
        ]);

        $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');

        if (!$validatedData) {
            flash('Aktualizacja semestru nie powiodła się')->error();
            return redirect()->route('admin.terms.index');
        }

        if (!$currentTerm->update($validatedData)) {
            flash('Aktualizacja semestru nie powiodła się')->error();
            return redirect()->route('admin.terms.index');
        }
        
        $this->setIsActiveFalseInOtherTerm($validatedData['is_active']);
        flash('Aktualizacja semestru powiodła się')->success();
        return redirect()->route('admin.terms.index');
    }

    public function destroy(Request $request, int $id)
    {
        if (!Term::findOrFail($id)->delete()) {
            flash('Usuwanie semestru nie powiodło się')->error();
        }

        flash('Usuwanie semestru powiodło się')->success();
        return redirect()->route('admin.terms.index');
    }
    
    private function setIsActiveFalseInOtherTerm($is_active): void
    {
        if ($is_active) {
            $terms = Term::all();
            foreach ($terms as $term) {
                $term->update(['is_active' => false]);
            }
        }
    }
}
