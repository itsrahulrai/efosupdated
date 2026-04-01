<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentorAvailability;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MentorAvailabilityController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentor_profiles,id',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_gap' => 'required|numeric|min:5|max:120',
            'timezone' => 'required',
        ]);

        /* overlap check */

        $overlap = MentorAvailability::where('mentor_id', $request->mentor_id)
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                        });
                        })->exists();
            
                        if ($overlap) {
                            throw ValidationException::withMessages([
                            'start_time' => 'This time slot overlaps with existing availability',
                            ]);
                            }
                    /* save */
                    MentorAvailability::create([
                        'mentor_id' => $request->mentor_id,
                        'day' => $request->day,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'slot_gap' => $request->slot_gap,
                        'timezone' => $request->timezone,
                        'is_active' => 1,
                    ]);

        return back()->with('success', 'Time slot added successfully');
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {

        $availability = MentorAvailability::findOrFail($id);
        $request->validate([
            'mentor_id' => 'required|exists:mentor_profiles,id',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_gap' => 'required|numeric|min:5|max:120',
            'timezone' => 'required',
        ]);


        /* overlap check */
        $overlap = MentorAvailability::where('mentor_id', $request->mentor_id)
            ->where('day', $request->day)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                            });
                            })->exists();
            if ($overlap) {
                throw ValidationException::withMessages([
                'start_time' => 'This time slot overlaps with existing availability'
                ]);
                }


        /* update */

        $availability->update([
            'mentor_id' => $request->mentor_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slot_gap' => $request->slot_gap,
            'timezone' => $request->timezone
        ]);
        return back()->with('success', 'Time slot updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $availability = MentorAvailability::findOrFail($id);
        $availability->delete();

        return redirect()
            ->back()
            ->with('success', 'Mentor availability deleted successfully');
    }
}
