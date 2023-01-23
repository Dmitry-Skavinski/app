<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @mixin Builder
 */
class Nonogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'height',
        'width',
        'task',
        'result',
    ];

    protected $casts = [
        'task' => 'array',
        'result' => 'array',
    ];

    public static function isValid($result): bool
    {
        $filledCells = 0;
        $area = count($result) * count($result[0]);
        foreach ($result as $row) {
            if (in_array(1, $row)) {
                $filledCells += array_count_values($row)[1];
            }
        }

        return $filledCells > $area / 8;
    }

    /**
     * @param $result
     * @param $height
     * @param $width
     * @return array
     */
    public static function createTask($result, $height, $width): array
    {

        $task = ['top' => array_fill(0, $width, []), 'left' => array_fill(0, $height, [])];
        $count = 0;

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if ($result[$y][$x] === 1) {
                    $count++;
                } else {
                    $count && $task['left'][$y][] = $count;
                    $count = 0;
                }
            }
            $count && $task['left'][$y][] = $count;
            $count = 0;
        }

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                if ($result[$y][$x] === 1) {
                    $count++;
                } else {
                    $count && $task['top'][$x][] = $count;
                    $count = 0;
                }
            }
            $count && $task['top'][$x][] = $count;
            $count = 0;
        }

        return $task;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
