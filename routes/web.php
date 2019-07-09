<?php
use App\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/about');
});

Route::get('/about', function() {
    return 'Hi, This about page';
});

// Route::get('/blog', 'PostController@index');
// Route::get('/post/create', 'PostController@create');
// Route::post('/post/store', 'PostController@store')->name('post.store');

// Route::get('/post/{id}', ['as' => 'post.detail', function($id)  {
//     echo "Post $id";
//     echo "</br>";
//     echo "Body post in ID $id";
// }]);

Route::resource('post', 'PostController');

Route::get('/insert', function(){
	$data = [
		'title' => 'cek',
		'body' => 'cek',
		'user_id' => 1
	];
	DB::table('posts')->insert($data);
	echo "Data berhasil ditambah";
});

Route::get('/read', function(){
	
	$query= DB::table('posts')->select('title','body','id')->where('title','cek')->orderBy('id','desc')->first();
	dd($query);
});

Route::get('/update', function(){
	$data = [
		'title' => 'haha',
		'body' => 'haha',
		'user_id' => 3
	];
	$updated = DB::table('posts')->where('id',1)->update($data);
	dd($updated);

});

Route::get('/delete',function(){
	$delete = DB::table('posts')->where('id',1)->delete();
	return $delete;
});

Route::get('/posts',function(){
	$posts = Post::all();
	return $posts;
});

Route::get('/find',function(){
	$post = Post::find(2);
	return $post;
});

Route::get('/findwhere',function(){
	$posts = Post::where('user_id',2)->orderBy('id','desc')->take(1)->get();
	return $posts;
});

Route::get('/create',function(){
	$post = new Post();
	$post->title = 'isi judul';
	$post->body = 'isi posting';
	$post->user_id = 7;

	$post->save();
	return 'sukses';

});

Route::get('/createpost',function(){
	$post = Post::create([
		'title'=> 'create data method',
		'body'=>'body data method',
		'user_id'=> Auth::user()->id
	]);
	return 'sukses';
});

Route::get('/updatepost',function(){
	$post=Post::find(5);
	$post->update([
		'title'=> 'update data method',
		'body'=>'body data method',
		'user_id'=> 15
	]);
	return 'sukses';

});

Route::get('/deletepost',function(){
	// $post = Post::find(3);
	// $post->delete();

	Post::destroy([6,7]);
	return 'deleted';
});

Route::get('/softdelete',function(){
	Post::destroy([3,4,5]);
});

Route::get('/trash',function(){
	// $post=Post::withTrashed()->get();
	$post=Post::onlyTrashed()->get();
	return $post;
});

Route::get('/restore',function(){
	$post = Post::onlyTrashed()->restore();
	return $post;
});

