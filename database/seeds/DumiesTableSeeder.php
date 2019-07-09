<?php

use Illuminate\Database\Seeder;

class DumiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $roles = [
            ['role' => 'Admin'],
            ['role' => 'Member']
        ];
 
        DB::table('roles')->insert($roles);
 
        $users = [
            ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('password'), 'role_id' => 1],
            ['name' => 'Member', 'email' => 'member@mail.com', 'password' => bcrypt('password'), 'role_id' => 2],
        ];
 
        DB::table('users')->insert($users);
 
        $postings = [
            ['user_id' => 1, 'title' => 'Judul Post 1 Dimiliki Admin', 'body' => 'Contoh isi post 1 yang dimiliki Admin'],
            ['user_id' => 1, 'title' => 'Judul Post 2 Dimiliki Admin', 'body' => 'Contoh isi post 2 yang dimiliki Admin'],
            ['user_id' => 2, 'title' => 'Judul Post 1 Dimiliki Member', 'body' => 'Contoh isi post 1 yang dimiliki Member'],
            ['user_id' => 2, 'title' => 'Judul Post 2 Dimiliki Member', 'body' => 'Contoh isi post 2 yang dimiliki Member'],
        ];
 
        DB::table('postings')->insert($postings);
 
        $categories = [
            ['slug' => 'web-programming', 'category' => 'Web Programming'],
            ['slug' => 'desktop-programming', 'category' => 'Desktop Programming'],
        ];
 
        DB::table('categories')->insert($categories);
 
        $category_posting = [
            ['posting_id' => 1, 'category_id' => 1],
            ['posting_id' => 1, 'category_id' => 2],
            ['posting_id' => 2, 'category_id' => 1],
            ['posting_id' => 2, 'category_id' => 2],
            ['posting_id' => 3, 'category_id' => 1],
            ['posting_id' => 3, 'category_id' => 2],
            ['posting_id' => 4, 'category_id' => 1],
            ['posting_id' => 4, 'category_id' => 2],
        ];
 
        DB::table('category_posting')->insert($category_posting);
 
        $portfolios = [
            ['user_id' => 1, 'title' => 'Judul Portfolio 1 Dimiliki Admin', 'body' => 'Contoh isi portfolio 1 yang dimiliki Admin'],
            ['user_id' => 1, 'title' => 'Judul Portfolio 2 Dimiliki Admin', 'body' => 'Contoh isi portfolio 2 yang dimiliki Admin'],
            ['user_id' => 2, 'title' => 'Judul Portfolio 1 Dimiliki Member', 'body' => 'Contoh isi portfolio 1 yang dimiliki Member'],
            ['user_id' => 2, 'title' => 'Judul Portfolio 2 Dimiliki Member', 'body' => 'Contoh isi portfolio 2 yang dimiliki Member'],
        ];
 
        DB::table('portfolios')->insert($portfolios);
 
        $comments = [
            ['user_id' => 2, 'content' => 'Komentar dong di postingan ID 1', 'commentable_id' => '1', 'commentable_type' => 'App\Posting'],
            ['user_id' => 1, 'content' => 'Silakan, saya juga mau jawab di Post ID 1', 'commentable_id' => '1', 'commentable_type' => 'App\Posting'],
            ['user_id' => 2, 'content' => 'Komentar dong di portfolio ID 1', 'commentable_id' => '1', 'commentable_type' => 'App\Portfolio'],
            ['user_id' => 1, 'content' => 'Silakan, saya juga mau jawab di portfolio ID 1', 'commentable_id' => '1', 'commentable_type' => 'App\Portfolio'],
        ];
 
        DB::table('comments')->insert($comments);

        $tags = [
            ['name'=>'posting'],
            ['name'=>'portfolio']
        ];
        DB::table('tags')->insert($tags);

        $taggables =[
            ['tag_id'=>1,'taggable_id'=>1,'taggable_type'=>'App\Posting'],
            ['tag_id'=>2,'taggable_id'=>1,'taggable_type'=>'App\Posting'],
        ];
        DB::table('taggables')->insert($taggables);

    }
}
