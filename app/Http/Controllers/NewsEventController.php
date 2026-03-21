<?php

namespace App\Http\Controllers;

use App\Models\NewsEvent;
use App\Models\NewsEventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NewsEventController extends Controller
{

    public function index()
    {
        $items = NewsEvent::with('images')->latest()->get();
        return view('backend.news-events.news-events', compact('items'));
    }

    public function create()
    {
        return view('backend.news-events.add-news-events');
    }


    public function store(Request $request)
    {
        $request->validate([
            'heading'     => 'required|string|max:255',
            'category'    => 'required|in:News,Events',
            'description' => 'required|string',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::transaction(function () use ($request) {
            $newsEvent = NewsEvent::create([
                'heading'     => $request->heading,
                'category'    => $request->category,
                'description' => $request->description,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {

                    $imageName = 'media_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('uploads/news'), $imageName);

                    NewsEventImage::create([
                        'news_event_id' => $newsEvent->id,
                        'image' => 'uploads/news/' . $imageName,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.news-events.index')
            ->with('success', 'Event created with multiple images.');
    }

    public function show(string $id)
    {
        //
    }


    public function edit(NewsEvent $newsEvent)
    {
        $newsEvent->load('images');
        return view('backend.news-events.add-news-events', compact('newsEvent'));
    }

public function update(Request $request, NewsEvent $newsEvent)
{
    $request->validate([
        'heading'     => 'required|string|max:255',
        'category'    => 'required|in:News,Events',
        'description' => 'required|string',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    DB::transaction(function () use ($request, $newsEvent) {

        $newsEvent->update([
            'heading'     => $request->heading,
            'category'    => $request->category,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if (!$img) continue;

                $imageName = 'media_' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/news'), $imageName);

                NewsEventImage::create([
                    'news_event_id' => $newsEvent->id,
                    'image' => 'uploads/news/' . $imageName,
                ]);
            }
        }
    });

    return redirect()
        ->route('admin.news-events.index')
        ->with('success', 'Event updated successfully.');
}



    public function destroy(NewsEvent $newsEvent)
        {
            foreach ($newsEvent->images as $img) {

                if (file_exists(public_path($img->image))) {
                    unlink(public_path($img->image));
                }
                $img->delete();
            }
            $newsEvent->delete();

            return redirect()
                ->route('admin.news-events.index')
                ->with('success', 'Deleted successfully.');
        }



    public function deleteImage($id)
    {
        $image = NewsEventImage::findOrFail($id);

        if (file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }

}
