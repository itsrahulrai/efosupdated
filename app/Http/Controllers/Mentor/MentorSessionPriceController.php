<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentorSessionPrice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MentorSessionPriceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentor_profiles,id',
            'duration_minutes' => ['required', 'in:15,20,25,30,40,45,60,90',
                Rule::unique('mentor_session_prices')
                    ->where('mentor_id', $request->mentor_id)],
            'session_type' => 'required|in:video,chat,call',
            'meeting_platform' => 'required|in:zoom,google_meet,teams',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',

        ]);

        $data = $request->all();

        /* if free session */
        if ($request->is_free == 1)
        {
            $data['price'] = 0;
            $data['discount_price'] = null;
        }
        $data['status'] = 1; // default active
        MentorSessionPrice::create($data);
        return redirect()->back()->with('success', 'Session price created successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sessionPrice = MentorSessionPrice::findOrFail($id);
        $request->validate([
            'mentor_id' => 'required|exists:mentor_profiles,id',
            'duration_minutes' => ['required', 'in:15,20,25,30,40,45,60,90',
                Rule::unique('mentor_session_prices')
                    ->where('mentor_id', $request->mentor_id)
                    ->ignore($id),
            ],
            'session_type' => 'required|in:video,chat,call',
            'meeting_platform' => 'required|in:zoom,google_meet,teams',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
        ]);
        $data = $request->all();
        /* if free session */
        if ($request->is_free == 1)
        {
            $data['price'] = 0;
            $data['discount_price'] = null;
        }
        $sessionPrice->update($data);
        return redirect()->back()->with('success', 'Session price updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $sessionPrice = MentorSessionPrice::findOrFail($id);
        $sessionPrice->delete();
        return redirect()
            ->back()
            ->with('success', 'Session price deleted successfully');

    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mentor_session_prices,id',
            'status' => 'required|boolean',
        ]);

        $mentorSessionPrice = MentorSessionPrice::findOrFail($request->id);
        $mentorSessionPrice->status = $request->status;
        $mentorSessionPrice->save();

        return response()->json([
            'success' => true,
            'message' => 'Session price status updated successfully',
        ]);
    }
}
