<?php
class EventsImage extends AppModel {

    var $actsAs = array('Containable');

    var $belongsTo = array(
        'Event' => array(
            'className'     => 'Event',
            'foreignKey'	=> 'events_id'
        )
    );

}
