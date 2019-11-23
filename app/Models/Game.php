<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasUUID;

    public const STATUS_READY = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_FINISHED = 2;

    protected $guarded = ['id'];
    protected $with = ['armies'];
    protected $appends = ['army_count'];

    public function armies()
    {
        return $this->hasMany(Army::class)->orderBy('created_at', 'DESC');
    }

    public function alive_armies()
    {
        return $this->hasMany(Army::class)->where('alive_units', '>', 0);
    }

    public function getRandomArmy(Army $attacker)
    {
        return $this->alive_armies()->whereNotIn('id', [$attacker->id])->inRandomOrder()->first();
    }

    public function getWeakestArmy(Army $attacker)
    {
        return $this->alive_armies()->whereNotIn('id', [$attacker->id])->orderBy('starting_units', 'ASC')->first();
    }

    public function getStrongestArmy(Army $attacker)
    {
        return $this->alive_armies()->whereNotIn('id', [$attacker->id])->orderBy('starting_units', 'DESC')->first();
    }

    public function getArmyCountAttribute()
    {
        return [
            'total' => $this->armies->count(),
            'alive' => $this->alive_armies->count()
        ];
    }
}
