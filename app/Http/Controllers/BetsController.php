<?php

namespace App\Http\Controllers;

use App\Models\BetsModel;
use Illuminate\Http\Request;
use Auth;

class BetsController extends Controller
{
    //
    public function add_new(Request $request)
    {
        // Validate the request data
        $request->validate([
            'date'=>'required|max:10',
            'league'=>'required|max:20',
            'bet'=>'required|max:20',
            'type'=>'required',
            'outcome'=>'required|in:win,loss,Loss,Win',
            'risk'=>'required|integer',
            'reward'=>'required|integer'
        ]);

        if (strtolower($request->input('outcome')) == "loss"){
            $profit = -$request->input('risk');
        } else {
            $profit = $request->input('reward') - $request->input('risk');
        }
        // Create a new Bet instance
        $bet = new BetsModel();
        $bet->user_id = Auth::user()->id;
        $bet->date = $request->input('date');
        $bet->league = $request->input('league');
        $bet->bet = $request->input('bet');
        $bet->type = $request->input('type');
        $bet->outcome = $request->input('outcome');
        $bet->risk = $request->input('risk');
        $bet->reward = $request->input('reward');
        $bet->profit = $profit;

        // Save the new Bet
        $bet->save();

        return response()->json(['message' => 'Bet added successfully', 'profit'=>$profit, 'bet_id'=>$bet->id]);
    }

    public function edit(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'date' => 'required',
            'league' => 'required',
            // Add other validation rules here
        ]);

        // Find the Bet by ID
        $bet = BetsModel::findOrFail($id);
        $bet->date = $request->input('date');
        $bet->league = $request->input('league');
        // Update other properties...

        // Save the updated Bet
        $bet->save();

        return response()->json(['message' => 'Bet updated successfully']);
    }

    public function delete($id)
    {
        // Find the Bet by ID and delete it
        $bet = BetsModel::findOrFail($id);
        $bet->delete();

        return response()->json(['message' => 'Bet deleted successfully']);
    }
}
