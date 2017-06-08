<?php
/*
 * solswebdesign.nl
 *
 * @category    Sols
 * @copyright   Copyright (c) 2017 SolsWebdesign
 */
class Sols_Synchronized_Block_Renderer_Check extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $value =  $row->getData($this->getColumn()->getIndex());

        if($value == 0) {

            return '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 20 16">
  <defs>
    <style>
      .cls-2 {
        fill: #d61f33 ;
      }
    </style>
  </defs>

 <path class="cls-2" d="M10,0,0,16H20Zm1,13.91H9v-2h2Zm-2-3v-6h2v6Z"/>
</svg>';
        } else {
            return '<svg id="Yes_check" data-name="Yes check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 584.62 574.56">
  <defs>
    <style>
      .cls-1 {
        fill: url(#Naamloos_verloop);
      }
    </style>
    <radialGradient id="Naamloos_verloop" data-name="Naamloos verloop" cx="300" cy="300.55" r="292.31" gradientTransform="matrix(1, 0, 0, -0.98, 0, 595.37)" gradientUnits="userSpaceOnUse">
      <stop offset="0" stop-color="#6c4"/>
      <stop offset="1" stop-color="#6c4"/>
    </radialGradient>
  </defs>
  <path id="check" class="cls-1" d="M7.69,404.61S122.85,534.3,145.89,587.28h99C286.39,460.6,447.62,158.16,585.82,52.21c28.63-36.81-43.3-52-101.35-27.64C397,61.3,232,341.74,201.17,409.22c-43.76,11.52-89.83-73.71-89.83-73.71Z" transform="translate(-7.69 -12.72)"/>
</svg>';
        }
    }
}
