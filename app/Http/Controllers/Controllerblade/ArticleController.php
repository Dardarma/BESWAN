<?php

namespace App\Http\Controllers\controllerblade;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Materi;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);

            $article = Materi::select('materi.id', 'materi.judul', 'materi.deskripsi', 'materi.id_level', 'level.urutan_level')
            ->join('level', 'materi.id_level', '=', 'level.id')
            ->when($search, function ($query, $search) {
                $query->where('materi.judul', 'like', '%' . $search . '%')
                    ->orWhere('materi.deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('level.urutan_level', 'like', '%' . $search . '%');
            })
            ->paginate($paginate);
            
    
            return view('admin_page.article.index', compact('article'));
        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $level = Level::select('id', 'urutan_level','nama_level')->get();

        return view('admin_page.article.add', compact('level'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
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

        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $article = Materi::findorfail($id);
            $level = Level::select('id', 'urutan_level')->get();

            return view('admin_page.article.edit', compact('article', 'level'));
        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
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
        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $article = Materi::findorfail($id);
            $article->delete();
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
        
    }
}
