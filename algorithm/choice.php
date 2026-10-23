<?php

// weighted random choice generator

namespace Gacha\Random;

use AssertionError;
use \Random\Randomizer;

const default_randomizer = new Randomizer();

final class WeightedItemCollection {
    public readonly array $items;
    private readonly array $cum_weights;

    public function __construct(
        array $items_weights,
        private readonly Randomizer $randomizer = default_randomizer,
    ) {
        // construct the weighted item collection from
        if (empty($items_weights))
            throw new \InvalidArgumentException(
                'there must be at least an item'
            );
        // calculate the cumulative weights
        $items = [];
        $cum_weights = [];
        foreach ($items_weights as [$item, $weight]) {
            if ($weight <= 0)
                throw new \InvalidArgumentException(
                    'all weights must be positive'
                );
            $items[] = $item;
            $cum_weights[] = \count($cum_weights) === 0
                ? $weight
                : $cum_weights[\count($cum_weights) - 1] + $weight;
        }
        $this->items = $items;
        $this->cum_weights = $cum_weights;
    }

    public function choice(bool $integer = false) {
        // generate random number
        $total_weight = array_last($this->cum_weights);
        $random_num = $integer
            ? $this->randomizer->getInt(0, $total_weight - 1)
            : $this->randomizer->getFloat(0, $total_weight);
        // find the first cumulative weight greater than $random_num
        $lo = 0;
        $hi = \count($this->cum_weights);
        while ($lo < $hi) {
            $mid = $lo + intdiv($hi - $lo, 2);
            if ($this->cum_weights[$mid] <= $random_num)
                $lo = $mid + 1;
            else
                $hi = $mid;
        }
        assert(
            $lo !== \count($this->cum_weights),
            new AssertionError("the binary search didn't find an index;
please check for bugs"),
        );
        // get the item based on that
        return $this->items[$lo];
    }
}