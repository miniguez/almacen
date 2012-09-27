<?php
/** 
 * @author: WAW (wawancell@gmail.com)
 * @version: 1.0
 * Copyright (C) 2012 by WAW.
 * 
 * @description: Widget for showing flash message with auto hide using JQuery effect.
 * @setup: - copy this widget under protected/component.
 * 		   - call this widget in layout/main.php to display the message for all view.
 *         - example usage in controller: Yii::app()->user->setFlash(<type>,<message>);
 *		   - <type> : success, error, notice
 *		   - <message> : output text to displayed.
 *
 * 	This program is distributed in the hope that it will be useful,
 * 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 * 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * 	GNU Lesser General Public License for more details.
 */
 
class Flashes extends CWidget {
 
    public function run() {
		
		Yii::app()->clientScript->registerScript(
		   'myHideEffect',
		   //'$(".flashes").animate({opacity: 0.9}, 15000).fadeOut("slow");',
		   CClientScript::POS_READY
		);
                
        echo' <div id="statusMsg" >';
        echo '<div class="flashes">';
        if(Yii::app()->user->hasFlash('success')):
           echo' <div class="flash-success">';
                 echo Yii::app()->user->getFlash('success'); 
           echo' </div>';
         endif; 
        if(Yii::app()->user->hasFlash('notice')):
           echo' <div class="flash-notice">';
                 echo Yii::app()->user->getFlash('notice'); 
           echo' </div>';
         endif;
       if(Yii::app()->user->hasFlash('error')):
           echo ' <div class="flash-error">';
                 echo Yii::app()->user->getFlash('error'); 
          echo'  </div>';
         endif; 
         echo' </div>';
       echo' </div>';

         	
    }
}
?>