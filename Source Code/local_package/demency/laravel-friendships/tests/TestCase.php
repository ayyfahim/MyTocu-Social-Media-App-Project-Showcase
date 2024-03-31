<?php

namespace Tests;

include_once __DIR__ . '/../tests/helpers.php';

use Demency\Friendships\FriendshipsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase($this->app);
        $this->withFactories(__DIR__ . '/../factories');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FriendshipsServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('friendships.tables.fr_groups_pivot', 'user_friendship_groups');
        $app['config']->set('friendships.tables.fr_pivot', 'friendships');
        $app['config']->set('friendships.groups.acquaintances', 0);
        $app['config']->set('friendships.groups.close_friends', 1);
        $app['config']->set('friendships.groups.family', 2);
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        include_once __DIR__ . '/../migrations/0000_00_00_000000_create_friendships_groups_table.stub.php';
        include_once __DIR__ . '/../migrations/0000_00_00_000000_create_friendships_table.stub.php';

        (new \CreateFriendshipsGroupsTable())->up();
        (new \CreateFriendshipsTable())->up();
    }
}
