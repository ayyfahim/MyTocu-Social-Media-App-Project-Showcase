<?php

use App\Post;
use App\User;
use App\Liste;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Liste::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        $limit = 30;

        for ($i = 0; $i < $limit; $i++) {
            $list = Liste::create([
                'title'       => $faker->name,
                'user_id' => User::all()->random()->id,
                // 'images'      => $faker->image(URL::to(Config::get('assets.images')), 800, 600, [], [])
            ]);

            $getRandomFiftyNumberForList =  random_int(5, 50);

            for ($i = 0; $i < $getRandomFiftyNumberForList; $i++) {
                $like = $list->likes()->create([
                    'like'     => 1,
                    'user_id'  => User::all()->random()->id,
                ]);
            }

            $getRandomTenDigitNumber =  random_int(2, 10);

            for ($i = 0; $i < $getRandomTenDigitNumber; $i++) {

                $image = $faker->image();
                // $imageFile = new File($image);
                // Storage::disk('uploads')->putFile('posts', $image);

                // Image::make($image)->save(storage_path('uploads/posts/' . $filename));

                $post = Post::create([
                    'list_id' => $list->id,
                    'user_id' => $list->user_id,
                    'title' => $faker->name,
                    'description' => $faker->text(random_int(150, 500)),
                    'post_image' => $image
                ]);

                $getRandomFiftyNumberForPost =  random_int(0, 50);

                for ($i = 0; $i < $getRandomFiftyNumberForPost; $i++) {
                    $like = $post->likes()->create([
                        'like'     => 1,
                        'user_id'  => User::all()->random()->id,
                    ]);
                }
            }
        }
    }
}
