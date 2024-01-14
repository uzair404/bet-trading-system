<?php

namespace App\Http\Controllers;

use App\Models\BetsModel;
use App\Models\User;
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
            'risk'=>'required|numeric',
            'reward'=>'required|numeric'
        ]);

        if (strtolower($request->input('outcome')) == "loss"){
            $profit = -$request->input('risk');
        } else {
            $profit = $request->input('reward') - $request->input('risk');
        }

        $last_bet = BetsModel::where('user_id', Auth::user()->id)->latest()->first();
        if (!$last_bet) {
            $last_balance = User::where('id', Auth::user()->id)->first()->starting_balance;
        }else{
            $last_balance = $last_bet->rolling_balance;
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
        $bet->rolling_balance = $profit+$last_balance;

        // Save the new Bet
        $bet->save();

        return response()->json(['message' => 'Bet added successfully', 'profit'=>$profit, 'bet_id'=>$bet->id, 'rolling_balance'=>$bet->rolling_balance, 'date'=>$bet->date]);
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

        return response()->json(['message' => 'Bet deleted successfully', 'rolling_balance'=>$bet->rolling_balance, 'date'=>$bet->date]);
    }

    public function updateStartingBalance(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'starting_balance' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $user->starting_balance = $validatedData['starting_balance'];
        $user->save();

        $BetsModel = BetsModel::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->get();
        if (count($BetsModel)<1) {
            // Redirect back or to a success page
            return redirect()->back()->with('success', 'Starting balance updated successfully');
        }
        $last = $user->starting_balance;
        foreach ($BetsModel as $key => $bet) {
            $bet->rolling_balance = $bet->profit+$last;
            $bet->update();
            $last = $bet->rolling_balance;
        }
        return redirect()->back()->with('success', 'Starting balance updated successfully');
    }
}
