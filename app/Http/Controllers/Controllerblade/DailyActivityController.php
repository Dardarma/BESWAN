<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyActivity;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);
    
            $daily_activity = DailyActivity::select('id','activity')
                ->when($search, function($query,$search){
                    $query->where('activity','like','%'.$search.'%');
                })
                ->paginate($paginate);
    
                return view('admin_page.Activity.index',compact('daily_activity'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
                'activity' => 'required|string',
            ]);
    
            DailyActivity::create([
                'activity' => $request->activity,
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
        try{
            $request->validate([
                'activity' => 'required|string',
            ]);
    
            DailyActivity::where('id',$id)->update([
                'activity' => $request->activity,
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DailyActivity::where('id',$id)->delete();
    
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
