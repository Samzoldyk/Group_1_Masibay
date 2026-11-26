<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')
            ->latest()
            ->paginate(10);

        // Collection helper: map()
        // Str helpers: limit() and slug()
        $announcements->setCollection(
            $announcements->getCollection()->map(function ($announcement) {
                $announcement->short_content = Str::limit(
                    $announcement->content,
                    150
                );

                return $announcement;
            })
        );

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $data['student_id'] = $request->user()->id;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $filename = Str::slug(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            );

            $filename = $filename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $data['attachment_path'] = $file->storeAs(
                'announcements',
                $filename,
                'public'
            );
        }

        unset($data['attachment']);

        Announcement::create($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('attachment')) {
            if ($announcement->attachment_path) {
                Storage::disk('public')->delete(
                    $announcement->attachment_path
                );
            }

            $file = $request->file('attachment');

            $filename = Str::slug(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            );

            $filename = $filename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $data['attachment_path'] = $file->storeAs(
                'announcements',
                $filename,
                'public'
            );
        }

        unset($data['attachment']);

        $announcement->update($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->attachment_path) {
            Storage::disk('public')->delete(
                $announcement->attachment_path
            );
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
