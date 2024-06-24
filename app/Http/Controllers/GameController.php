<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    //
    private $snakes =[
        16=>6, 47=>26, 49=>11, 56=>53, 62=>19, 93=>73, 95=>75 , 98=>58
    ];

    private $ladders =[
        1=>38, 4=>14, 10=>31, 21=>42, 28=>62, 51=>67, 71=>91,80=>100
    ];

    public function createGame(Request $request)
    {
        $game = Game::create();
        foreach($request->players as $playerName)
        {
            Player::create(['name'=>$playerName, 'game_id'=>$game->id]);
        }
        if($game->completed){
            return response()->json(['Game over']);
        }
        return response()->json($game->load('players'));
    }

    public function rollDice($gameId,$playerId)
    {
        $game = Game::findorFail($gameId);
        if($game->completed){
            return response()->json(['Game over']);
        }

        $player = Player::where('game_id',$gameId)->findorFail($playerId);
        $roll = rand(1,6);

        $newposition = $player->position + $roll;

        if($newposition>50)
        {
            $newposition=$player->position;
        }
        else{
            $newposition = $this->snakes[$newposition]?? $newposition;
            $newposition = $this->ladders[$newposition]?? $newposition;
        }

        DB::transaction(function () use($game,$player,$newposition){
            $player->update(['position'=>$newposition]);
            if($newposition==50){
                $game->update(['completed'=>true , 'winner'=>$player->name]);
            }
        });

        return response()->json($player);
    }
}
