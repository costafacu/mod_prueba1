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
    public function definition() {
      global $CFG;
      $mform = $this->_form;

      $mform->addElement('text', 'texto', 'Ingrese el detalle del zoom id');
      $mform->setType('texto', PARAM_NOTAGS);
      $mform->setDefault('texto','12299');
      $mform->addElement('hidden', 'id', '5');
      
      $this->add_action_buttons();
    }                           
}