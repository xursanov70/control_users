<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartWorkRequest;
use App\Models\ControlWork;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControlWorkController extends Controller
{
    public $schedules;

    public function __construct()
    {
        $this->schedules = Schedule::orderBy('id', 'desc')->first();
    }
    public function startWork()
    {
        $auth = auth()->user();
        $date = Carbon::now();
        $schedule = Carbon::parse($date->toDateString() . $this->schedules->start_work);
        $control = ControlWork::where('user_id', $auth->id)
            ->where('start_work', '>=', $date->toDateString())
            ->first();

        if ($control) {
            return response()->json(["message" => "Bir kunda qayta urinish qilyapsiz!"], 401);
        }

        $controlWork = ControlWork::create([
            'user_id' => $auth->id,
            'start_work' => $date,
        ]);

        if ($date->greaterThan($schedule)) {
            $controlWork->late = true;
            $controlWork->on_time_start = false;
        } else {
            $controlWork->on_time_start = true;
            $controlWork->late = false;
        }
        $controlWork->save();
        return response()->json(["message" => "Ishga kelganingiz tasdiqlandi!"], 200);
    }


    public function endWork()
    {
        $auth = auth()->user();
        $date = Carbon::now('Asia/Tashkent');

        $scheduleEnd = Carbon::parse($date->toDateString() . ' ' . $this->schedules->end_work, 'Asia/Tashkent');

        $control = ControlWork::where('user_id', $auth->id)->where('active', true)->first();

        if (!$control) {
            return response()->json(["message" => "Siz ishga kelishni tasdiqlamagansiz!"], 401);
        }

        $control->end_work = $date;

        if ($date->lessThan($scheduleEnd)) {
            $control->early = true;
            $control->on_time_end = false;
        } else {
            $control->on_time_end = true;
            $control->early = false;
        }

        $control->active = false;
        $control->save();
        return response()->json(["message" => "Ishni tugatganingiz tasdiqlandi!"], 200);
    }
}
