<?php

declare(strict_types=1);

namespace GameOfLife;

use PHPUnit\Framework\TestCase;

final class GameOfLifeTest extends TestCase
{
    /**
     * @var GameOfLife
     */
    private $gameOfLife;

    public function setUp(): void
    {
        $this->gameOfLife = new GameOfLife();
    }

    public function testGetNeighborhood(): void
    {
        $this->assertEquals([[1, 0], [1, 1], [0, 1]], $this->gameOfLife->getNeighborhood(0, 0, 3, 3));
        $this->assertEquals([[2, 0], [2, 1], [1, 1], [0, 1], [0, 0]], $this->gameOfLife->getNeighborhood(1, 0, 3, 3));
        $this->assertEquals([[1, 0], [2, 0], [2, 1], [2, 2], [1, 2], [0, 2], [0, 1], [0, 0]], $this->gameOfLife->getNeighborhood(1, 1, 3, 3));
    }

    public function testGetNumberOfAliveCell(): void
    {
        $data = [
            ['.', 'x', '.'],
            ['x', '.', '.'],
            ['.', '.', 'x']
        ];
        $tests = [
            [[[0, 0], [1, 0], [0, 1]], 2],
            [[[0, 0], [1, 0], [2, 0], [2, 1], [2, 2], [1, 2], [0, 2], [0, 1]], 3],
            [[[0, 0], [2, 0], [1, 1], [2, 1], [0, 2], [1, 2]], 0]
        ];

        foreach ($tests as $test) {
            $this->assertEquals($test[1], $this->gameOfLife->getNumberOfActiveCells($test[0], $data));
        }
    }

    public function testNextState(): void
    {
        $this->assertEquals('x', $this->gameOfLife->getNextState('.', 3));
        $this->assertEquals('.', $this->gameOfLife->getNextState('.', 4));
        $this->assertEquals('x', $this->gameOfLife->getNextState('x', 2));
        $this->assertEquals('x', $this->gameOfLife->getNextState('x', 3));
        $this->assertEquals('.', $this->gameOfLife->getNextState('x', 4));
    }
}
