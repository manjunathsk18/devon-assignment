<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Player;
use Validator;
use Auth;

class PlayerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $player = Player::select('firstname','lastname','playerimageuri')->get();
        // echo $player->firstname;die;
        return $this->sendResponse($player, 'Player details retrieved successfully.');
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
    public function store(Request $request)
    {
        if(Auth::user()->role =='ADMIN'){
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstname' => 'required',
            'lastname' => 'required',
            'playerimageuri' =>'required',
            'team_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $player = Player::create($input);  
        return $this->sendResponse($player, 'Player details created successfully.');

        }
        else{
             return $this->sendError('Only admin users are allowed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = Player::find($id, ['firstname', 'lastname','playerimageuri']);
        if (is_null($player)) {
            return $this->sendError('Team not found.');
        }

        return $this->sendResponse($player, 'Player details retrieved successfully.');
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
    public function update(Request $request, Player $player)
    {
        
        if(Auth::user()->role =='ADMIN'){
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstname' => 'required',
            'lastname' => 'required',
            'playerimageuri' =>'required',
            'team_id'  => 'required'
        ]);

   

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $player->firstname = $input['firstname'];
        $player->lastname = $input['lastname'];
        $player->playerimageuri = $input['playerimageuri'];
        $player->team_id = $input['team_id'];
        $player_check = $player->save();

        return $this->sendResponse($player, 'Player details updated successfully.');
        }
        else {
            return $this->sendError('Only admin users are allowed to create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        if(Auth::user()->role =='ADMIN'){
            $player->delete();
            return $this->sendResponse('', 'Player details deleted successfully.');
        }
        else{
             return $this->sendError('Only admin users are allowed to create');
        }
    }
}
