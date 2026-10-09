<?php

namespace Database\Seeders;

use App\Models\Keyword;
use App\Models\KeywordCategory;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    public function run(): void
    {
        // [category name, severity group, is_urgent, words]
        $data = [
            ['Insults / Verbal', 'low', false, [
                'ugly', 'fat', 'stupid', 'idiot', 'loser', 'dumb', 'pangit',
                'taba', 'tanga', 'bobo', 'ulol', 'ayaw ka namin kasama',
            ]],
            ['Physical', 'medium', false, [
                'sinuntok', 'binugbog', 'sinipa', 'sinampal', 'binatukan',
                'sinakal', 'hinampas', 'pinalo', 'sinabunutan', 'tinulak',
                'punch', 'punched', 'kick', 'kicked', 'hit me', 'beat me up', 'slapped', 'choked',
            ]],
            ['Threats', 'high', false, [
                'papatayin kita', 'patayin', 'babalikan kita', 'sasaktan kita',
                'kill you', 'i will kill', 'hurt you', 'wait for you after class',
            ]],
            ['Weapons', 'high', false, [
                'kutsilyo', 'baril', 'patalim', 'itak', 'knife', 'gun', 'blade', 'weapon',
            ]],
            ['Self-harm', 'high', true, [
                'magpapakamatay', 'ayoko na mabuhay', 'gusto ko na mamatay',
                'saktan ang sarili', 'saktan sarili', 'magpakamatay',
                'suicide', 'kill myself', 'want to die', 'end my life', 'hurt myself',
            ]],
            ['Sexual', 'high', false, [
                'hinipuan', 'binastos', 'panghihipo', 'hinalikan ako',
                'naked', 'nude', 'touched me', 'sexual',
            ]],
            ['Cyber / Extortion', 'medium', false, [
                'ikakalat ko', 'leaked', 'blackmail', 'i will post', 'ipost ko',
                'ikakalat ang picture', 'hinack',
            ]],
        ];

        foreach ($data as [$name, $group, $urgent, $words]) {
            $category = KeywordCategory::updateOrCreate(
                ['name' => $name],
                ['severity_group' => $group, 'is_urgent' => $urgent]
            );

            foreach ($words as $word) {
                Keyword::firstOrCreate(
                    ['category_id' => $category->id, 'word' => $word],
                    ['language' => 'taglish', 'is_active' => true]
                );
            }
        }
    }
}