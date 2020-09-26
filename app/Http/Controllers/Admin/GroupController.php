<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DaysOfWeekEnum;
use App\Enums\GroupTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Term;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Sodium\add;


class GroupController extends Controller
{
    public function index()
    {
        return view('admin.groups.index', [
            'groups' => Group::all()
        ]);
    }


    public function create()
    {
        return view('admin.groups.create', [
            'courses' => Course::all(),
            'types' => GroupTypeEnum::toArray(),
            'days' => DaysOfWeekEnum::toArray(),
            'teachers' => Teacher::all(),
            'terms' => Term::all(),
            'students' => Student::all()
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'number' => 'required|integer',
            'type' => 'required|integer',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'term_id' => 'required|integer|exists:terms,id',
            'day_of_classes' => 'required|integer'
        ]);

        $validatedData['type'] = GroupTypeEnum::makeFromId($validatedData['type']);
        $validatedData['day_of_classes'] = DaysOfWeekEnum::makeFromId($validatedData['day_of_classes']);
        DB::beginTransaction();

        try {
            $group = Group::create($validatedData);
            $group->students()->attach(Student::find($request->input('students')));

            $this->generateLessons($group);

            DB::commit();
            flash('Tworzenie grupy powiodło się')->success();
            return redirect()->route('admin.groups.index');
        } catch (Exception $e) {
            DB::rollback();
            flash('Tworzenie grupy nie powiodło się - rollback')->error();
            return redirect()->route('admin.groups.index');
        }
    }


    public function show(int $id)
    {
        return view('admin.groups.show', [
            'group' => Group::findOrFail($id)
        ]);
    }


    public function edit(int $id)
    {
        return view('admin.groups.edit', [
            'group' => Group::findOrFail($id),
            'courses' => Course::all(),
            'types' => GroupTypeEnum::toArray(),
            'days' => DaysOfWeekEnum::toArray(),
            'teachers' => Teacher::all(),
            'terms' => Term::all(),
            'students' => Student::all()
        ]);
    }


    public function update(Request $request, int $id)
    {
        $currentGroup = Group::findOrFail($id);

        $validatedData = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'number' => 'required|integer',
            'type' => 'required|integer',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'term_id' => 'required|integer|exists:terms,id',
            'day_of_classes' => 'required|integer',
            'start_update_date' => 'nullable|date'
        ]);

        $validatedData['type'] = GroupTypeEnum::makeFromId($validatedData['type']);
        $validatedData['day_of_classes'] = DaysOfWeekEnum::makeFromId($validatedData['day_of_classes']);

        if ($validatedData['day_of_classes']->value != $currentGroup->day_of_classes->value) {
            $startUpdateDate = $validatedData['start_update_date'];

            $this->updateLessons($currentGroup, $startUpdateDate, $validatedData['day_of_classes']);
        }

        DB::beginTransaction();

        try {
            $currentGroup->update($validatedData);
            $currentGroup->students()->detach();
            $currentGroup->students()->attach(Student::find($request->input('students')));
            DB::commit();
            flash('Aktualizacja grupy powiodła się')->success();
            return redirect()->route('admin.groups.index');
        } catch (Exception $e) {
            DB::rollback();
            flash('Aktualizacja grupy nie powiodła się - rollback')->error();
            return redirect()->route('admin.groups.index');
        }

    }

    public function destroy($id)
    {
        if (!Group::findOrFail($id)->delete()) {
            flash('Usuwanie grupy nie powiodło się')->error();
        }

        flash('Usuwanie grupy powiodło się')->success();
        return redirect()->route('admin.groups.index');
    }

    public function generateLessons($group)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $group->term->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $group->term->end_classes_date);

        while ($start_date->dayOfWeek != $group->day_of_classes->value) {
            $start_date->addDay();
        }

        $lessonNumber = 1;

        while ($start_date <= $end_date) {
            Lesson::create([
                'group_id' => $group->id,
                'date' => $start_date,
                'number' => $lessonNumber++,
                'is_active' => false
            ]);

            $start_date->addWeek();
        }
    }

    public function updateLessons(Group $group, string $startUpdateDate, $dayOfClasses)
    {
        $lessonsToUpdate = $group->lessons()->where('date', '>=', $startUpdateDate)->orderBy('date')->get();
//        $lessonsToUpdate = $lessonsToUpdate instanceof Collection ? $lessonsToUpdate : collect($lessonsToUpdate);

        $start_date = !empty($startUpdateDate) ? Carbon::createFromFormat('Y-m-d', $startUpdateDate) : Carbon::today();
        $end_date = Carbon::createFromFormat('Y-m-d', $group->term->end_classes_date);

        while ($start_date->dayOfWeek != $dayOfClasses->value) {
            $start_date->addDay();
        }

        $newLessonsDate = [];
        while ($start_date <= $end_date) {
            array_push($newLessonsDate, $start_date->toImmutable());
            $start_date->addWeek();
        }

        $lessonNumber = $lessonsToUpdate->first()->number;
        for ($i = 0; $i < max($lessonsToUpdate->count(), count($newLessonsDate)); $i++) {
            if ($i < $lessonsToUpdate->count()) {
                if (isset($newLessonsDate[$i])) {
                    $lessonsToUpdate->get($i)->update(['date' => $newLessonsDate[$i], 'number' => $lessonNumber + $i]);
                } else {
                    $lessonsToUpdate->get($i)->delete();
                }
            } else {
                Lesson::create([
                    'group_id' => $group->id,
                    'date' => $newLessonsDate[$i],
                    'number' => $lessonNumber + $i,
                    'is_active' => false
                ]);
            }
        }
    }
}
