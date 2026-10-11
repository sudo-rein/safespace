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
        'ugly', 'fat', 'stupid', 'idiot', 'loser', 'dumb',
        'pangit', 'taba', 'mataba', 'tanga', 'bobo', 'ulol',
        'ayaw ka namin kasama', 'bobo mo naman', 'hindi mo gets',
        'simpleng bagay lang', 'ang corny naman', 'wala na bang iba',
        'weirdo mo', 'dun ka nga', 'ang OA mo naman',
        'hina mo naman maglaro', 'lampa amputa', 'ang slow mo naman',
        'kanina pa namin ine-explain', 'so annoying',
        'hindi ka ba napapagod magsalita', 'ang yabang mo naman',
        'kala mo kung sino', 'hindi naman nakakatawa mga jokes mo',
        'cringe mo naman', 'nakakahiya ka kasama', 'lutang ka ba',
        'ang arte mo naman', 'maliit na bagay lang',
        'nobody even asked you', 'bakit ka nakikisali',
        'feeling smart ka na naman', 'mali naman sagot mo',
        'ang ingay mo', 'wala ka bang mute button', 'geng geng yarn',
        'you are being so dramatic over nothing', 'edi wow ikaw na',
        'walang kwenta', 'wala kang kwenta', 'bobo talaga',
        'ang tanga mo', 'ang kapal ng mukha mo', 'epal ka',
        'papansin ka', 'ang hina mo', 'wala kang alam',
        'di ka bagay dito', 'hindi ka belong', 'pabigat ka',
        'wala kang silbi', 'ang pangit mo', 'ang baho mo',
        'tigil mo yan', 'manahimik ka', 'shut up',
        'nobody likes you', 'you are useless', 'you are so dumb',
        'what is wrong with you', 'you are pathetic',
    ]],

    ['Physical', 'medium', false, [
        'sinuntok', 'binugbog', 'sinipa', 'sinampal', 'binatukan',
        'sinakal', 'hinampas', 'pinalo', 'sinabunutan', 'tinulak',
        'punch', 'punched', 'punching', 'kick', 'kicked', 'kicking',
        'hit me', 'beat me up', 'slapped', 'choked',
        'siniko', 'kinurot', 'kinagat', 'kinaladkad',
        'tinadyakan', 'pinagsusuntok', 'pinagtulungan',
        'sinaktan physically', 'sinadyang itulak',
        'threw me', 'pushed me', 'physically hurt me',
        'physically attacked me', 'hit him', 'hit her',
        'binato ako', 'binato siya', 'sinaktan ako',
        'sinaktan siya', 'hinila ang buhok', 'pinagbuhatan ng kamay',
    ]],

    ['Threats', 'high', false, [
        'papatayin kita', 'patayin', 'babalikan kita', 'sasaktan kita',
        'kill you', 'i will kill', 'hurt you', 'wait for you after class',
        'may araw ka rin sakin', 'wag moko subukan',
        'baka di kita matansya', 'gawin mo yan kung ayaw mo ma bugbog',
        'alam ko bahay niyo', 'pag nakita kita', 'lagot ka talaga sakin',
        'humanda ka sa labas ng gate', 'you better watch your back',
        'di kita tatantanan', 'tandaan mo yan', 'subukan mo mag sumbong',
        'sige ulitin mo', 'sasaktan talaga kita', 'hindi pa tayo tapos',
        'magkikita pa tayo', 'pupuntahan talaga kita',
        'wag ka magpapakita sakin bukas', 'kung ayaw may mangyari sayo',
        'baka gripuhan kita', 'isipin mo mangyayari sayo',
        'kung di ka susunod', 'wag ka kampante',
        'di ka na humihinga bukas', 'pag nalaman kong ikaw may gawa nun',
        'ayusin mo', 'gusto mong di na sikatan ng araw',
        'may kalalagyan ka talaga',
        'alam na ng mga kasama ko yung ginawa mo',
        'hintayin mo na lang kung ano mangyayari',
        'gripuhan kita', 'bubugbugin kita', 'susugurin kita',
        'hintayin mo ako', 'may gagawin ako sayo',
        'you will regret this', 'i know where you live',
        'i will find you', 'i will hurt you',
        'i am going to hurt you', 'i will beat you up',
        'you are dead', 'watch your back',
        'i will get you after school', 'i will make you pay',
        'may ipapagawa ako sa mga kaibigan ko sayo',
    ]],

    ['Weapons', 'high', false, [
        'kutsilyo', 'baril', 'patalim', 'itak',
        'knife', 'gun', 'blade', 'weapon',
        'machete', 'saksak', 'sasaksakin', 'sinaksak',
        'may dalang kutsilyo', 'may dalang baril',
        'may dalang armas', 'tinakot gamit ang kutsilyo',
        'tinakot gamit ang baril', 'threatened me with a knife',
        'threatened me with a gun', 'stabbed me',
        'threatened me with a weapon',
    ]],

    ['Self-harm', 'high', true, [
        'magpapakamatay', 'ayoko na mabuhay',
        'gusto ko na mamatay', 'saktan ang sarili',
        'saktan sarili', 'magpakamatay', 'suicide',
        'kill myself', 'want to die', 'end my life',
        'hurt myself', 'ayoko na mabuhay',
        'pagod na akong mabuhay', 'mas mabuti pang mamatay',
        'gusto ko nang mawala', 'sana hindi na lang ako nabuhay',
        'sasaktan ko ang sarili ko', 'tatapusin ko na ito',
        'i want to end it all', 'i cannot go on living',
        'i do not want to live anymore',
        'i am going to kill myself',
    ]],

    ['Sexual', 'high', false, [
        'hinipuan', 'binastos', 'panghihipo', 'hinalikan ako',
        'naked', 'nude', 'touched me', 'sexual',
        'hinawakan sa maselang bahagi', 'hinawakan nang walang pahintulot',
        'pinilit akong humalik', 'pinilit akong humawak',
        'unwanted touching', 'sexual harassment',
        'sexual assault', 'inappropriate touching',
        'touched me without consent', 'forced me to kiss',
        'pinakita ang maselang bahagi', 'pinilit maghubad',
        'pinilit magpadala ng larawan', 'bastos na paghawak',
    ]],

    ['Cyber / Extortion', 'medium', false, [
        'ikakalat ko', 'leaked', 'blackmail', 'i will post',
        'ipost ko', 'ipapakalat ang picture', 'ikakalat ang picture',
        'hinack', 'wala talagang may gustong makipagkaibigan sayo',
        'lagi kang mag isa', 'wala naman siyang ambag sa group',
        'wala siyang papa/mama', 'nakakahiya', 'wag mo na kausapin yan',
        'nakaka-drain kasama', 'pagtatawanan ka pa rin namin',
        'puro problema', 'magpaka-plastic ka pa',
        'kaya wala kang friends dito', 'makeup kala ko clown',
        'lagi ka na lang naming topic sa gc', 'everyone is talking about you',
        'wag ka feeling close', 'di naman tayo friends',
        'wala kaming pak', 'magsumbong ka ulit', 'di ka namin inaaya',
        'ayaw namin sa yo', 'ikaw dahilan kung bakit pangit mood namin',
        'kahit anong gawin mong pagpapansin', 'wala pa ring may pake',
        'di ka namin titigilan', 'kakatawanan hangga\'t nandiyan ka',
        'hayaan niyo na yan',
        'cyberbullying', 'binubully online', 'binabash ako',
        'pinagtatawanan sa gc', 'ginawan ng fake account',
        'gumawa ng fake account', 'pinost ang picture ko',
        'ipapakalat ang sikreto mo', 'ipapahiya kita online',
        'threatened to leak my photos', 'spread my private photos',
        'shared my private messages', 'posted my photo without permission',
        'made a fake account using my name',
        'blackmail me', 'pay me or i will post',
        'send me money or else', 'extortion',
        'pinipilit akong magbigay ng pera',
        'hiningan ako ng pera kapalit ng pananahimik',
        'kinakalat ang tsismis online', 'ginawang katatawanan sa social media',
        'excluded me from the group chat',
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