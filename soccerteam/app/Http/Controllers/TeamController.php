<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Team;
use Validator;
use Auth;
// use App\Http\Resources\Product as ProductResource;
class TeamController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::select('name','logouri','id')->get();
        return $this->sendResponse($teams, 'Teams retrieved successfully.');
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
        if(Auth::user()->role =='ADMIN'){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'logouri' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $team = Team::create($input);  
        return $this->sendResponse($team, 'Team created successfully.');

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
        $team = Team::find($id, ['name', 'logouri','id']);
        if (is_null($team)) {
            return $this->sendError('Team not found.');
        }

        return $this->sendResponse($team, 'Team retrieved successfully.');
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
    public function update(Request $request, Team $team)
    {
        if(Auth::user()->role =='ADMIN'){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'logouri' => 'required'
        ]);

   

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

        $team->name = $input['name'];
        $team->logouri = $input['logouri'];
        $team->save();

        return $this->sendResponse($team, 'Team updated successfully.');
        }
        else{
         return $this->sendError('Only admin users are allowed to create');
        }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if(Auth::user()->role =='ADMIN'){
        $team->delete();
        return $this->sendResponse('', 'Team deleted successfully.');
            }
        else{
             return $this->sendError('Only admin users are allowed to create');
        }
    }

     /**
     * Remove the specified resource from storage.
     */

    public function teamPlayersList(string $id)
    {
        // echo $id;die;
    $team_players = Team::select('players.firstname', 'players.lastname', 'players.playerimageuri')->join('players', 'teams.id', '=', 'players.team_id')->where('teams.id',$id)->get();


// DB::table('posts as p') ->join('cprefs as c','p.qatype', '=', 'c.qatype') ->where('c.wwide', '=', 'p.wwide') //second join condition ->where('c.user_id', $u_id) ->where('p.arank', 1) ->get();

        // $player->firstname = $team_players['firstname'];
        // $player->lastname = $team_players['lastname'];
        // $team->playerimageuri = $team_players['playerimageuri'];
         return $this->sendResponse($team_players, 'Team playres retrived successfully.');


    }
}
