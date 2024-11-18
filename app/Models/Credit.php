<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'allocated', 'need'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function calculateNeed()
    {
        return $this->member->max_credit - $this->allocated;
    }

    public static function isSafeState($available)
    {
        $credits = self::with('member')->get();
        $work = $available;
        $finish = array_fill(0, $credits->count(), false);

        while (true) {
            $found = false;

            foreach ($credits as $credit) {
                if (!$finish[$credit->id - 1] && $credit->calculateNeed() <= $work) {
                    $work += $credit->allocated;
                    $finish[$credit->id - 1] = true;
                    $found = true;
                }
            }

            if (!$found) {
                break;
            }
        }

        return !in_array(false, $finish);
    }
}

