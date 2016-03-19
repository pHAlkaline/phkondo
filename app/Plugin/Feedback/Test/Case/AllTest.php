<?php
/**
	CakePHP Feedback Plugin

	Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
	<http://lecterror.com/>

	Multi-licensed under:
		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
		LGPL <http://www.gnu.org/licenses/lgpl.html>
		GPL <http://www.gnu.org/licenses/gpl.html>
*/

class AllFeedbackTests extends CakeTestSuite
{
	public static function suite()
	{
		$suite = new CakeTestSuite('All Feedback tests');

		$suite->addTestDirectoryRecursive(App::pluginPath('Feedback').'Test'.DS.'Case');

		return $suite;
	}
}
