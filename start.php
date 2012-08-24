<?php

elgg_unregister_widget_type('a_users_groups');
elgg_register_widget_type('a_users_groups', elgg_echo('groups:widget:membership'), elgg_echo('groups:widgets:description'), 'all', TRUE);

// custom options for select
function eligo_groups_select_options($widget, $vars){
  $options = array();
  
  // have to get the users groups here, because it requires relationship
  // not the most efficient, but fits better with the framework
  $user = get_user($widget->owner_guid);
    
  $groups = $user->getGroups('', 0, 0);
  
  $group_guids = array();
  foreach($groups as $group){
    $group_guids[] = $group->guid;
  }
  
  // if we have any groups, use guids in options
  // otherwise invalidate the query
  if(count($group_guids) > 0){
    $options['guids'] = $group_guids;
  }
  else{
    $options['subtypes'] = array('eligo_invalidate_query');
  }
	
  // determine sort-by
  $sort = $vars['eligo_select_sort'] ? $vars['eligo_select_sort'] : FALSE;
  if(!$sort){
	$sort = $widget->eligo_select_sort ? $widget->eligo_select_sort : 'date';
  }
	
  if ($sort == "name"){
    // join to objects_entity table to sort by title in sql
	$join = "JOIN " . elgg_get_config('dbprefix') . "groups_entity o ON o.guid = e.guid";
	$options['joins'] = array($join);
	$options['order_by'] = 'o.name ASC';
  }

	
  return $options;
}