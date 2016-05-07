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

App::uses('ModelBehavior', 'Model');

class RatedBehavior extends ModelBehavior
{
	public function setup(Model $Model, $config = array())
	{
		$Model->bindModel
			(
				array
				(
					'hasMany' => array
					(
						'Rating' => array
						(
							'className'		=> 'Feedback.Rating',
							'conditions'	=> sprintf('Rating.foreign_model = \'%s\'', $Model->name),
							'foreignKey'	=> 'foreign_id',
						)
					)
        		),
				false
			);
	}

	public function cleanup(Model $Model)
	{
		$Model->unbindModel(array('hasMany' => array('Rating')), false);
	}

	// @TODO: implement bayesian average as a behaviour and use that
	// @TODO: this doesn't seem to be called when query is not primary...
	// why the arse do we have the $primary param then..?
	function afterFind(Model $Model, $results, $primary = false)
	{
		if ($primary)
		{
			foreach ($results as &$result)
			{
				$data = Hash::extract($result, 'Rating.{n}.rating');

				if (!empty($data))
				{
					$total = array_sum($data);
					$votes = count($data);
					$rating = round($total / $votes, 2);

					$result['RatingSummary'] =
						array
						(
							'total_votes' => $votes,
							'total_rating' => $rating
						);
				}
			}
		}

		return $results;
	}
}
