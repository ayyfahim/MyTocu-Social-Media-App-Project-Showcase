<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

/** Base URL */

Route::get('/', 'FrontendController@baseURL')->name('base.url');

/** Admin Controller */
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users', 'auth', 'verified')->group(function () {
    Route::resource('users', 'UsersController', ['except' => ['create', 'store']]);
    Route::resource('lists', 'ListController', ['except' => ['create', 'store']]);
    Route::resource('posts', 'PostController', ['except' => ['create', 'store']]);
    Route::resource('journals', 'JournalController', ['except' => ['create', 'store']]);
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::prefix('dashboard')->group(function () {
        Route::resource('about-us', 'AboutUsController', ['except' => ['show']])->parameters(['about-us' => 'about_us']);
        Route::get('about-us/activate/{about_us}', 'AboutUsController@activate')->name('about-us.activate');
        Route::resource('terms-of-use', 'TermsOfUseController', ['except' => ['show']]);
        Route::resource('privacy-policy', 'PrivacyPolicyController', ['except' => ['show']]);
    });
});

/** Lists Controller */
Route::resource('list', 'ListController')->except(['index']);
Route::get('list/delete/{list}', 'ListController@delete')->name('list.destroy');

/** Posts Controller */
Route::resource('post', 'PostController')->except(['index']);
Route::get('/post/image/{filename}', 'PostController@getImage')->name('image.post');
Route::post('/cropimagepost', 'PostController@cropImage')->name('crop.image.post');

/** Journals Controller */
Route::resource('journal', 'JournalController')->except('index');
Route::get('journal/{slug}', 'JournalController@show')->name('journl.show');
Route::get('/journal/image/{filename}', 'JournalController@getImage')->name('image.journal');
Route::post('/cropimagejournal', 'JournalController@cropImage')->name('crop.image.journal');

/** User Controller */
Route::get('/user/{user}', 'UserController@show')->name('user.show');
Route::get('user/{user}/edit', 'UserController@edit')->name('user.edit');
Route::post('user/{user}/update', 'UserController@update')->name('user.update');
Route::get('user/{user}/disable', 'UserController@disableAccount')->name('user.disable');
Route::post('user/{user}/password', 'UserController@updatePassword')->name('user.update.password');
Route::post('user/{user}/email', 'UserController@updateEmail')->name('user.update.email');
Route::get('account/email/verify', 'UserController@verifyEmail')->name('verify.email');
Route::get('/userimage/{filename}', 'UserController@image')->name('image.account');
Route::post('profile-image', 'UserController@cropImage')->name('profile.pic');
Route::post('activate-account', 'UserController@activateAccount')->name('activate.account');

/** Invite Controller*/
Route::post('invite', 'InviteController@send')->name('invite.friend');

/** Likes Controller*/
Route::post('/like/create', 'LikeController@createOrDeleteLike')->name('like.store');

/** Comment Controller */
Route::resource('comments', 'CommentController')->except('index', 'create', 'show', 'edit');

/** Notifications Controller */
Route::get('markasread', 'NotificationController@markAsReadUnreadNotifications');
Route::get('notifications/unread', 'NotificationController@unreadNotifications');
Route::get('notifications/all', 'NotificationController@allNotifications');
Route::view('notifications', 'notifications.index')->name('notifications.index');

/** Message Controller */
Route::get('messages', 'MessageController@fetchMessages');
Route::post('messages', 'MessageController@sendMessages');
Route::get('private_messages/{id}', 'MessageController@fetchPrivateMessages');
Route::post('private_messages/{id}', 'MessageController@sendPrivateMessages');
Route::post('set_seen/{id}', 'MessageController@setSeen');

/** Chat Controller */
Route::get('/group-chat', 'ChatController@groupChat');
Route::get('private-chat/{user?}', 'ChatController@privateChat')->name('private.chat');
Route::get('/users_list', 'ChatController@usersList');
Route::get('/chat-image/{filename}', 'ChatController@chatImage')->name('chat.image');

/** Friendship Controller */
Route::post('friendship', 'FriendshipController@friendship')->name('friendship');

/** Search Controller */
Route::get('/result', 'SearchController@index')->name('search');


/**
 * Pagination Controllers
 */

/** Explore Contents  */
Route::get('render-all-lists', 'PaginationController@renderAllLists');
Route::get('render-all-journals', 'PaginationController@renderAllJournals');

/** Auth Contents  */
Route::get('render-auth-journal', 'PaginationController@renderAuthJournal');
Route::get('render-auth-lists', 'PaginationController@renderAuthLists');

/** User Profile Contents  */
Route::get('user/{id}/render-journal', 'PaginationController@renderUserJournal');
Route::get('user/{id}/render-lists', 'PaginationController@renderUserLists');

/** User Friends Contents  */
Route::get('render-friends-lists', 'PaginationController@renderFriendLists');
Route::get('render-friends-journals', 'PaginationController@renderFriendJournals');

/** Search Friends Contents  */
Route::get('render-search-posts/{phrase}', 'PaginationController@renderSearchPosts')->name('search.posts');
Route::get('render-search-journals/{phrase}', 'PaginationController@renderSearchJournals')->name('search.journals');

/** User Tabs Controller */
Route::get('user_lists', 'UserTabsController@userLists')->name('user.lists');
Route::get('user_journals', 'UserTabsController@userJournals')->name('user.journals');
Route::get('user_friends', 'UserTabsController@userFriends')->name('user.friends');
Route::get('user_explore', 'UserTabsController@userExplore')->name('user.explore');

/** Auth Route (Login, Register, etc...) */
Auth::routes(['verify' => true]);

/** Fetch Country and States */
Route::post('country', 'CountryController@fetch')->name('get.state');

/** Frontend Controller */
Route::get('terms-of-use', 'FrontendController@termsOfUse')->name('terms.use');
Route::get('about-us', 'FrontendController@aboutUs')->name('about.us');
Route::get('privacy-policy', 'FrontendController@privacyPolicy')->name('privacy.policy');
Route::get('explore', 'FrontendController@explore')->name('explore.page');

/** Blog Controller */
Route::resource('blog', 'BlogController');
Route::get('blog/image/{filename}', 'BlogController@getImage')->name('blog.image');
