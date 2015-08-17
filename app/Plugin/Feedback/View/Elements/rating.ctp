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
?>
<div class="rating">
	<div class="rateit bigstars" id="<?php echo $element_id; ?>"></div>
	<div>
		<span class="rating-message" id="<?php echo $message_id; ?>"></span>
		<span class="rating-values" id="<?php echo $values_id; ?>">
			<?php echo __('Rating:'); ?>
			<span class="rating"><?php echo sprintf('%.02f', $value); ?></span>
			<?php echo __('Votes:'); ?>
			<span class="votes"><?php echo sprintf('%d', $votes); ?></span>
		</span>
	</div>
</div>
<?php
$user_vote_message = __('Your vote: %.01f', $user_vote);
$submitting_message = __('Sending vote...');
$error_message = __('There was an error while saving your vote');

$script = <<<END
$('#{$element_id}').rateit({
	starwidth: 32,
	starheight: 32,
	resetable: false,
	readonly: {$readonly},
});

$('#{$element_id}').rateit('value', {$value});
$('#{$element_id}').rateit('ispreset', true);

if ('{$readonly}' == 'true')
{
	$('#{$message_id}').text('{$user_vote_message}');
}

$('#{$element_id}').bind('rated', function() {
	var elem = $(this);
	var message = $('#{$message_id}');
	var rating = elem.rateit('value');
	message.text('{$submitting_message}');

	$.ajax({
		type: 'POST',
		url: '{$submit_url}',
		data: {
			Rating: {
				foreign_model: '{$modelClass}',
				foreign_id: '{$data[$modelClass]['id']}',
				rating: rating,
			}
		},
		success: function(response)
		{
			if (response.success)
			{
				elem.rateit('readonly', true);

				if (typeof response.data.total_rating != 'undefined')
				{
					$('#{$values_id} span.rating').text(response.data.total_rating.toFixed(2));
					$('#{$values_id} span.votes').text(response.data.total_votes);
				}
			}

			message.text(response.message);
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			message.text('{$error_message}');
		}
	});
});
END;

$this->Html->scriptBlock($script, array('block' => 'script_execute'));
?>
