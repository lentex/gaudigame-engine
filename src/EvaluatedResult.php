<?php

namespace Lentex\Gaudigame\Engine;

class EvaluatedResult
{
    private float $points = 0.0;
    private bool $boost = false;
    private bool $exact = false;
    private bool $gap = false;
    private bool $tendency = false;
    private bool $wrong = false;
    private bool $no = true;

    public function getPoints(): float
    {
        return $this->points;
    }

    public function setPoints(float $points): void
    {
        $this->points = $points;
    }

    public function hasBoost(): bool
    {
        return $this->boost;
    }

    public function setBoost(): void
    {
        $this->boost = true;
    }

    public function isExact(): bool
    {
        return $this->exact;
    }

    public function setToExact(): void
    {
        $this->exact = true;
        $this->gap = false;
        $this->tendency = false;
        $this->wrong = false;
        $this->no = false;
    }

    public function isGap(): bool
    {
        return $this->gap;
    }

    public function setToGap(): void
    {
        $this->gap = true;
        $this->exact = false;
        $this->tendency = false;
        $this->wrong = false;
        $this->no = false;
    }

    public function isTendency(): bool
    {
        return $this->tendency;
    }

    public function setToTendency(): void
    {
        $this->tendency = true;
        $this->exact = false;
        $this->gap = false;
        $this->wrong = false;
        $this->no = false;
    }

    public function isWrong(): bool
    {
        return $this->wrong;
    }

    public function setToWrong(): void
    {
        $this->wrong = true;
        $this->exact = false;
        $this->gap = false;
        $this->tendency = false;
        $this->no = false;
    }

    public function isNo(): bool
    {
        return $this->no;
    }

    public function setToNo(): void
    {
        $this->no = true;
        $this->exact = false;
        $this->gap = false;
        $this->tendency = false;
        $this->wrong = false;
    }
}
