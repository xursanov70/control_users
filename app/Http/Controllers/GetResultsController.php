<?php

namespace App\Http\Controllers;

use App\Models\ControlWork;


class GetResultsController extends Controller
{
    public function getResults()
    {
        if ($this->can('get', 'work') == 'denied'){
            return response()->json(["error"=> "Amaliyotga huquq yo'q"], 401);
        }
        
        $late = request('late');
        $early = request('early');
        $onTimeStart = request('onTimeStart');
        $onTimeEnd = request('onTimeEnd');

        return ControlWork::when($late !== null, function ($query) use ($late) {
            $query->where('late', $late);
        })
            ->when($early !== null, function ($query) use ($early) {
                $query->where('early', $early);
            })
            ->when($onTimeStart !== null, function ($query) use ($onTimeStart) {
                $query->where('on_time_start', $onTimeStart);
            })
            ->when($onTimeEnd !== null, function ($query) use ($onTimeEnd) {
                $query->where('on_time_end', $onTimeEnd);
            })
            ->orderBy('id', 'asc')
            ->paginate(15);
    }

    
}
