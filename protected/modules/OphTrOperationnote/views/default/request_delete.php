<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>
<?php $this->beginContent('//patient/event_container',array('no_face'=>true)); ?>

<section class="element">
  <section class="element-fields full-width">

      <?=\CHtml::form(array('Default/requestDeletion/' . $this->event->id), 'post',
          array('id' => 'deleteForm')) ?>
    <div id="delete_event">
      <h3>Request event deletion</h3>
      <div class="alert-box issue with-icon">
        <strong>This will send a request to delete the event to an admin user.</strong>
      </div>
        <?php $this->displayErrors($errors) ?>
      <div style="width:300px; margin-bottom: 0.6em;">
        <p>Reason for deletion:</p>
          <?=\CHtml::textArea('delete_reason', '', array('cols' => 40)) ?>
      </div>
      <p>
        <strong>Are you sure you want to proceed?</strong>
      </p>
        <?=\CHtml::hiddenField('event_id', $this->event->id); ?>
      <button type="submit" class="warning" id="et_deleteevent" name="et_deleteevent">
        Request deletion
      </button>
      <button type="submit" class="secondary" id="et_canceldelete" name="et_canceldelete">
        Cancel
      </button>
      <i class="loader spinner" style="display: none;"></i>
        <?=\CHtml::endForm(); ?>
    </div>
  </section>
</section>
<?php $this->endContent() ?>
<script type="text/javascript">
  $('#delete_reason').focus();
</script>
