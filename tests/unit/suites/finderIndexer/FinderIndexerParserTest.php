<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

require_once JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/parser.php';

/**
 * Test class for FinderIndexerParser.
 * Generated by PHPUnit on 2012-06-10 at 14:41:55.
 */
class FinderIndexerParserTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Tests the getInstance method
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function testGetInstance()
	{
		$this->assertInstanceOf(
			'FinderIndexerParserHtml',
			FinderIndexerParser::getInstance('html'),
			'getInstance with param "html" returns an instance of FinderIndexerParserHtml.'
		);
	}

	/**
	 * Tests the getInstance method with a non-existing parser
	 *
	 * @return  void
	 *
	 * @since   3.0
	 *
	 * @expectedException  Exception
	 */
	public function testGetInstance_noParser()
	{
		FinderIndexerParser::getInstance('noway');
	}
}
