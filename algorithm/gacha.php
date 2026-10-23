<?php

// project sekai's gacha system (most basic model)
// all information comes from publicly available sources

namespace Gacha\PJSK;

require 'choice.php';
require 'card.php';

use Gacha\Random\WeightedItemCollection;
use Random\Randomizer;

const default_randomizer = \Gacha\Random\default_randomizer;

class Gacha {
    // the gacha system
    // most basic event model

    // birthday cards aren't counted yet
    public const rarities = [2, 3, 4];
    // 2 star cards have 88.5% probability
    // 3 stars have 8.5%
    // and 4 stars have 3%
    public const rarity_to_weight = [
        2 => 177,
        3 => 17,
        4 => 6,
    ];
    public const guaranteed_rarity_to_weight = [
        3 => 194,
        4 => 6,
    ];
    public const feat_multiplier = 3;

    // the weighted item collection
    protected WeightedItemCollection $wic;
    protected WeightedItemCollection $guaranteed_wic;

    public function __construct(
        array $cards,
        array $featured = [],
        protected Randomizer $randomizer = default_randomizer,
    ) {
        // first we group cards by rarity
        $cards_by_rarity = [];
        foreach ($this::rarities as $rarity) {
            // account for featured cards
            $cards_same_rarity = [];
            foreach ($cards as $card)
                if ($card->rarity === $rarity)
                    $cards_same_rarity[] = [
                        $card,
                        \in_array($card, $featured)
                            ? $this::feat_multiplier : 1,
                    ];
            $cards_by_rarity[$rarity] = new WeightedItemCollection(
                $cards_same_rarity, $this->randomizer
            );
        }
        // then we create the WIC object
        $this->wic = $this->create_wic(
            $cards_by_rarity, $this::rarity_to_weight
        );
        // remove the 2 stars to create the guaranteed WIC object
        unset($cards_by_rarity[2]);
        $this->guaranteed_wic = $this->create_wic(
            $cards_by_rarity, $this::guaranteed_rarity_to_weight
        );
    }

    protected function create_wic(
        array $card_bins, array $bin_to_weight
    ): WeightedItemCollection {
        // we turn it into an items-weights array
        $card_bins_weights = [];
        foreach ($card_bins as $bin => $cards)
            $card_bins_weights[] = [$cards, $bin_to_weight[$bin]];
        // then we create the WIC object
        return new WeightedItemCollection(
            $card_bins_weights, $this->randomizer
        );
    }

    protected function _pull1(WeightedItemCollection $wic): Card {
        // get the cards from a weighted bin
        $bin_wic = $wic->choice(integer: true);
        // draw from that bin too
        return $bin_wic->choice(integer: true);
    }

    public function pull1(): Card {
        return $this->_pull1($this->wic);
    }

    public function pull10(): array {
        // 9 other pulls: choose cards from the normal collection
        // for why the iteration runs 10 times, see below
        $cards = [];
        for ($i = 0; $i < 10; $i++) {
            $cards[] = $this->pull1();
        }
        // distinguished pull: choose from the guaranteed collection
        // but this pull can land anywhere
        $j = $this->randomizer->getInt(0, array_key_last($cards));
        $cards[$j] = $this->_pull1($this->guaranteed_wic);
        return $cards;
    }
}