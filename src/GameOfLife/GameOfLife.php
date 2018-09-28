<?php

declare(strict_types=1);

namespace GameOfLife;

final class GameOfLife
{
    public function run(string $input): void
    {
        while (1) {
            sleep(1);
            system('clear');
            print $input;
            print "Printing timestamp just so you know the script is running " . time();
            $input = $this->transform($input);
        }
    }

    public function transform(string $input): string
    {
        $newData = [];
        $data = array_map(function ($row) {
            return str_split($row);
        }, explode("\n", trim($input)));
        $height = count($data);
        $width = count($data[0]);
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $newData[$y][$x] = $this->getNextState(
                    $data[$y][$x],
                    $this->getNumberOfActiveCells($this->getNeighborhood($y, $x, $height, $width), $data)
                );
            }
        }
        return implode("\n", array_map(function ($row) {
                return implode('', $row);
            }, $newData)) . "\n";
    }

    public function getNeighborhood(int $x, int $y, int $width, int $height): array
    {
        return array_reduce([[0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0], [-1, -1]], function ($carry, $offset) use ($x, $y, $width, $height) {
            $nx = $x + $offset[0];
            $ny = $y + $offset[1];
            if ($nx > -1 && $nx < $width && $ny > -1 && $ny < $height) {
                return array_merge($carry, [[$nx, $ny]]);
            }
            return $carry;
        }, []);
    }

    public function getNumberOfActiveCells(array $corrds, array $data): int
    {
        return array_reduce($corrds, function ($carry, $corrd) use ($data) {
            return $carry + ($data[$corrd[0]][$corrd[1]] === 'x' ? 1 : 0);
        }, 0);

    }

    public function getNextState(string $currentState, int $numberOfAliveNeighbors): string
    {
        if ($currentState === '.') {
            return $numberOfAliveNeighbors === 3 ? 'x' : '.';
        }
        return in_array($numberOfAliveNeighbors, [2, 3]) ? 'x' : '.';
    }
}
