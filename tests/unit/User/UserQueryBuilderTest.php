<?php

use Silk\User\Model;
use Silk\User\QueryBuilder;
use Illuminate\Support\Collection;

class UserQueryBuilderTest extends WP_UnitTestCase
{
    /**
     * @test
     */
    public function it_requires_a_wp_user_query()
    {
        $this->assertInstanceOf(QueryBuilder::class, new QueryBuilder(new WP_User_Query));
    }

    /**
     * @test
     */
    function if_no_user_query_instance_is_provided_it_will_create_one_for_us()
    {
        $this->assertInstanceOf(QueryBuilder::class, new QueryBuilder);
    }

    /**
     * @test
     */
    public function it_has_a_named_constructor_for_creating_a_new_instance()
    {
        $this->assertInstanceOf(QueryBuilder::class, QueryBuilder::make());
    }

    /**
     * @test
     */
    public function it_returns_the_results_as_a_collection()
    {
        $this->assertInstanceOf(Collection::class, QueryBuilder::make()->results());
    }

    /**
     * @test
     */
    function it_can_take_and_return_a_user_model()
    {
        $builder = new QueryBuilder();

        $user = new Model;
        $builder->setModel($user);

        $this->assertSame($user, $builder->getModel());
    }

}
