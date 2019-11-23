<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Army;

class GameController extends Controller
{
    public function list()
    {
        return Game::orderBy('created_at', 'DESC')->get();
    }

    public function create(Request $request)
    {
        Game::create();

        return Game::orderBy('created_at', 'DESC')->get();
    }

    public function get(Game $game)
    {
        return $game;
    }

    public function attack(Game $game)
    {
        $armies = $game->alive_armies()->orderBy('created_at', 'DESC')->get()->collect();
        $logs = [];
        $winner = null;

        if ($game->status == GAME::STATUS_READY && $game->armies->count() >= 5) {
            if ($game->alive_armies->count() > 1) {
                foreach($armies as $key => $item) {
                    $army = Army::find($item->id);
                    if ($army->is_defeated) continue;

                    $target = $army->getTarget();
                    $attack = $army->attack($target);

                    $log['attacker'] = $army->name;
                    $log['target'] = $target->name;
                    $log['strategy'] = $army->strategy;

                    if ($attack) {
                        $unit_result = $target->alive_units - $army->attack_damage;

                        if ($unit_result <= 0) {
                            $target->alive_units = 0;
                            $target->save();
                        } else {
                            $target->alive_units = $unit_result;
                            $target->save();
                        }

                        $log['attack'] = $attack;
                        $log['damage'] = $army->attack_damage;

                        // Reload the army after the attack
                        usleep($army->reload_time * 1000);
                    } else {
                        $log['attack'] = $attack;
                    }

                    $armies = $game->alive_armies()->orderBy('created_at', 'DESC')->get();
                    array_push($logs, $log);
                }

                $game->status = Game::STATUS_IN_PROGRESS;
                $game->save();
            }

            if ($game->alive_armies()->count() == 1) {
                $winner = $game->alive_armies()->first();
                $game->status = Game::STATUS_FINISHED;
                $game->save();
            }

            return [
                'game' => Game::find($game->id),
                'logs' => $logs
            ];
        } else {
            return [
                'error' => 'There has to be at least 5 armies to start the attack.'
            ];
        }
    }

    public function reset(Game $game)
    {
        $armies = $game->armies;

        foreach ($armies as $army) {
            $army->reset();
        }

        $game->status = Game::STATUS_READY;
        $game->save();

        return $game;
    }

    public function addArmy(Request $request, Game $game)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'starting_units' => 'required|integer|min:80|max:100',
            'strategy' => 'required|integer|between:0,2'
        ]);

        $army = $game->armies()->create($request->all());

        return $army;
    }
}
