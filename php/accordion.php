<?php
 function htmlAccordion(string $idNumber = null, string $group, string $heading = '', string $text = '', bool $opened = false)
{
	$openedclass = $opened ? 'in' : '';
	$html = "
		<div class=\"panel panel-default\">
			<div id=\"accordion-{$idNumber}-heading\" class=\"panel-heading\">
				<h4 class=\"panel-title\">
					<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#{$group}\" href=\"#accordion-{$idNumber}\">
						{$heading}
					</a>
				</h4>
			</div>
			<div id=\"accordion-{$idNumber}\" class=\"panel-collapse collapse {$openedclass}\">
				<div class=\"panel-body\">{$text}</div>
			</div>
		</div>
	";
	return $html;
}

?>