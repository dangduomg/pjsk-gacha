<?php

// pjsk card metadata
// not all operationally relevant to gacha

namespace Gacha\PJSK;

enum Attributes: string {
    case Cute = 'Cute';
    case Cool = 'Cool';
    case Pure = 'Pure';
    case Happy = 'Happy';
    case Mysterious = 'Mysterious';
}

enum Characters: string {
    case Miku = 'Miku';
    case Rin = 'Rin';
    case Len = 'Len';
    case Luka = 'Luka';
    case MEIKO = 'MEIKO';
    case KAITO = 'KAITO';

    case Ichika = 'Ichika';
    case Saki = 'Saki';
    case Honami = 'Honami';
    case Shiho = 'Shiho';

    case Minori = 'Minori';
    case Haruka = 'Haruka';
    case Airi = 'Airi';
    case Shizuku = 'Shizuku';

    case Kohane = 'Kohane';
    case An = 'An';
    case Akito = 'Akito';
    case Toya = 'Toya';

    case Tsukasa = 'Tsukasa';
    case Emu = 'Emu';
    case Nene = 'Nene';
    case Rui = 'Rui';

    case Kanade = 'Kanade';
    case Mafuyu = 'Mafuyu';
    case Ena = 'Ena';
    case Mizuki = 'Mizuki';
}

final class Card {
    // card metadata
    public function __construct(
        public readonly int $rarity,
        public readonly Attributes $attribute,
        public readonly Characters $character,
        public readonly string $name,
    ) {}
}