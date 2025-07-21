<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Genre;
use App\Models\Gender;
use App\Models\Series;
use App\Models\Studio;
use App\Models\Country;
use Faker\Factory as Faker;
use App\Models\SeriesStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $country = Country::factory()->count(10)->create();
        $gender = Gender::factory()->count(3)->create();
        $role = Role::factory()->count(3)->create();

        $userCollection = collect();

        $baseEmail = 'angelo.van.osch';
        $firstNames = ['Angelo', 'Angela', 'Angelina', 'Angel', 'Angie'];
        $lastNames = ['van Osch', 'van Oscha', 'van Oschy', 'van Oshen', 'van Oschsen'];

        $userCollection = collect();

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'email' => $i === 0
                    ? "{$baseEmail}@hotmail.com"
                    : "{$baseEmail}{$i}@hotmail.com",
                'password' => Hash::make('wachtwoord123'),
                'role_id' => $role->random()->id,
                'first_name' => $firstNames[$i % count($firstNames)],
                'last_name' => $lastNames[$i % count($lastNames)],
                'date_of_birth' => '1996-09-04',
                'country_id' => $country->random()->id,
                'gender_id' => $gender->random()->id,
                'description' => 'This is a description!',
                'profile_photo' => null,
                'profile_banner' => null,
            ]);

            $userCollection->push($user);
        }

        $images = [
            [
                'title' => 'Frieren',
                'image' => 'storage/series/1.jpg',
                'video' => 'ZEkwCGJ3o7M',
                'synopsis' => <<<TEXT
During their decade-long quest to defeat the Demon King, the members of the hero's party—Himmel himself, the priest Heiter, the dwarf warrior Eisen, and the elven mage Frieren—forge bonds through adventures and battles, creating unforgettable precious memories for most of them.

However, the time that Frieren spends with her comrades is equivalent to merely a fraction of her life, which has lasted over a thousand years. When the party disbands after their victory, Frieren casually returns to her "usual" routine of collecting spells across the continent. Due to her different sense of time, she seemingly holds no strong feelings toward the experiences she went through.

As the years pass, Frieren gradually realizes how her days in the hero's party truly impacted her. Witnessing the deaths of two of her former companions, Frieren begins to regret having taken their presence for granted; she vows to better understand humans and create real personal connections.

Although the story of that once memorable journey has long ended, a new tale is about to begin.
TEXT
            ],

            [
                'title' => 'Fullmetal Alchemist',
                'image' => 'storage/series/2.jpg',
                'video' => '1ac3_YdSSy0',
                'synopsis' => <<<TEXT
After a horrific alchemy experiment goes wrong in the Elric household, brothers Edward and Alphonse are left in a catastrophic new reality. Ignoring the alchemical principle banning human transmutation, the boys attempted to bring their recently deceased mother back to life. Instead, they suffered brutal personal loss: Alphonse's body disintegrated while Edward lost a leg and then sacrificed an arm to keep Alphonse's soul in the physical realm by binding it to a hulking suit of armor.

The brothers are rescued by their neighbor Pinako Rockbell and her granddaughter Winry. Known as a bio-mechanical engineering prodigy, Winry creates prosthetic limbs for Edward by utilizing "automail," a tough, versatile metal used in robots and combat armor. After years of training, the Elric brothers set off on a quest to restore their bodies by locating the Philosopher's Stone—a powerful gem that allows an alchemist to defy the traditional laws of Equivalent Exchange.

As Edward becomes an infamous alchemist and gains the nickname "Fullmetal," the boys' journey embroils them in a growing conspiracy that threatens the fate of the world.
TEXT
            ],
            [
                'title' => 'SteinsGate',
                'image' => 'storage/series/3.jpg',
                'video' => '27OZc-ku6is',
                'synopsis' => <<<TEXT
Eccentric scientist Rintarou Okabe has a never-ending thirst for scientific exploration. Together with his ditzy but well-meaning friend Mayuri Shiina and his roommate Itaru Hashida, Okabe founds the Future Gadget Laboratory in the hopes of creating technological innovations that baffle the human psyche. Despite claims of grandeur, the only notable "gadget" the trio have created is a microwave that has the mystifying power to turn bananas into green goo.

However, when Okabe attends a conference on time travel, he experiences a series of strange events that lead him to believe that there is more to the "Phone Microwave" gadget than meets the eye. Apparently able to send text messages into the past using the microwave, Okabe dabbles further with the "time machine," attracting the ire and attention of the mysterious organization SERN.

Due to the novel discovery, Okabe and his friends find themselves in an ever-present danger. As he works to mitigate the damage his invention has caused to the timeline, Okabe fights a battle to not only save his loved ones but also to preserve his degrading sanity.
TEXT
            ],
            [
                'title' => 'Attack on Titan',
                'image' => 'storage/series/4.jpg',
                'video' => 'LHtdKWJdif4',
                'synopsis' => <<<TEXT
Centuries ago, mankind was slaughtered to near extinction by monstrous humanoid creatures called Titans, forcing humans to hide in fear behind enormous concentric walls. What makes these giants truly terrifying is that their taste for human flesh is not born out of hunger but what appears to be out of pleasure. To ensure their survival, the remnants of humanity began living within defensive barriers, resulting in one hundred years without a single titan encounter. However, that fragile calm is soon shattered when a colossal Titan manages to breach the supposedly impregnable outer wall, reigniting the fight for survival against the man-eating abominations.

After witnessing a horrific personal loss at the hands of the invading creatures, Eren Yeager dedicates his life to their eradication by enlisting into the Survey Corps, an elite military unit that combats the merciless humanoids outside the protection of the walls. Eren, his adopted sister Mikasa Ackerman, and his childhood friend Armin Arlert join the brutal war against the Titans and race to discover a way of defeating them before the last walls are breached.
TEXT
            ],
            [
                'title' => 'Gintama',
                'image' => 'storage/series/5.jpg',
                'video' => 'vcb-D3FlaCg',
                'synopsis' => <<<TEXT
Gintoki, Shinpachi, and Kagura return as the fun-loving but broke members of the Yorozuya team! Living in an alternate-reality Edo, where swords are prohibited and alien overlords have conquered Japan, they try to thrive on doing whatever work they can get their hands on. However, Shinpachi and Kagura still haven't been paid... Does Gin-chan really spend all that cash playing pachinko?

Meanwhile, when Gintoki drunkenly staggers home one night, an alien spaceship crashes nearby. A fatally injured crew member emerges from the ship and gives Gintoki a strange, clock-shaped device, warning him that it is incredibly powerful and must be safeguarded. Mistaking it for his alarm clock, Gintoki proceeds to smash the device the next morning and suddenly discovers that the world outside his apartment has come to a standstill. With Kagura and Shinpachi at his side, he sets off to get the device fixed; though, as usual, nothing is ever that simple for the Yorozuya team.

Filled with tongue-in-cheek humor and moments of heartfelt emotion, Gintama's fourth season finds Gintoki and his friends facing both their most hilarious misadventures and most dangerous crises yet.
TEXT
            ],
            [
                'title' => 'Gintama 2',
                'image' => 'storage/series/6.jpg',
                'video' => 'vcb-D3FlaCg',
                'synopsis' => <<<TEXT
After a one-year hiatus, Shinpachi Shimura returns to Edo, only to stumble upon a shocking surprise: Gintoki and Kagura, his fellow Yorozuya members, have become completely different characters! Fleeing from the Yorozuya headquarters in confusion, Shinpachi finds that all the denizens of Edo have undergone impossibly extreme changes, in both appearance and personality. Most unbelievably, his sister Otae has married the Shinsengumi chief and shameless stalker Isao Kondou and is pregnant with their first child.

Bewildered, Shinpachi agrees to join the Shinsengumi at Otae and Kondou's request and finds even more startling transformations afoot both in and out of the ranks of the organization. However, discovering that Vice Chief Toushirou Hijikata has remained unchanged, Shinpachi and his unlikely Shinsengumi ally set out to return the city of Edo to how they remember it.

With even more dirty jokes, tongue-in-cheek parodies, and shameless references, Gintama follows the Yorozuya team through more of their misadventures in the vibrant, alien-filled world of Edo.
TEXT
            ],

            [
                'title' => 'One Piece',
                'image' => 'storage/series/7.jpg',
                'video' => 'MewJ5bEM-5U',
                'synopsis' => <<<TEXT
Although the golden age of piracy is about to reach new heights, most people do not seek the glory of finding the elusive One Piece—a treasure signifying a new conqueror of all seas that was once embodied by the legendary King of the Pirates, Gol D. Roger. However, even if civilians generally despise pirates, they secretly cheer for at least one of them.

One red-headed girl from Sabaody Archipelago is no exception: She reveres Nami, the ingenious female navigator of Monkey D. Luffy's Straw Hat crew. Determined to deliver a fan letter to her idol, the Sabaody child is prepared to challenge forces of authority who strive to prevent Luffy and his friends from departing for their next destination: the New World. But to succeed, Nami's fan may need to risk her life and interfere with the Marines' plans, potentially causing devastating consequences for the wider world.
TEXT
            ],
            [
                'title' => 'Hunter x Hunter',
                'image' => 'storage/series/8.jpg',
                'video' => 'D9iTQRB4XRk',
                'synopsis' => <<<TEXT
Hunters devote themselves to accomplishing hazardous tasks, all from traversing the world's uncharted territories to locating rare items and monsters. Before becoming a Hunter, one must pass the Hunter Examination—a high-risk selection process in which most applicants end up handicapped or worse, deceased.

Ambitious participants who challenge the notorious exam carry their own reason. What drives 12-year-old Gon Freecss is finding Ging, his father and a Hunter himself. Believing that he will meet his father by becoming a Hunter, Gon takes the first step to walk the same path.

During the Hunter Examination, Gon befriends the medical student Leorio Paladiknight, the vindictive Kurapika, and ex-assassin Killua Zoldyck. While their motives vastly differ from each other, they band together for a common goal and begin to venture into a perilous world.
TEXT
            ],

            [
                'title' => 'Gintama 3',
                'image' => 'storage/series/9.jpg',
                'video' => 'vcb-D3FlaCg',
                'synopsis' => <<<TEXT
After joining the resistance against the bakufu, Gintoki and the gang are in hiding, along with Katsura and his Joui rebels. The Yorozuya is soon approached by Nobume Imai and two members of the Kiheitai, who explain that the Harusame pirates have turned against 7th Division Captain Kamui and their former ally Takasugi. The Kiheitai present Gintoki with a job: find Takasugi, who has been missing since his ship was ambushed in a Harusame raid. Nobume also makes a stunning revelation regarding the Tendoushuu, a secret organization pulling the strings of numerous factions, and their leader Utsuro, the shadowy figure with an uncanny resemblance to Gintoki's former teacher.

Hitching a ride on Sakamoto's space ship, the Yorozuya and Katsura set out for Rakuyou, Kagura's home planet, where the various factions have gathered and tensions are brewing. Long-held grudges, political infighting, and the Tendoushuu's sinister overarching plan finally culminate into a massive, decisive battle on Rakuyou.
TEXT
            ],

            [
                'title' => 'Kaguya-sama',
                'image' => 'storage/series/10.jpg',
                'video' => 'vFN5K-iAyV0',
                'synopsis' => <<<TEXT
The elite members of Shuchiin Academy's student council continue their competitive day-to-day antics. Council president Miyuki Shirogane clashes daily against vice-president Kaguya Shinomiya, each fighting tooth and nail to trick the other into confessing their romantic love. Kaguya struggles within the strict confines of her wealthy, uptight family, rebelling against her cold default demeanor as she warms to Shirogane and the rest of her friends.

Meanwhile, council treasurer Yuu Ishigami suffers under the weight of his hopeless crush on Tsubame Koyasu, a popular upperclassman who helps to instill a new confidence in him. Miko Iino, the newest student council member, grows closer to the rule-breaking Ishigami while striving to overcome her own authoritarian moral code.

As love further blooms at Shuchiin Academy, the student council officers drag their outsider friends into increasingly comedic conflicts.
TEXT
            ],
        ];

        $seriesCollection = collect();

        foreach ($images as $entry) {
            $type = $faker->randomElement(['TV', 'Movie', 'OVA']);
            $minutes_per_episode = $type === 'TV' ? 20 : 100;

            $series = Series::create([
                'title' => $entry['title'],
                'type' => $type,
                'cover_image' => $entry['image'],
                'video' => $entry['video'],
                'episode_count' => $faker->numberBetween(1, 100),
                'minutes_per_episode' => $minutes_per_episode,
                'aired_start_date' => $faker->dateTimeBetween('-5 years', '-3 years'),
                'aired_end_date' => $faker->dateTimeBetween('-2 years', '+2 years'),
                'score' => $faker->numberBetween(1, 10),
                'synopsis' => $entry['synopsis'],
            ]);

            $seriesCollection->push($series);
        }

        $studios = collect([
            'MAPPA',
            'Wit Studio',
            'Bones',
            'Studio Pierrot',
            'Ufotable',
            'CloverWorks',
            'A-1 Pictures',
            'Kyoto Animation',
            'Production I.G',
            'Madhouse',
        ])->map(function ($name) {
            return Studio::create(['name' => $name]);
        });

        $genres = Genre::factory()->count(5)->create();

        $series_status_names = ['Watching', 'Completed', 'Dropped', 'Plan to watch', 'On-Hold'];

        $series_statuses = collect($series_status_names)->map(function ($name) {
            return SeriesStatus::create(['name' => $name]);
        });

        $series->each(function ($serie) use ($genres, $studios) {
            $serie->genres()->attach(
                $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
            $serie->studios()->attach(
                $studios->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        $userCollection->each(function ($user) use ($seriesCollection, $series_statuses, $faker) {
            $seriesCollection->each(function ($serie) use ($user, $series_statuses, $faker) {
                $user->series()->attach($serie->id, [
                    'series_status_id' => $series_statuses->random()->id,
                    'start_date' => $faker->dateTimeBetween('-5 years', '-3 years'),
                    'end_date' => $faker->dateTimeBetween('-2 years', '+2 years'),
                    'episode_count' => $faker->numberBetween(1, $serie->episode_count ?? 24),
                    'score' => $faker->numberBetween(1, 10),
                ]);
            });
        });
    }
}
