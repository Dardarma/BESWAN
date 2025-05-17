<?php

namespace App\Http\Controllers\controllerblade;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);

            $article = Materi::select('materi.id', 'materi.judul', 'materi.deskripsi', 'materi.id_level', 'level.urutan_level',)
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->when($search, function ($query, $search) {
                    $query->where('materi.judul', 'like', '%' . $search . '%')
                        ->orWhere('materi.deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('level.urutan_level', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);


            return view('admin_page.article.index', compact('article'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $level = Level::select('id', 'urutan_level', 'nama_level')->get();

        return view('admin_page.article.add', compact('level'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            request()->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'id_level' => 'required|integer',
                'konten' => 'required'
            ]);


            Materi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'id_level' => $request->id_level,
                'konten' => $request->konten,
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->route('article')->with(['success' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $article = Materi::findorfail($id);
            $level = Level::select('id', 'urutan_level', 'nama_level')->get();

            return view('admin_page.article.edit', compact('article', 'level'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            request()->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'id_level' => 'required|integer',
                'konten' => 'required'
            ]);

            $article = Materi::findorfail($id);
            $article->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'id_level' => $request->id_level,
                'konten' => $request->konten,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->route('article')->with(['success' => 'Data berhasil diubah']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $article = Materi::findorfail($id);
            $article->delete();
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function materi(Request $request)
    {
        try {
            $role = Auth::user()->role;
            $paginate = $request->input('paginate', 10);
            $search = $request->input('search');

            // Query dasar
            $materiQuery = Materi::select(
                'materi.id',
                'materi.judul',
                'materi.deskripsi',
                'materi.id_level',
                'level.urutan_level',
                'level.warna'

            )
                ->join('level', 'materi.id_level', '=', 'level.id');

            // Filter berdasarkan role
            if (!in_array($role, ['superadmin', 'teacher'])) {
                $levelIds = auth()->user()->levels->pluck('id')->toArray();
                $materiQuery->whereIn('materi.id_level', $levelIds);
            }

            // Search
            if ($search) {
                $materiQuery->where(function ($query) use ($search) {
                    $query->where('materi.judul', 'like', "%{$search}%")
                        ->orWhere('materi.deskripsi', 'like', "%{$search}%")
                        ->orWhere('level.urutan_level', 'like', "%{$search}%");
                });
            }

            // Sorting dan Pagination
            $materi = $materiQuery
                ->orderBy('level.urutan_level', 'desc')
                ->orderBy('materi.created_at', 'desc')
                ->paginate($paginate);

            return view('user_page.materi.materi_list', compact('materi'), [
                'judul' => 'Data Materi'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function materiDetail($id)
    {
        try {

            $materi = Materi::select('materi.id', 'materi.judul', 'materi.deskripsi', 'materi.konten', 'materi.id_level', 'level.urutan_level', 'level.nama_level', 'media.id as id_media', 'media.url_video')
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->leftjoin('media', 'materi.id', '=', 'media.id_materi')
                ->where('materi.id', $id)
                ->firstOrFail();

            // dd($materi);
            return view('user_page.materi.materi_isi', compact('materi'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
