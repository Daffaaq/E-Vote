<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 20);

        // Initialize the query
        $query = Banner::query();
        $banners =
            Banner::paginate(10);
        // Apply the search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('tittle', 'LIKE', '%' . $search . '%')
                    ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
        $banners = $query->select(['id', 'tittle', 'desc'])
            ->orderBy('tittle', 'ASC')
            ->paginate($perPage)
            ->withQueryString();

        return view('Superadmin.Banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Superadmin.Banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg|max:2048', // Validate as a file with specific mime types
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image')->store('banner', 'public'); // Store the file in the 'banner' directory within the 'public' disk

            Banner::create([
                'tittle' => $request->title,
                'desc' => $request->description,
                'image' => $file // Save the file path in the database
            ]);

            return redirect()->route('banner.index')
                ->with('success', 'Banner created successfully.');
        }

        return redirect()->route('banner.index')
            ->with('error', 'Failed to upload image.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('superadmin.Banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048' // Validate file if provided
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            // Store the new image
            $file = $request->file('image')->store('banner', 'public');

            // Delete the old image file if it exists
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Update the banner with the new image
            $banner->update([
                'tittle' => $request->title,
                'desc' => $request->description,
                'image' => $file // Save the file path in the database
            ]);

            return redirect()->route('banner.index')
                ->with('success', 'Banner updated successfully.');
        }

        // If no new image is uploaded, update only the other fields
        $banner->update([
            'tittle' => $request->title,
            'desc' => $request->description,
        ]);

        return redirect()->route('banner.index')
            ->with('success', 'Banner updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('banner.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
