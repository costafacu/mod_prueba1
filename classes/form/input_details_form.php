<?php

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     mod_prueba1
 * @copyright   2024 Your Name 
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class input_details_form extends moodleform {
  private $id;
  public function __construct($id) {
    $this->id = $id;
    parent::__construct();
  }
    public function definition() {
      $mform = $this->_form;

      $mform->addElement('text', 'meeting_id', 'Ingrese el detalle del zoom id');
      $mform->setType('meeting_id', PARAM_NOTAGS);
      $mform->setDefault('meeting_id','12299');
      
      $mform->addElement('hidden', 'id', $this->id);

      
      $this->add_action_buttons();
    }                           
}