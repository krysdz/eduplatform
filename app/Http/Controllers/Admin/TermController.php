<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;

class TermController extends Controller
{
    public function index()
    {
        return view('modules.administrator.terms.index', [
            'terms' => Term::orderByDesc('start_date')->get(),
        ]);
    }

    public function create()
    {
        return view('modules.administrator.terms.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_classes_date' => 'required|date|after:start_date',
            'end_date' => 'required|date|after_or_equal:end_classes_date',
        ]);

        try {
            $validatedData = array_merge($validatedData, $this->getTermNameAndCode());

            if (Term::where(['code' => $validatedData['code']])->orWhere(['name' => $validatedData['name']])->exists()) {
                throw new Exception('Semestr o podanych datach już istnieje.');
            }

            if ($validatedData['name'] == null || $validatedData['code'] == null) {
                throw new Exception('Podano błędne daty.');
            }

            Term::create($validatedData);

        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.terms.index')->with('success', 'Tworzenie semestru powiodło się.');
    }

    public function show( Term $term)
    {
        return view('modules.administrator.terms.show', ['term' => $term]);
    }

    public function edit( Term $term)
    {
        return view('modules.administrator.terms.edit', ['term' => $term]);
    }

    public function update(Request $request, Term $term)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:terms,name,' . $term->id,
            'code' => 'required|unique:terms,code,' . $term->id,
            'start_date' => 'required|date',
            'end_classes_date' => 'required|date|after:start_date',
            'end_date' => 'required|date|after_or_equal:end_classes_date',
        ]);

        try {
            $term->update($validatedData);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.terms.index')->with('success', 'Aktualizacja semestru powiodła się.');
    }

    public function destroy(Term $term)
    {
        try {
            if (!$term->delete()) {
                throw new Exception("Usuwanie semestru $term nie powiodło się.");
            }
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('administrator.terms.index')->with('success', "Usuwanie semestru $term powiodło się.");
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
        }

        return ['name' => $name, 'code' => $code];
    }



}
