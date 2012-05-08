<?php

$widget = $vars['entity'];

// now we can get our content
$options = eligo_get_display_entities_options($widget);

// a few adjustments for groups
$options['relationship'] = 'member';
$options['relationship_guid'] = $widget->owner_guid;

$content = elgg_list_entities_from_relationship($options);

echo $content;

if ($content) {
	$url = "groups/member/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('groups:more'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('groups:none');
}
