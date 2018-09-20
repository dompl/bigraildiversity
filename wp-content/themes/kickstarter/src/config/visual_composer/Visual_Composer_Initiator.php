<?php
/*  ********************************************************
 *   Init all vicusl composer elements via this class
 *  ********************************************************
 */
namespace config\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use theme\visual_composer\VC_Element_Blank;
use theme\visual_composer\VC_RBDC_Page_Banner;
use theme\visual_composer\VC_BRDC_Custom_Title;
use theme\visual_composer\VC_BRDC_Spacer;

if ( ! class_exists('Visual_Composer_General_Settings')) {

  class Visual_Composer_Initiator extends Visual_Composer_General_Settings {

    private static $loaded = false;

    public function __construct() {
      $this->initClasses();
    }

    public function initClasses() {

      if (self::$loaded) {

        return false;

      }

      self::$loaded = true;

      new Visual_Composer_General_Settings();
      new VC_Element_Blank();
      new VC_RBDC_Page_Banner();
      new VC_BRDC_Custom_Title();
      new VC_BRDC_Spacer();

    }
  }
}