<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Http\Requests\LevelStore;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10); 
    
        $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level')
            ->when($search, function ($query, $search) {
                $query->where('nama_level', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi_level', 'like', '%' . $search . '%');
            })
            ->orderBy('urutan_level', 'asc')
            ->paginate($paginate);
    
        return view('admin_page.level.levelList', compact('level', 'search', 'paginate'), ['judul' => 'Data Level']);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LevelStore $request)
    {
        try {
           Level::create([
                'nama_level' => $request->nama_level,
                'deskripsi_level' => $request->deskripsi_level,
                'urutan_level' => $request->urutan_level
            ]);

            return redirect()->route('level')->with('success', 'Berhasil menambahkan level');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan level: ' . $e->getMessage()]);
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
    public function update(LevelStore $request, string $id)
    {
        try{
            $level = Level::find($id);
            $level->nama_level = $request->nama_level;
            $level->deskripsi_level = $request->deskripsi_level;
            $level->urutan_level = $request->urutan_level;
            $level->save();

            return redirect()->route('level')->with('success', 'Berhasil mengubah level');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengubah level: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $level = Level::find($id);

            DB::table('level_murid')->where('id_level',$id)->delete();

            $level->delete();

            return redirect()->route('level')->with('success', 'Berhasil menghapus level');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus level: ' . $e->getMessage()]);
        }
    }
}
