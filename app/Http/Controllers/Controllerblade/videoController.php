<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class videoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $search = $request->input('search');
        $paginate = $request->input('paginate', 10);

        $video = Media::select(
            'media.id',
            'media.deskripsi',
            'media.id_materi',
            'media.url_video',
            'materi.updated_by',
            'materi.judul as judul_materi'
        )
            ->join('materi', 'media.id_materi', '=', 'materi.id')
            ->when($search, function ($query, $search) {
                $query->where('media.judul', 'like', '%' . $search . '%')
                    ->orWhere('media.deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('materi.judul', 'like', '%' . $search . '%');
            })
            ->paginate($paginate);

        $materi = Materi::select('id', 'judul')->get();

        return view('admin_page.video.index', compact('video', 'materi'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'deskripsi' => 'required|string',
                'id_materi' => 'required|integer',
                'url_video' => 'required|string',
            ]);

            $video = Media::create([
                'deskripsi' => $request->deskripsi,
                'id_materi' => $request->id_materi,
                'url_video' => $request->url_video,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);

            return redirect()->back()->with('success', 'Video berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'deskripsi' => 'required|string',
                'id_materi' => 'required|integer',
                'url_video' => 'required|string',
            ]);

            $video = Media::find($id);

            $video->update([
                'deskripsi' => $request->deskripsi,
                'id_materi' => $request->id_materi,
                'url_video' => $request->url_video,
                'updated_by' => auth()->user()->id
            ]);
            return redirect()->back()->with('success', 'Video berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Video gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $video = Media::findOrFail($id);
            $video->delete();
            return redirect()->back()->with('success', 'Video berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Video gagal dihapus');
        }
    }

    public function userVideo()
    {
        try {
            $role = Auth::user()->role;
            $paginate = request()->input('paginate', 10);
            $search = request()->input('search');

            $videoquery = Media::select(
                'media.id',
                'media.deskripsi',
                'media.id_materi',
                'media.url_video',
                'materi.judul as judul_materi',
                'level.id as id_level',
                'level.warna',
                'level.urutan_level'
            )
                ->join('materi', 'media.id_materi', '=', 'materi.id')
                ->join('level', 'materi.id_level', '=', 'level.id');

            if ($role == 'user') {
                $levelIds = Auth::user()->levels->pluck('id')->toArray();
                $videoquery->whereIn('level.id', $levelIds);
            }

            if ($search) {
                $videoquery->where(function ($query) use ($search) {
                    $query->where('media.deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('materi.judul', 'like', '%' . $search . '%');
                });
            }

            $video = $videoquery
                ->orderBy('level.urutan_level', 'desc')
                ->orderBy('media.created_at', 'desc')
                ->paginate($paginate);


            return view('user_page.video.video_list', compact('video'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function videoWatch($id)
    {
        try {
            $video = Media::findOrFail($id)
                ->select(
                    'media.id',
                    'media.deskripsi',
                    'media.id_materi',
                    'media.url_video',
                    'materi.judul as judul_materi',
                    'materi.deskripsi',
                    'level.nama_level',
                )
                ->join('materi', 'media.id_materi', '=', 'materi.id')
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->first();

            return view('user_page.video.video_watch', compact('video'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Video tidak ditemukan');
        }
    }
}
