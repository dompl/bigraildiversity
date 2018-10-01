<?php
/*  ********************************************************
 *   Init all vicusl composer elements via this class
 *  ********************************************************
 */
namespace config\visual_composer;
use config\visual_composer\Visual_Composer_General_Settings;
use config\visual_composer\Visual_Composer_Params_Extenders;
use config\visual_composer\Visual_Composer_Additional_Params;
use config\visual_composer\Visual_Composer_Custom_Elements;
use theme\visual_composer\VC_Element_Blank;
use theme\visual_composer\VC_RBDC_Page_Banner;
use theme\visual_composer\VC_BRDC_Custom_Title;
use theme\visual_composer\VC_BRDC_Spacer;
use theme\visual_composer\VC_BRDC_Single_Image;
use theme\visual_composer\VC_BRDC_Modal_Call_For_Action;
use theme\visual_composer\VC_BRDC_Simple_Button;
use theme\visual_composer\VC_Sponsors_Slider;
use theme\visual_composer\VC_BRDC_Winners_Table;
use theme\visual_composer\VC_BRDC_Image_Gallery;
use theme\visual_composer\VC_BRDC_Bullet_List;
use theme\visual_composer\VC_BRDC_Testimonial_Scroller;
use theme\visual_composer\VC_BRDC_Challanges;

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
      new Visual_Composer_Params_Extenders();
      new Visual_Composer_Additional_Params();
      new Visual_Composer_Custom_Elements();
      new VC_Element_Blank();
      new VC_RBDC_Page_Banner();
      new VC_BRDC_Custom_Title();
      new VC_BRDC_Spacer();
      new VC_BRDC_Single_Image();
      new VC_BRDC_Modal_Call_For_Action();
      new VC_BRDC_Simple_Button();
      new VC_Sponsors_Slider();
      new VC_BRDC_Winners_Table();
      new VC_BRDC_Image_Gallery();
      new VC_BRDC_Bullet_List();
      new VC_BRDC_Testimonial_Scroller();
      new VC_BRDC_Challanges();

    }
  }
}