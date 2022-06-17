<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminFucksController extends Controller
{
    public function index()
    {
        $fucks = DB::table('fucks')->paginate(10);

        return view('admin.fucks',['fucks' => $fucks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        $fuck = DB::table('fucks')->insert([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        if($fuck)
        {
            \Session::flash('status', 'კითხვა წარამტებით დაემატა!' );
        }
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        try {

            \Illuminate\Support\Facades\DB::table('fucks')->where('id', $request->fuck_id)->delete();

        }catch(\Exception $e){

            \Session::flash('status', 'კითხვის წაშლა არ მოხდა.');

        }

        \Session::flash('status', 'კითხვა წარმატებით წაიშალა.');

        return redirect()->back();
    }
}
