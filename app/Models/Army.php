<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Army extends Model
{
    use HasUUID;

    public const STRATEGY_RANDOM = 0; // Attack a random army in the game
    public const STRATEGY_WEAKEST = 1; // Attack the weakest army in the game
    public const STRATEGY_STRONGEST = 2; // Attack the strongest army in the game

    protected const ATTACK_DAMAGE = 0.5; // Points per unit. Every whole point removes 1 unit from the army
    protected const ATTACK_CHANCE = 1; // Percentage per every alive unit in the army
    protected const RELOAD_TIME = 0.01; // In seconds per 1 unit in the army

    protected $guarded = ['id'];
    protected $appends = ['attack_chance', 'reload_time', 'attack_damage', 'is_defeated'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->alive_units = $model->starting_units;
        });
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getAttackChanceAttribute()
    {
        return static::ATTACK_CHANCE * $this->alive_units;
    }

    public function getReloadTimeAttribute()
    {
        return static::RELOAD_TIME * $this->alive_units;
    }

    public function getAttackDamageAttribute()
    {
        return floor(static::ATTACK_DAMAGE * $this->alive_units);
    }

    public function getIsDefeatedAttribute()
    {
        return $this->alive_units < 1;
    }

    public function getTarget()
    {
        switch ($this->strategy)
        {
            default:
            case static::STRATEGY_RANDOM:
                $target = $this->game->getRandomArmy($this);
                break;

            case static::STRATEGY_WEAKEST:
                $target = $this->game->getWeakestArmy($this);
                break;

            case static::STRATEGY_STRONGEST:
                $target = $this->game->getStrongestArmy($this);
                break;
        }

        return $target;
    }

    public function attack(Army $target)
    {
        if (mt_rand(0, 99) < $this->attack_chance) {
            return true;
        } else {
            return false;
        }
    }

    public function reset()
    {
        $this->alive_units = $this->starting_units;
        $this->save();
    }
}
