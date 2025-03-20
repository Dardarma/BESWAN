<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Models\Activity_feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10);
        $feed = Activity_feed::select('id','judul_activity','deskripsi_activity','file_media','created_by','updated_by','created_at')
            ->when($search, function($query,$search){
                $query->where('judul_activity','like','%'.$search.'%')
                    ->orWhere('deskripsi_activity','like','%'.$search.'%')
                    ->orWhere('created_by','like','%'.$search.'%')
                    ->orWhere('updated_by','like','%'.$search.'%')
                    ->orWhere('created_at','like','%'.$search.'%');
            })
            ->paginate($paginate);
        return view('admin_page.feed.index',compact('feed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validate([
                'judul_activity' => 'required|string',
                'deskripsi_activity' => 'required|string',
                'file_media' => 'required|file|mimes:jpg,jpeg,png,mp4,webm,ogg,mp3,wav,flac,3gp,avi,mkv|max:2048',
            ]);

            $pathfile = $request->file('file_media')->store('public/feed');

            Activity_feed::create([
                'judul_activity' => $request->judul_activity,
                'deskripsi_activity' => $request->deskripsi_activity,
                'file_media' => $pathfile,
                'created_by' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'judul_activity' => 'required|string',
                'deskripsi_activity' => 'required|string',
                'file_media' => 'file|mimes:jpg,jpeg,png,mp4,webm,ogg,mp3,wav,flac,3gp,avi,mkv|max:2048',
            ]);

            $feed = Activity_feed::findOrFail($id);
            $feed->update([
                'judul_activity' => $request->judul_activity,
                'deskripsi_activity' => $request->deskripsi_activity,
                'file_media' => $request->file('file_media') ? $request->file('file_media')->store('public/feed') : $feed->file_media,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $feed = Activity_feed::findOrFail($id);
            $feed->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
