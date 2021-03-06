<?php if (!defined('FARI')) die();

/**
 * Application testing example.
 *
 * @package   Application\Presenters
 */
class TestsPresenter extends Fari_ApplicationPresenter {



    /********************* unit testing & contracts through assertions *********************/



	public function actionIndex($p) { }

	public function actionUnit($p) {
        $test = new Fari_TestUnit();

		$test->is(1, 1.0, 'test if 1 is 1');
		$test->isStrictly(1, 1.0, 'test if 1 is 1 (strictly)');
		$test->compare($apples, '>', 'oranges', 'compare apples and oranges');

		$test->report();
	}

	public function actionContract($parameter) {
        assert('!empty($parameter); // a parameter needs to be set!');
	}

}
