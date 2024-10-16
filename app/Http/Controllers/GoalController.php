<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\Day;
use App\Models\Goal;
use App\Models\Task;
use App\Models\User;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->goals;
        return view('goal.index', compact('goals'));
    }
    public function show($id)
    {
        $user = User::find(Auth::id());
        $goals = Auth::user()->goals;

        $today = Carbon::now('Europe/Warsaw')->format('Y-m-d');
        $week = $user->weeks()->where('start', '<=', $today)->where('end', '>=', $today)->first();

        // CHECKING AND CREATING WEEKS IF ITS NOT CREATED
            $start = Carbon::now('Europe/Warsaw')->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
            $end = Carbon::now('Europe/Warsaw')->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

            if (!$week) {

                $week = Week::create([
                    'start' => $start,
                    'end' => $end,
                    'result' => null,
                    'user_id' => $user->id,
                ]);

                for ($i = 1; $i <= 7; $i++) {
                    $dayDate = Carbon::parse($start)->addDays($i - 1)->format('Y-m-d');
                    Day::create([
                        'date' => $dayDate,
                        'day_number' => $i,
                        'result' => null,
                        'week_id' => $week->id,
                        'user_id' => $user->id,
                    ]);
                }
            }

            $nextWeekStart = Carbon::parse($week->end)->addDay()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
            $nextWeekEnd = Carbon::parse($nextWeekStart)->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');
            $nextWeek = $user->weeks()->where('start', $nextWeekStart)->where('end', $nextWeekEnd)->first();

            if (!$nextWeek) {
                $nextWeek = Week::create([
                    'start' => $nextWeekStart,
                    'end' => $nextWeekEnd,
                    'result' => null,
                    'user_id' => $user->id,
                ]);

                for ($i = 1; $i <= 7; $i++) {
                    $dayDate = Carbon::parse($nextWeekStart)->addDays($i - 1)->format('Y-m-d');
                    Day::create([
                        'date' => $dayDate,
                        'day_number' => $i,
                        'result' => null,
                        'week_id' => $nextWeek->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        // (FUTURE) CHECKING WEEK RESULTS
        // dd($user->weeks()->where('result', null)->where('end', '<', $today)->get());
        // GETTING DAYS FROM THIS AND NEXT WEEK
            $days = Day::whereBetween('date', [$today, Carbon::today('Europe/Warsaw')->addDays(4)])->get()->sortBy('date');
        // HANDLING DAY CHECK
            $notCompletedID = [];
            if(!Check::query()->where('date', $today)->first())
            {
                $weeksBeforeToday = $user->weeks;
                foreach ($weeksBeforeToday as $week) {
                    foreach ($week->days as $day) {
                        foreach ($day->tasks as $task) {
                            if (!$task->completed && $task->day->date < $today) {
                                $notCompletedID[] = $task->id;
                            }
                        }
                    }
                }

                Check::create([
                    'date' => $today,
                    'type' => 1,
                    'user_id' => $user->id,
                    'tasks' => $notCompletedID,
                ]);
            } else
            {
                $notCompletedID = Check::query()->where(['date' => $today])->first()->tasks;
            }

        // PRIORITY TASKS
            $priorityTasks = [];
            foreach ($week->days as $day) {
                foreach ($day->tasks as $task) {
                    if($task->priority == 5) { $priorityTasks[] = $task->day; }
                }
            }

            $notCompleted = Task::whereIn('id', $notCompletedID)->get();

        return view('goal.show', compact('week', 'days', 'goals', 'notCompleted', 'notCompletedID', 'priorityTasks'));
    }
    public function create()
    {
        return view('goal.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:45'],
            'tasks_number' => ['required', 'integer', 'between:1,8'],
            'end_date' => ['required', 'date'],
            'image' => ['required', 'string'],
        ]);
        $goal = Goal::create([
            'name' => $validated['name'],
            'end_date' => $validated['end_date'],
            'tasks_number' => $validated['tasks_number'],
            'image' => $validated['image'],
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('goal.show', [$goal->id]);
    }
}
