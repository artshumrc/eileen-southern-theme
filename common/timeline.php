<?php
    $events = get_records('Item', array('type'=>'Event'));
    $event_tags = get_record('Item', array('tags'=>'Event'));
    foreach (loop('events') as $item):
        echo $item->id;
    endforeach;
?>