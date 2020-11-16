<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NextBoardsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NextBoardsTable Test Case
 */
class NextBoardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NextBoardsTable
     */
    protected $NextBoards;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.NextBoards',
        'app.Rersons',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NextBoards') ? [] : ['className' => NextBoardsTable::class];
        $this->NextBoards = $this->getTableLocator()->get('NextBoards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->NextBoards);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
