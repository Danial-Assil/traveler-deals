<?php

namespace App\Http\Controllers\Dash;

use App\Events\User\TripPublished;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TripController extends DashController
{
    public function __construct(Trip $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => ['show', 'delete'],
        ]);
    }

    public function index()
    {
        $items = $this->model->withCount('requests')->get();

        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }

    public function accept($id)
    {
        $item = Trip::find($id); 
        return view($this->app_folder . '.pages.' . $this->module_name . '.accept', compact('item'));
    }

    public function do_accept(Request $request)
    {
        $item = Trip::find($request->trip_id);
        
        $data = [
            'status' => 2,
            'arrive_date' => $request->arrive_date,
            'arrive_time' => $request->arrive_time,
            'replied_at' => Carbon::now(),
        ];

        $item->update($data);
        event(new TripPublished($item));
        return redirect()->route('trips.show', $item->id);
    }
}