Route::get('/forcedelete',function(){
	// $post =Post::onlyTrashed()->where('id',1)->forceDelete();
	// $post= Post::onlyTrashed()->forceDelete();
	$post = Post::find(7)->forceDelete();
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'HomeController@users')->name('users');
Route::get('/user',function(){
	return Auth::user()->email;
});

Route::get('/admin',function(){
	return 'halaman admin';
})->middleware(['auth','role']);

Route::get('/member',function(){
	return 'halaman member';
});
// ----------------------------------------------------------------------------------------------------------

// **-----------------------------------------
// eloquent
// Route::middleware('auth')->group(function(){
Use App\User;
Use App\Profile;

// one to one
Route::get('create-user',function(){
	$user = User::create([
		'name' => 'member',
		'email' => 'member@gmail.com',
		'password'=>bcrypt('123456'),
		'role_id'=>1
	]);
	return $user;
});

Route::get('/user-create-profile',function(){
	// $profile = Profile::create([
	// 	'user_id' =>1,
	// 	'phone' =>'123123123',
	// 	'address'=> 'jl. maerasari 31 A'
	// ]);
	// return $profile;
	$user = User::find(1);
	$user->profile()->create([
		 'phone'=>'1234123',
		'address'=>'jl.maerasari 31 A'
	]);
	return $user;
});

// Route::get('/',function(){

// });
Route::get('profile-create',function(){
	$user= User::find(2);
	$profile = new Profile([
		'phone'=>'1234123',
		'address'=>'jl.maerasari 31 A'

	]);
	$user->profile()->save($profile);


	return $user;
});

Route::get('/user-read',function(){
	$user= User::find(1);
	// return $user->profile->phone;
	$data=[
		'name'=>$user->name,
		'phone'=>$user->profile->phone,
		'address'=>$user->profile->address,
	];
	return $data;
});

Route::get('/profile-read',function(){
	$profile = Profile::where('id','1')->first();
	// $profile->user->name;
	// return $profile;
	$data=[
		'name'=>$profile->user->name,
		'email'=>$profile->user->name,
		'phone'=>$profile->phone,
		'address'=>$profile->address,
	];
	return $data;
});

Route::get('/profile-update',function(){
	$user= User::find(2);
	// return $user->profile->phone;
	$user->profile()->update([
		'phone' =>'08912',
		'address'=>'jl.kenangan'
	]);
	return $user;
});

Route::get('/profile-delete',function(){
	$user= User::find(1);
	// return $user->profile->phone;
	$user->profile()->delete();
	return $user;
});
// **-----------------------------------------
// one to many
use App\Posting;
Route::get('/posting-create',function(){
	// $user = User::create([
	// 	'name'=>'Hakim',
	// 	'email'=>'1cesk@gmail.com',
	// 	'password'=>bcrypt('123456')
	// ]);
	$user=User::findOrFail(2);
	$user->posting()->create([
		'title'=>'cek user member',
		'body'=>'cek user member'
	]);
	return $user;
});

Route::get('/posting-read',function(){
	$user = User::find(1);
	$postings = $user->posting()->get();

	foreach ($postings as $posting) {
		$data[]=[
			'id'=>$posting->id,
			'name'=>$posting->user->name,
			'title'=>$posting->title,
			'body'=>$posting->body,
		];
	}
	return $data;
});

Route::get('posting-update',function(){
	$user = User::findOrFail(1);
	$user->posting()->whereId(1)->update([
		'title'=>'ini isian title update v2',
		'body'=>'ini isian body update'
	]);

	return $user;

});

Route::get('/posting-delete', function(){
	$user = User::find(1);

	$user->posting()->whereUserId(1)->delete();
	return 'sukses';
});

// **-----------------------------------------
// many to many
use App\Category;
Route::get('/category-create',function(){
	// $posting = Posting::findOrFail(1);

	// $posting->categories()->create([
	// 	'slug'=>str_slug('Belajar Laravel v3','-'),
	// 	'category'=>'Belajar Laravel v3'
	// ]);
	// return 'seukses';

	$user = User::create([
		'name'=>'Hakim',
		'email'=>'ces@gmail.com',
		'password'=>bcrypt('123456')
	]);

	$user->posting()->create([
		'title'=>'new title',
		'body' =>'new body'

	])->categories()->create([
		'slug'=>str_slug('New Category', '-'),
		'category'=>'new category'
	]);
	return 'sukses';
});

Route::get('category-read',function(){
	$posting = Posting::find(2);

	$categories = $posting->categories;
	foreach ($categories as $category) {
		echo $category->slug.' ||';
	}

	// $category = Category::find(3);
	// $postings = $category->postings;

	// foreach ($postings as $posting) {
	// 	echo $posting->title.'<br>';
	// }
});

Route::get('/attach',function(){
	$posting = Posting::find(3);
	$posting->categories()->attach([1,2,3]);

	return 'sukses';
});

Route::get('/detach', function(){
	$posting = Posting::find(3);
	$posting->categories()->detach(1);

	return 'sukses';
});

Route::get('/sync',function(){
	$posting = Posting::find(3);
	$posting->categories()->sync([
		1
	]);
	return 'sukses';
});

// **-----------------------------------------
// one to many through
use App\Role;
Route::get('role-posting',function (){
	$role = Role::find(1);
	$roles =$role->postings;
	foreach ($roles as $role) {
		echo $role->body;
	}
});
// **-----------------------------------------
//polymorphic
use App\Portfolio;

Route::get('/comment-create',function(){
	$posting = Portfolio::find(1);
	// dd($posting);
	$posting->comments()->create([
		'user_id' =>2,
		'content' => 'balasan dari user id 1 portfolio'
	]);

	return 'Success';
});

Route::get('/comment-read',function(){
	$portfolio= Portfolio::findOrFail(1);
	$comments= $portfolio->comments;
	foreach ($comments as $comment) {
		echo $comment->user->name.'-'.$comment->content.'-'.$comment->commentable->title;
		echo "<br>";
	}
	
});

Route::get('comment-update',function(){
	// $posting=Posting::find(1);
	// $comments = $posting->comments()->where('id',1)->first();
	// $comments->update([
	// 	'content'=>'komentarnya telah di sunting'
	// ]);
	$portfolio=Portfolio::find(1);
	$comments = $portfolio->comments()->where('id',3)->first();
	$comments->update([
		'content'=>'komentarnya telah di sunting pda bagian portfolio'
	]);
	return 'success';

});

Route::get('comment-delete',function(){
	$posting=Posting::find(1);
	 $posting->comments()->where('id',1)->delete();
	 return 'success';
});

// **-----------------------------------------
//many polymorphic

Route::get('tag-read',function(){
	$posting=Posting::find(1);
	// return $posting->tags;
	foreach ($posting->tags as $tag) {
		echo $tag->name.'<br>';
	}
});

Route::get('tag-attach',function(){
	$posting=Posting::find(1);
	// return $posting->tags;
	$posting->tags()->attach([1,2]);
	
});

Route::get('tag-detach',function(){
	$posting=Posting::find(1);
	// return $posting->tags;
	$posting->tags()->detach([1]);
	
});

Route::get('tag-sync',function(){
	$posting=Posting::find(1);
	// return $posting->tags;
	$posting->tags()->sync([1]);
	
});