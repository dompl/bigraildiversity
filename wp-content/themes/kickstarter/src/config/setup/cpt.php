<?php
/**
 * Create Custom Post type
 * Documentation : https://github.com/jjgrainger/PostTypeshttps://github.com/jjgrainger/PostTypes
 * ---
 */
namespace config\setup;
use PostTypes\PostType;

class cpt {

  public function __construct() {
    $this->challenges();
    $this->attendees();
    $this->supporting_organisations();
  }

  public function challenges() {

    $options = array(
      'has_archive'   => false,
      'menu_position' => 5,
    );

    $names = array(
      'name'     => 'Challenges',
      'singular' => 'Challenge',
      'plural'   => 'Challenges',
      'slug'     => 'challenges',
    );

    $challenges = new PostType($names, $options);

    $challenges->labels(
      array(
        'add_new_item' => __('Add new Challenge'),
      )
    );

    $challenges->icon('dashicons-image-filter');

    return $challenges->register();
  }

  public function attendees() {

    $options = array(
      'has_archive'   => false,
      'menu_position' => 5,
    );

    $names = array(
      'name'     => 'Atendees',
      'singular' => 'Atendee',
      'plural'   => 'Atendees',
      'slug'     => 'attendees',
    );

    $attendees = new PostType($names, $options);

    $attendees->icon('dashicons-image-filter');

    return $attendees->register();
  }

  public function supporting_organisations() {

    $options = array(
      'has_archive'   => false,
      'menu_position' => 5,
    );

    $names = array(
      'name'     => 'Supporting Orgs',
      'singular' => 'Supporting Organisation',
      'plural'   => 'Supporting Orgs',
      'slug'     => 'supporting-organisations',
    );

    $supporting_organisations = new PostType($names, $options);

    $supporting_organisations->labels(array(
      'add_new_item' => __('Add new Supporting Organisation'),
    ));

    $supporting_organisations->icon('dashicons-image-filter');

    return $supporting_organisations->register();
  }

}
