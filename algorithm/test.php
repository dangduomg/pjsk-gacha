<?php

// test data and function

// based on pjsk's first gacha
// see https://sekai.best/gacha/1

namespace Gacha\PJSK\Test;

require 'gacha.php';

use Gacha\PJSK\Attributes;
use Gacha\PJSK\Characters;
use Gacha\PJSK\Card;
use Gacha\PJSK\Gacha;

// featured cards
const f_miku = new Card(4, Attributes::Cute, Characters::Miku, 'みんなにお披露目');
const f_rin = new Card(4, Attributes::Pure, Characters::Rin, 'いがみ合いヒートアップ');
const f_len = new Card(4, Attributes::Cool, Characters::Len, '新団員登場！');
const f_ichi = new Card(4, Attributes::Cute, Characters::Ichika, '夜明け前の語らい');
const featured = [f_miku, f_rin, f_len, f_ichi];

// all cards
const cards = [
    new Card(2, Attributes::Happy, Characters::Ichika, 'Leo/need'),
    new Card(2, Attributes::Pure, Characters::Saki, 'Leo/need'),
    new Card(2, Attributes::Cool, Characters::Honami, 'Leo/need'),
    new Card(2, Attributes::Mysterious, Characters::Shiho, 'Leo/need'),
    new Card(2, Attributes::Cool, Characters::Minori, 'MORE MORE JUMP！'),
    new Card(2, Attributes::Pure, Characters::Haruka, 'MORE MORE JUMP！'),
    new Card(2, Attributes::Cute, Characters::Airi, 'MORE MORE JUMP！'),
    new Card(2, Attributes::Mysterious, Characters::Shizuku, 'MORE MORE JUMP！'),
    new Card(2, Attributes::Mysterious, Characters::Kohane, 'Vivid BAD SQUAD'),
    new Card(2, Attributes::Cool, Characters::An, 'Vivid BAD SQUAD'),
    new Card(2, Attributes::Cute, Characters::Akito, 'Vivid BAD SQUAD'),
    new Card(2, Attributes::Happy, Characters::Toya, 'Vivid BAD SQUAD'),
    new Card(2, Attributes::Cute, Characters::Tsukasa, 'ワンダーランズ×ショウタイム'),
    new Card(2, Attributes::Mysterious, Characters::Emu, 'ワンダーランズ×ショウタイム'),
    new Card(2, Attributes::Cool, Characters::Nene, 'ワンダーランズ×ショウタイム'),
    new Card(2, Attributes::Pure, Characters::Rui, 'ワンダーランズ×ショウタイム'),
    new Card(2, Attributes::Cute, Characters::Kanade, '25時、ナイトコードで。'),
    new Card(2, Attributes::Happy, Characters::Mafuyu, '25時、ナイトコードで。'),
    new Card(2, Attributes::Mysterious, Characters::Ena, '25時、ナイトコードで。'),
    new Card(2, Attributes::Cool, Characters::Mizuki, '25時、ナイトコードで。'),
    new Card(2, Attributes::Cute, Characters::Miku, '教室のセカイ'),
    new Card(2, Attributes::Cool, Characters::Miku, 'ステージのセカイ'),
    new Card(2, Attributes::Pure, Characters::Miku, 'ストリートのセカイ'),
    new Card(2, Attributes::Happy, Characters::Miku, 'ワンダーランドのセカイ'),
    new Card(2, Attributes::Mysterious, Characters::Miku, '誰もいないセカイ'),
    new Card(2, Attributes::Happy, Characters::Rin, 'ステージのセカイ'),
    new Card(2, Attributes::Mysterious, Characters::Len, 'ストリートのセカイ'),
    new Card(2, Attributes::Happy, Characters::Luka, '教室のセカイ'),
    new Card(2, Attributes::Pure, Characters::MEIKO, 'ストリートのセカイ'),
    new Card(2, Attributes::Cute, Characters::KAITO, 'ワンダーランドのセカイ'),
    new Card(3, Attributes::Mysterious, Characters::Ichika, '見上げる先に'),
    new Card(3, Attributes::Cool, Characters::Saki, 'やりたい100のこと'),
    new Card(3, Attributes::Happy, Characters::Honami, '味は変わらないのに'),
    new Card(3, Attributes::Cute, Characters::Shiho, '胸に残る旋律'),
    new Card(3, Attributes::Cute, Characters::Minori, 'ライブ前夜の決意'),
    new Card(3, Attributes::Cool, Characters::Haruka, 'アイドルじゃない私'),
    new Card(3, Attributes::Pure, Characters::Airi, '夢を応援！'),
    new Card(3, Attributes::Happy, Characters::Shizuku, '華やかな現場で'),
    new Card(3, Attributes::Cool, Characters::Kohane, 'セカイで一息'),
    new Card(3, Attributes::Pure, Characters::An, '絶賛、手伝い中！'),
    new Card(3, Attributes::Happy, Characters::Akito, '滲む苛立ち'),
    new Card(3, Attributes::Cute, Characters::Toya, '絶たれた絆'),
    new Card(3, Attributes::Mysterious, Characters::Tsukasa, '着ぐるみからこんにちは'),
    new Card(3, Attributes::Cute, Characters::Emu, 'レッツ作戦会議！'),
    new Card(3, Attributes::Pure, Characters::Nene, '舞台裏から操作中'),
    new Card(3, Attributes::Happy, Characters::Rui, '神出鬼没なパフォーマー'),
    new Card(3, Attributes::Happy, Characters::Kanade, '画面の向こうに…'),
    new Card(3, Attributes::Cute, Characters::Mafuyu, '『いい子』の私'),
    new Card(3, Attributes::Cool, Characters::Ena, '最高のアングル'),
    new Card(3, Attributes::Mysterious, Characters::Mizuki, '譲れないこだわり'),
    new Card(3, Attributes::Pure, Characters::Miku, '見守るまなざし'),
    new Card(3, Attributes::Mysterious, Characters::Rin, '輝くステージ'),
    new Card(3, Attributes::Happy, Characters::Len, '難しい『仲直り』'),
    new Card(3, Attributes::Pure, Characters::Luka, '導く手'),
    new Card(3, Attributes::Mysterious, Characters::MEIKO, 'こだわりの一杯'),
    new Card(3, Attributes::Cool, Characters::KAITO, '劇団員募集中！'),
    ...featured
];

const gacha = new Gacha(cards, featured);