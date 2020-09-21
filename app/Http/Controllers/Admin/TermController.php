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
            'end_classes_date' => 'required|date|after:start_date',
            'end_date' => 'required|date|after_or_equal:end_classes_date',
            'is_active' => 'sometimes|string'
        ]);
        $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');

        $termInfo = $this->getTermNameAndCode();

        if ($termInfo['name'] == null || $termInfo['code'] == null || Term::where(['code' => $termInfo['code']])->exists()) {
            flash('Tworzenie semestru nie powiodło się')->error();
            return redirect()->route('admin.terms.index');
        }

        if (!Term::create(array_merge($validatedData, $termInfo))) {
            flash('Tworzenie semestru nie powiodło się')->error();
            return redirect()->route('admin.terms.index');
        }

        if ($validatedData['is_active']) {
            $this->setIsActiveFalseInOtherTerm();
        }

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
            'name' => 'required|unique:terms,name,'. $currentTerm->id,
            'code' => 'required|unique:terms,code,'. $currentTerm->id,
            'start_date' => 'required|date',
            'end_classes_date' => 'required|date|after:start_date',
            'end_date' => 'required|date|after_or_equal:end_classes_date',
            'is_active' => 'sometimes|string'
        ]);

        $validatedData['is_active'] = (($validatedData['is_active'] ?? '') == 'is_active');

        if ($validatedData['is_active']) {
            $this->setIsActiveFalseInOtherTerm();
        }

        $currentTerm->update($validatedData);

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

    private function getTermNameAndCode(): array
    {
        $start_date = Carbon::createFromFormat('Y-m-d', request()->input('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d', request()->input('end_date'));

        $name = null;
        $code = null;

        if ($start_date->year == ($end_date->year - 1) && $start_date->month == 10 && $end_date->month == 2) {
            $name = 'Semestr zimowy ' . $start_date->year . '/' . $end_date->year;
            $code = $start_date->format('y') . '/' . $end_date->format('y') . 'Z';
        } elseif (($start_date->year == $end_date->year) && $start_date->month == 2 && $end_date->month == 9) {
            $name = 'Semestr letni ' . ($start_date->year - 1) . '/' . $end_date->year;
            $code = ($start_date->format('y') - 1) . '/' . $end_date->format('y') . 'L';
        } elseif (($start_date->year == ($end_date->year - 1)) && $start_date->month == 10 && $end_date->month == 9) {
            $name = 'Rok akademicki ' . $start_date->year . '/' . $end_date->year;
            $code = $start_date->format('y') . '/' . $end_date->format('y');
        }
        return ['name' => $name, 'code' => $code];
    }

    private function setIsActiveFalseInOtherTerm(): void
    {
        $terms = Term::all();
        foreach ($terms as $term) {
            $term->update(['is_active' => false]);
        }
    }

}
