@extends('admin.layout')
@section('title', "Harmonogramy dla $group - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Harmonogramy dla {{$group}}</h1>
        <a class="button is-normal ml-5" href="{{route('admin.groups.group_schedules.create', $group)}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj harmonogram</span>
            </span>
        </a>

    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
        <tr>
            <th>Id</th>
            <th>Dzień tygodnia</th>
            <th>Interwał</th>
            <th>Data rozpoczęcia</th>
            <th>Data zakończenia</th>
            <th>Godzina rozpoczęcia</th>
            <th>Godzina zakończenia</th>
            <th>Nauczyciel</th>
            <th>Sala</th>
        </tr>
        </thead>
     <tbody>
     @foreach($group_schedules as $group_schedule)
         <tr>
             <td>{{$group_schedule->id}}</td>
             <td>{{\App\Enums\DayOfWeekType::getDescription($group_schedule->day_of_week_type)}}</td>
             <td>{{$group_schedule->interval_days}}</td>
             <td>{{$group_schedule->first_date}}</td>
             <td>{{$group_schedule->last_date}}</td>
             <td>{{$group_schedule->start_time}}</td>
             <td>{{$group_schedule->end_time}}</td>
             <td>{{$group_schedule->teacher}}</td>
             <td>{{$group_schedule->room_name}}</td>

             <td>
                 <a class="button is-small is-info" href="{{route('admin.groups.group_schedules.edit', [$group, $group_schedule])}}">Edytuj</a>
             </td>
             <td>
                 <form action="{{route('admin.groups.group_schedules.destroy', [$group, $group_schedule])}}" method="POST">
                     @method('DELETE')
                     @csrf
                     <button class="button is-small is-danger" type="submit">Usuń</button>
                 </form>
             </td>
         </tr>
     @endforeach
     </tbody>

    </table>
@endsection

