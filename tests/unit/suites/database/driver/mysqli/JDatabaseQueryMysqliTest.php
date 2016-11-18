<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Database
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JDatabaseQueryMysqli.
*
* @package     Joomla.UnitTest
* @subpackage  Database
* @since       __DEPLOY_VERSION__
*/
class JDatabaseQueryMysqliTest extends TestCase
{
	/**
	 * @var    JDatabaseDriver  A mock of the JDatabaseDriver object for testing purposes.
	 * @since  13.1
	 */
	protected $dbo;

	/**
	 * The instance of the object to test.
	 *
	 * @var    JDatabaseQueryMysqli
	 * @since  12.3
	 */
	private $_instance;

	/**
	 * Sets up the fixture.
	 *
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   13.1
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->dbo = $this->getMockDatabase();

		$this->_instance = new JDatabaseQueryMysqli($this->dbo);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 *
	 * @see     PHPUnit_Framework_TestCase::tearDown()
	 * @since   3.6
	 */
	protected function tearDown()
	{
		unset($this->dbo);
		unset($this->_instance);
		parent::tearDown();
	}

	/**
	 * Test for the JDatabaseQueryMysqli::__string method for a 'windowRowNumber' case.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function test__toStringWindowRowNumber()
	{
		$this->_instance
			->select('id')
			->select('ordering')
			->windowRowNumber('ordering')
			->from('a')
			->where('catid = 1');

		$this->assertEquals(
			PHP_EOL . "SELECT id,ordering,(SELECT @a := @a + 1 FROM (SELECT @a := 0) AS `row_init`)" .
			PHP_EOL . "FROM a" .
			PHP_EOL . "WHERE catid = 1" .
			PHP_EOL . "ORDER BY ordering",
			(string) $this->_instance
		);

		$this->_instance
			->clear('select')
			->select('id')
			->select('ordering')
			->windowRowNumber('ordering', 'row_number')
			->order('id');

		$this->assertEquals(
			PHP_EOL . "SELECT * FROM ( " .
			PHP_EOL . "SELECT id,ordering,(SELECT @a := @a + 1 FROM (SELECT @a := 0) AS `row_init`) AS row_number" .
			PHP_EOL . "FROM a" .
			PHP_EOL . "WHERE catid = 1" .
			PHP_EOL . "ORDER BY ordering ) AS `window`" .
			PHP_EOL . "ORDER BY id",
			(string) $this->_instance
		);

		$this->_instance
			->clear('select')
			->select('id')
			->select('ordering');

		$this->assertEquals(
			PHP_EOL . "SELECT id,ordering" .
			PHP_EOL . "FROM a" .
			PHP_EOL . "WHERE catid = 1" .
			PHP_EOL . "ORDER BY id",
			(string) $this->_instance
		);
	}

	/**
	 * Test for the JDatabaseQuery::__string method for a 'update' case.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function test__toStringUpdate()
	{
		$this->_instance
			->update('#__foo AS a')
			->join('INNER', 'b ON b.id = a.id')
			->set('a.id = 2')
			->where('b.id = 1');

		$string = (string) $this->_instance;

		$this->assertEquals(
			PHP_EOL . "UPDATE #__foo AS a" .
			PHP_EOL . "INNER JOIN b ON b.id = a.id" .
			PHP_EOL . "SET a.id = 2" .
			PHP_EOL . "WHERE b.id = 1",
			$string
		);

		// Run method __toString() again on the same query
		$this->assertEquals(
			$string,
			(string) $this->_instance
		);
	}
}
