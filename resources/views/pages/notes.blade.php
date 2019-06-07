@extends('layouts.app')

@section('cssAssets')
<style>
.cardsection{
    margin-bottom:20px;
}
.path{
    font-style: italic;
    color:#644dea;
}
.comment{
    background:#d8d8d8;
    padding:3px;
    margin-left:0px 10px;
}
ol li{
    padding:10px 10px;
}
</style>
@endsection
@section('content')

<div class="container" style="margin-top:20px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Notes</h2>
            <hr>
        </div>
        <div class="col-md-12">
            <div class="card cardsection" id="MigrateTable">
                <div class="card-header"><h4>disable/enable (block) user login ( web + passport oauth):</h4></div>
                <div class="card-body">
                    <p>To block the disabled user in login..</p>
                    <ol>
                        <li>add new field to the User table called <code>‘status’ (1:enabled, 0:disabed)</code></li>
                        <li>To block the web login , in <span class="path">app/Http/Controllers/Auth/LoginController.php</span> add the follwoing function:<br>
                            <code>
                                /**<br>
                                * Get the needed authorization credentials from the request.<br>
                                *<br>
                                * @param \Illuminate\Http\Request $request<br>
                                * @return array<br>
                                */<br>
                                protected function credentials(\Illuminate\Http\Request $request)<br>
                                {<br>
                                $credentials = $request->only($this->username(), ‘password’);<br>
                                return array_add($credentials, ‘status’, ‘1’);<br>
                                }<br>
                            </code>
                        </li>
                        <li>to block the user when using passport authentication ( token ) , in the User.php model add the following function :<br>
                            <code>
                                public function findForPassport($identifier) {<br>
                                    return User::orWhere(‘email’, $identifier)->where(‘status’, 1)->first();<br>
                                }<br>
                            </code>
                        </li>
                        
                    </ol>
                </div>
            </div>
            <div class="card cardsection" id="MigrateTable">
                <div class="card-header"><h4>Migrate Tables:</h4></div>
                <div class="card-body">
                   When migrate the tables to avoid errors please use the following steps..
                    <ol>
                        <li>Open the <span class="path">app\Providers\AppServiceProvider.php</span> file</li>
                        <li>Add <code>use Illuminate\Support\Facades\Schema;</code> line on the top</li>
                        <li>Replace or add boot function <br><code>public function boot()<br> {<br> Schema::defaultStringLength(191);<br> }</code></li>
                        <li>Run the comment <span class="comment">php artisan migrate</span></li>
                    </ol>
                </div>
            </div>
            <div class="card cardsection" id="AlterTable">
                <div class="card-header"><h4>Alter Table:</h4></div>
                <div class="card-body">
                Add new coloumn in table using migration <a target="_blank" href="https://laravel.com/docs/5.7/migrations#creating-columns">(View Reference)</a>
                    <ol>
                        <li>Run the comment like <span class="comment">php artisan make:migration add_userid_to_posts_table --table=posts</span> </li>
                        <li>Add the following code in up function<br>
                            <code>
                                Schema::table('users', function (Blueprint $table) {<br>
                                    $table->string('email')->after('status');<br>
                                });<br>
                            </code>
                        </li>
                        <li>Run the comment <span class="comment">php artisan migrate</span></li>
                    </ol>
                </div>
            </div>
            <div class="card cardsection" id="ForiegnKey">
                <div class="card-header"><h4>Foriegn Key:</h4></div>
                <div class="card-body">
                To add foreign key <a target="_blank" href="https://laravel.com/docs/5.7/migrations#foreign-key-constraints">(View Reference)</a>
                    <ol>
                        <li>Open the migrate file in the <span class="path">database\migration</span> folder </li>
                        <li>Add the following code in up function<br>
                            <code>
                                Schema::table('users', function (Blueprint $table) {<br>
                                    $table->unsignedInteger('user_id')->nullable()->after('status');<br>
                                    $table->foreign('user_id')->references('id')->on('users');<br>
                                });<br>
                            </code>
                        </li>
                        <li>Run the comment <span class="comment">php artisan migrate</span></li>
                    </ol>
                </div>
            </div>

            <div class="card cardsection" id="CustomLoginRedirectionBasedOnRole">
                <div class="card-header"><h4>Custom Login Redirection Based On Role</h4></div>
                <div class="card-body">
                To redirect the page based on the user role, Please follow the steps..
                    <ol>
                        <li>Open the <span class="path">app\Http\Controllers\Auth\LoginController.php</span> file </li>
                        <li>Change the <code>redirectTo</code> variable to function</li>
                        <li>Add the following code<br>
                            <code>
                               public function redirectTo(){<br>
                                    // Get the user role<br>
                                    $role = Auth::user()->usertype; <br>
                                    // Check user role<br>
                                    switch ($role) {<br>
                                        case 'admin':<br>
                                                return '/admin/dashboard';<br>
                                            break;<br>
                                        case 'user':<br>
                                                return '/members/home';<br>
                                            break; <br>
                                        default:<br>
                                                return '/login'; <br>
                                            break;<br>
                                    }<br>
                                }
                            </code>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card cardsection" id="AuthendicateAndCheckTheUserRole">
                <div class="card-header"><h4>Authendicate And Check The User Role in Route</h4></div>
                <div class="card-body">
                To Check the user role..
                    <ol>
                        <li>Open the <span class="path">App\Providers\AuthserviceProvider.php</span> file</li>
                        <li>Add the following code<br>
                            <code>
                              public function boot()<br>
                                {<br>
                                    $this->registerPolicies();<br>

                                    Gate::define('isAdmin', function ($user) {<br>
                                        return $user->usertype == "admin";<br>
                                    });<br>

                                    Gate::define('isUser', function ($user) {<br>
                                        return $user->usertype == "user";<br>
                                    });<br>
                                }
                            </code>
                        </li>
                        <li>Open the <span class="path">web.php</span> file</li>
                        <li>Add the following code<br>
                            <code>
                             Route::prefix('members')->middleware(['auth','can:isUser'])->group(function () {<br>
                                Route::get('/home', 'HomeController@index');<br>
                            });
                            </code>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card cardsection" id="AuthendicateAndCheckTheUserRole">
                <div class="card-header"><h4>Customizing The Pagination View</h4></div>
                <div class="card-body">
                However, the easiest way to customize the pagination views is by exporting them to your  <span class="path">resources/views/vendor</span> directory using the <span class="comment">vendor:publish</span> command:<br><a href="https://laravel.com/docs/5.7/pagination#customizing-the-pagination-view">(View Reference)</a>
                <br>
                <span class="comment">php artisan vendor:publish --tag=laravel-pagination</span> <br>
                <p>This command will place the views in the <span class="path">resources/views/vendor/pagination</span> directory. The  <span class="path">bootstrap-4.blade.php</span> file within this directory corresponds to the default pagination view. You may edit this file to modify the pagination HTML.</p>
                    
                </div>
            </div>

            php artisan vendor:publish --tag=laravel-pagination
    </div>
</div>
@endsection
